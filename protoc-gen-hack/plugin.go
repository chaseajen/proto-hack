package main

import (
	ppb "../third_party/gen-src/github.com/golang/protobuf/protoc-gen-go/plugin"
	"bytes"
	"fmt"
	"github.com/golang/protobuf/proto"
	desc "github.com/golang/protobuf/protoc-gen-go/descriptor"
	"io"
	"strings"
)

const genDebug = false
const libNs = "\\Protobuf\\Internal"

func CodeGenerator(b []byte) ([]byte, error) {
	req := ppb.CodeGeneratorRequest{}
	err := proto.Unmarshal(b, &req)
	if err != nil {
		return nil, fmt.Errorf("error unmarshaling CodeGeneratorRequest: %v", err)
	}
	resp := gen(&req)
	out, err := proto.Marshal(resp)
	if err != nil {
		return nil, fmt.Errorf("error marshaling CodeGeneratorResponse: %v", err)
	}
	return out, nil
}

type writer struct {
	w io.Writer
	i int
}

func (w *writer) p(format string, a ...interface{}) {
	if strings.HasPrefix(format, "}") {
		w.i--
	}
	indent := strings.Repeat("  ", w.i)
	fmt.Fprintf(w.w, indent+format, a...)
	w.ln()
	if strings.HasSuffix(format, "{") {
		w.i++
	}
}

func (w *writer) ln() {
	fmt.Fprintln(w.w)
}

func gen(req *ppb.CodeGeneratorRequest) *ppb.CodeGeneratorResponse {
	resp := &ppb.CodeGeneratorResponse{}
	for _, fdp := range req.ProtoFile {
		f := &ppb.CodeGeneratorResponse_File{}
		packageParts := strings.Split(*fdp.Package, ".")
		f.Name = proto.String(strings.Join(append(packageParts, "proto_types.php"), "/"))
		b := &bytes.Buffer{}
		w := &writer{b, 0}

		// File header.
		w.p("<?hh // strict")
		w.p("namespace %s;", strings.Join(packageParts, "\\"))
		w.ln()
		w.p("// Generated by the protocol buffer compiler.  DO NOT EDIT!")
		w.p("// Source: %s", *fdp.Name)
		w.ln()

		// Go!
		for _, dp := range fdp.MessageType {
			err := writeDescriptor(w, dp)
			if err != nil {
				resp.Error = proto.String(err.Error())
				return resp
			}
			w.ln()
		}

		f.Content = proto.String(b.String())
		resp.File = append(resp.File, f)
	}
	return resp
}

type field struct {
	fd *desc.FieldDescriptorProto
}

func (f field) phpType() string {
	switch t := *f.fd.Type; t {
	case desc.FieldDescriptorProto_TYPE_STRING, desc.FieldDescriptorProto_TYPE_BYTES:
		return "string"
	case desc.FieldDescriptorProto_TYPE_INT64,
		desc.FieldDescriptorProto_TYPE_INT32, desc.FieldDescriptorProto_TYPE_UINT64, desc.FieldDescriptorProto_TYPE_UINT32, desc.FieldDescriptorProto_TYPE_SINT64, desc.FieldDescriptorProto_TYPE_SINT32, desc.FieldDescriptorProto_TYPE_FIXED32, desc.FieldDescriptorProto_TYPE_FIXED64, desc.FieldDescriptorProto_TYPE_SFIXED32, desc.FieldDescriptorProto_TYPE_SFIXED64:
		return "int"
	case desc.FieldDescriptorProto_TYPE_FLOAT, desc.FieldDescriptorProto_TYPE_DOUBLE:
		return "float"
	case desc.FieldDescriptorProto_TYPE_BOOL:
		return "bool"
	default:
		panic(fmt.Errorf("unexpected proto type while converting to php type: %v", t))
	}
}

func (f field) isRepeated() bool {
	return *f.fd.Label == desc.FieldDescriptorProto_LABEL_REPEATED
}

func (f field) labeledType() string {
	if f.isRepeated() {
		return "Vector<" + f.phpType() + ">"
	} else {
		return f.phpType()
	}
}

func (f field) varName() string {
	return *f.fd.Name
}

func (f field) writeDecoder(w *writer, dec, wt string) {
	// TODO should we do wiretype checking here?
	reader := ""
	isPackable := false
	switch *f.fd.Type {
	case desc.FieldDescriptorProto_TYPE_STRING, desc.FieldDescriptorProto_TYPE_BYTES:
		reader = fmt.Sprintf("%s->readRaw(%s->readVarInt128())", dec, dec)
	case desc.FieldDescriptorProto_TYPE_INT64, desc.FieldDescriptorProto_TYPE_INT32, desc.FieldDescriptorProto_TYPE_UINT64, desc.FieldDescriptorProto_TYPE_UINT32:
		reader = fmt.Sprintf("%s->readVarInt128()", dec)
		isPackable = true
	case desc.FieldDescriptorProto_TYPE_SINT64, desc.FieldDescriptorProto_TYPE_SINT32:
		reader = fmt.Sprintf("%s\\ZigZagDecode(%s->readVarInt128())", libNs, dec)
		isPackable = true
	case desc.FieldDescriptorProto_TYPE_FLOAT:
		reader = fmt.Sprintf("%s->readFloat()", dec)
		isPackable = true
	case desc.FieldDescriptorProto_TYPE_DOUBLE:
		reader = fmt.Sprintf("%s->readDouble()", dec)
		isPackable = true
	case desc.FieldDescriptorProto_TYPE_FIXED32, desc.FieldDescriptorProto_TYPE_SFIXED32:
		reader = fmt.Sprintf("%s->readFixedInt(false)", dec)
		isPackable = true
	case desc.FieldDescriptorProto_TYPE_FIXED64, desc.FieldDescriptorProto_TYPE_SFIXED64:
		reader = fmt.Sprintf("%s->readFixedInt(true)", dec)
		isPackable = true
	case desc.FieldDescriptorProto_TYPE_BOOL:
		reader = fmt.Sprintf("(%s->readVarInt128() != 0)", dec)
		isPackable = true // TODO verify
	default:
		panic(fmt.Errorf("unknown reader for fd type: %s", *f.fd.Type))
	}
	if !f.isRepeated() {
		w.p("$this->%s = %s;", f.varName(), reader)
		return
	}
	// Repeated
	if isPackable {
		w.p("if (%s == 2) {", wt)
		w.p("$packed = %s->readDecoder(%s->readVarInt128());", dec, dec)
		w.p("while (!$packed->isEOF()) {")
		w.p("$this->%s->add(%s);", f.varName(), reader)
		w.p("}")
		w.p("} else {")
	}
	w.p("$this->%s->add(%s);", f.varName(), reader)
	if isPackable {
		w.p("}")
	}
}

// https://github.com/golang/protobuf/blob/master/protoc-gen-go/descriptor/descriptor.pb.go
func writeDescriptor(w *writer, dp *desc.DescriptorProto) error {
	w.p("// message %s", *dp.Name)
	w.p("class %s extends %s\\Message {", *dp.Name, libNs)

	for _, fd := range dp.Field {
		f := field{fd}
		w.p("// field %s = %d", *fd.Name, *fd.Number)
		w.p("public %s $%s;", f.labeledType(), f.varName())
	}
	w.ln()
	w.p("public function Unmarshal(%s\\Decoder $d) {", libNs)
	w.p("while (!$d->isEOF()){")
	w.p("$k = $d->readVarInt128();")
	w.p("$fn = %s\\KeyToFieldNumber($k);", libNs)
	w.p("$wt = %s\\KeyToWireType($k);", libNs)
	if genDebug {
		w.p("echo \"unmarshal loop field:$fn wiretype:$wt\\n\";")
	}
	w.p("switch ($fn) {")
	for _, fd := range dp.Field {
		f := field{fd}
		w.p("case %d:", *fd.Number)
		w.i++
		if genDebug {
			w.p("echo \"reading field %s\\n\";", f.varName())
		}
		f.writeDecoder(w, "$d", "$wt")
		w.p("break;")
		w.i--
	}
	w.p("default:")
	w.i++
	if genDebug {
		w.p("echo \"skipping unknown field:$fn wiretype:$wt\\n\";")
	}
	w.p("%s\\Skip($d, $wt);", libNs)
	w.i--
	w.p("}") // switch
	w.p("}") // while
	w.p("}") // function fromBuffer
	w.p("}") // class
	return nil
}
