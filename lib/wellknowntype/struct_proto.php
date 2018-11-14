<?hh // strict
namespace google\protobuf;

// Generated by the protocol buffer compiler.  DO NOT EDIT!
// Source: struct.proto

newtype XXX_NullValue_t as int = int;
abstract class NullValue {
  const XXX_NullValue_t NULL_VALUE = 0;
  private static dict<int, string> $XXX_itos = dict[
    0 => 'NULL_VALUE',
  ];
  public static function XXX_ItoS(): dict<int, string> {
    return self::$XXX_itos;
  }
  private static dict<string, int> $XXX_stoi = dict[
    'NULL_VALUE' => 0,
  ];
  public static function XXX_FromMixed(mixed $m): XXX_NullValue_t {
    if (is_string($m))
      return idx(self::$XXX_stoi, $m, is_numeric($m) ? ((int)$m) : 0);
    if (is_int($m))
      return $m;
    return 0;
  }
  public static function XXX_FromInt(int $i): XXX_NullValue_t {
    return $i;
  }
}

class Struct_FieldsEntry implements \Protobuf\Message {
  public string $key;
  public ?\google\protobuf\Value $value;

  public function __construct() {
    $this->key = '';
    $this->value = null;
  }

  public function MergeFrom(\Protobuf\Internal\Decoder $d): void {
    while (!$d->isEOF()) {
      list($fn, $wt) = $d->readTag();
      switch ($fn) {
        case 1:
          $this->key = $d->readString();
          break;
        case 2:
          if ($this->value == null)
            $this->value = new \google\protobuf\Value();
          $this->value->MergeFrom($d->readDecoder());
          break;
        default:
          $d->skipWireType($wt);
      }
    }
  }

  public function WriteTo(\Protobuf\Internal\Encoder $e): void {
    if ($this->key !== '') {
      $e->writeTag(1, 2);
      $e->writeString($this->key);
    }
    $msg = $this->value;
    if ($msg != null) {
      $nested = new \Protobuf\Internal\Encoder();
      $msg->WriteTo($nested);
      $e->writeEncoder($nested, 2);
    }
  }

  public function WriteJsonTo(\Protobuf\Internal\JsonEncoder $e): void {
    $e->writeString('key', 'key', $this->key, false);
    $e->writeMessage('value', 'value', $this->value, false);
  }

  public function MergeJsonFrom(mixed $m): void {
    if ($m === null)
      return;
    $d = \Protobuf\Internal\JsonDecoder::readObject($m);
    foreach ($d as $k => $v) {
      switch ($k) {
        case 'key':
          $this->key = \Protobuf\Internal\JsonDecoder::readString($v);
          break;
        case 'value':
          if ($this->value == null)
            $this->value = new \google\protobuf\Value();
          $this->value->MergeJsonFrom($v);
          break;
      }
    }
  }
}

class Struct implements \Protobuf\Message {
  public dict<string, ?\google\protobuf\Value> $fields;

  public function __construct() {
    $this->fields = dict[];
  }

  public function MergeFrom(\Protobuf\Internal\Decoder $d): void {
    while (!$d->isEOF()) {
      list($fn, $wt) = $d->readTag();
      switch ($fn) {
        case 1:
          $obj = new \google\protobuf\Struct_FieldsEntry();
          $obj->MergeFrom($d->readDecoder());
          $this->fields[$obj->key] = $obj->value;
          break;
        default:
          $d->skipWireType($wt);
      }
    }
  }

  public function WriteTo(\Protobuf\Internal\Encoder $e): void {
    foreach ($this->fields as $k => $v) {
      $obj = new \google\protobuf\Struct_FieldsEntry();
      $obj->key = $k;
      $obj->value = $v;
      $nested = new \Protobuf\Internal\Encoder();
      $obj->WriteTo($nested);
      $e->writeEncoder($nested, 1);
    }
  }

  public function WriteJsonTo(\Protobuf\Internal\JsonEncoder $e): void {
    $dict = dict[];
    foreach ($this->fields as $kk => $vv) {
      $dict[$kk] = $e->encodeMessage($vv);
    }
    $e->setCustomEncoding($dict);
  }

  public function MergeJsonFrom(mixed $m): void {
    if (\is_dict($m)) {
      foreach ($m as $k => $vv) {
        $val = new \google\protobuf\Value();
        $val->MergeJsonFrom($vv);
        $this->fields[(string)$k] = $val;
      }
    }
  }
}

newtype XXX_Value_kind_enum_t = int;
interface Value_kind {
  const XXX_Value_kind_enum_t XXX_NOT_SET = 0;
  const XXX_Value_kind_enum_t null_value = 1;
  const XXX_Value_kind_enum_t number_value = 2;
  const XXX_Value_kind_enum_t string_value = 3;
  const XXX_Value_kind_enum_t bool_value = 4;
  const XXX_Value_kind_enum_t struct_value = 5;
  const XXX_Value_kind_enum_t list_value = 6;
  public function WhichOneof(): XXX_Value_kind_enum_t;
  public function WriteTo(\Protobuf\Internal\Encoder $e): void;
  public function WriteJsonTo(\Protobuf\Internal\JsonEncoder $e): void;
}

class XXX_Value_kind_NOT_SET implements Value_kind {
  public function WhichOneof(): XXX_Value_kind_enum_t {
    return self::XXX_NOT_SET;
  }

  public function WriteTo(\Protobuf\Internal\Encoder $e): void {}

  public function WriteJsonTo(\Protobuf\Internal\JsonEncoder $e): void {}
}
class Value_null_value implements Value_kind {
  public function __construct(
    public \google\protobuf\XXX_NullValue_t $null_value,
  ) {}

  public function WhichOneof(): XXX_Value_kind_enum_t {
    return self::null_value;
  }

  public function WriteTo(\Protobuf\Internal\Encoder $e): void {
    $e->writeTag(1, 0);
    ;
    $e->writeVarint($this->null_value);
  }

  public function WriteJsonTo(\Protobuf\Internal\JsonEncoder $e): void {
    $e->writeEnum(
      'null_value',
      'nullValue',
      \google\protobuf\NullValue::XXX_ItoS(),
      $this->null_value,
      true,
    );
  }
}

class Value_number_value implements Value_kind {
  public function __construct(public float $number_value) {}

  public function WhichOneof(): XXX_Value_kind_enum_t {
    return self::number_value;
  }

  public function WriteTo(\Protobuf\Internal\Encoder $e): void {
    $e->writeTag(2, 1);
    ;
    $e->writeDouble($this->number_value);
  }

  public function WriteJsonTo(\Protobuf\Internal\JsonEncoder $e): void {
    $e->writeFloat('number_value', 'numberValue', $this->number_value, true);
  }
}

class Value_string_value implements Value_kind {
  public function __construct(public string $string_value) {}

  public function WhichOneof(): XXX_Value_kind_enum_t {
    return self::string_value;
  }

  public function WriteTo(\Protobuf\Internal\Encoder $e): void {
    $e->writeTag(3, 2);
    ;
    $e->writeString($this->string_value);
  }

  public function WriteJsonTo(\Protobuf\Internal\JsonEncoder $e): void {
    $e->writeString('string_value', 'stringValue', $this->string_value, true);
  }
}

class Value_bool_value implements Value_kind {
  public function __construct(public bool $bool_value) {}

  public function WhichOneof(): XXX_Value_kind_enum_t {
    return self::bool_value;
  }

  public function WriteTo(\Protobuf\Internal\Encoder $e): void {
    $e->writeTag(4, 0);
    ;
    $e->writeBool($this->bool_value);
  }

  public function WriteJsonTo(\Protobuf\Internal\JsonEncoder $e): void {
    $e->writeBool('bool_value', 'boolValue', $this->bool_value, true);
  }
}

class Value_struct_value implements Value_kind {
  public function __construct(public \google\protobuf\Struct $struct_value) {}

  public function WhichOneof(): XXX_Value_kind_enum_t {
    return self::struct_value;
  }

  public function WriteTo(\Protobuf\Internal\Encoder $e): void {
    $nested = new \Protobuf\Internal\Encoder();
    $this->struct_value->WriteTo($nested);
    $e->writeEncoder($nested, 5);
  }

  public function WriteJsonTo(\Protobuf\Internal\JsonEncoder $e): void {
    $e->writeMessage('struct_value', 'structValue', $this->struct_value, true);
  }
}

class Value_list_value implements Value_kind {
  public function __construct(public \google\protobuf\ListValue $list_value) {}

  public function WhichOneof(): XXX_Value_kind_enum_t {
    return self::list_value;
  }

  public function WriteTo(\Protobuf\Internal\Encoder $e): void {
    $nested = new \Protobuf\Internal\Encoder();
    $this->list_value->WriteTo($nested);
    $e->writeEncoder($nested, 6);
  }

  public function WriteJsonTo(\Protobuf\Internal\JsonEncoder $e): void {
    $e->writeMessage('list_value', 'listValue', $this->list_value, true);
  }
}

class Value implements \Protobuf\Message {
  public Value_kind $kind;

  public function __construct() {
    $this->kind = new XXX_Value_kind_NOT_SET();
  }

  public function MergeFrom(\Protobuf\Internal\Decoder $d): void {
    while (!$d->isEOF()) {
      list($fn, $wt) = $d->readTag();
      switch ($fn) {
        case 1:
          $this->kind = new Value_null_value(
            \google\protobuf\NullValue::XXX_FromInt($d->readVarint()),
          );
          break;
        case 2:
          $this->kind = new Value_number_value($d->readDouble());
          break;
        case 3:
          $this->kind = new Value_string_value($d->readString());
          break;
        case 4:
          $this->kind = new Value_bool_value($d->readBool());
          break;
        case 5:
          $obj = new \google\protobuf\Struct();
          $obj->MergeFrom($d->readDecoder());
          $this->kind = new Value_struct_value($obj);
          break;
        case 6:
          $obj = new \google\protobuf\ListValue();
          $obj->MergeFrom($d->readDecoder());
          $this->kind = new Value_list_value($obj);
          break;
        default:
          $d->skipWireType($wt);
      }
    }
  }

  public function WriteTo(\Protobuf\Internal\Encoder $e): void {
    $this->kind->WriteTo($e);
  }

  public function WriteJsonTo(\Protobuf\Internal\JsonEncoder $e): void {
    if ($this->kind instanceof \google\protobuf\Value_null_value) {
      $e->setCustomEncoding(null);
      return;
    }
    if ($this->kind instanceof \google\protobuf\Value_number_value) {
      $e->setCustomEncoding($this->kind->number_value);
      return;
    }
    if ($this->kind instanceof \google\protobuf\Value_string_value) {
      $e->setCustomEncoding($this->kind->string_value);
      return;
    }
    if ($this->kind instanceof \google\protobuf\Value_bool_value) {
      $e->setCustomEncoding($this->kind->bool_value);
      return;
    }
    if ($this->kind instanceof \google\protobuf\Value_list_value) {
      $e->setCustomEncoding($e->encodeMessage($this->kind->list_value));
      return;
    }
    if ($this->kind instanceof \google\protobuf\Value_struct_value) {
      $e->setCustomEncoding($e->encodeMessage($this->kind->struct_value));
      return;
    }
  }

  public function MergeJsonFrom(mixed $m): void {
    if ($m === null) {
      $this->kind = new \google\protobuf\Value_null_value(
        \google\protobuf\NullValue::NULL_VALUE,
      );
    } else if (is_string($m)) {
      $this->kind = new \google\protobuf\Value_string_value($m);
    } else if (is_bool($m)) {
      $this->kind = new \google\protobuf\Value_bool_value($m);
    } else if (is_numeric($m)) {
      $this->kind = new \google\protobuf\Value_number_value((float)$m);
    } else if (\is_vec($m)) {
      $lv = new \google\protobuf\ListValue();
      $lv->MergeJsonFrom($m);
      $this->kind = new \google\protobuf\Value_list_value($lv);
    } else if (\is_dict($m)) {
      $struct = new \google\protobuf\Struct();
      $struct->MergeJsonFrom($m);
      $this->kind = new \google\protobuf\Value_struct_value($struct);
    }
  }
}

class ListValue implements \Protobuf\Message {
  public vec<\google\protobuf\Value> $values;

  public function __construct() {
    $this->values = vec[];
  }

  public function MergeFrom(\Protobuf\Internal\Decoder $d): void {
    while (!$d->isEOF()) {
      list($fn, $wt) = $d->readTag();
      switch ($fn) {
        case 1:
          $obj = new \google\protobuf\Value();
          $obj->MergeFrom($d->readDecoder());
          $this->values[] = $obj;
          break;
        default:
          $d->skipWireType($wt);
      }
    }
  }

  public function WriteTo(\Protobuf\Internal\Encoder $e): void {
    foreach ($this->values as $msg) {
      $nested = new \Protobuf\Internal\Encoder();
      $msg->WriteTo($nested);
      $e->writeEncoder($nested, 1);
    }
  }

  public function WriteJsonTo(\Protobuf\Internal\JsonEncoder $e): void {
    $vec = vec[];
    foreach ($this->values as $lv) {
      $vec[] = $e->encodeMessage($lv);
    }
    $e->setCustomEncoding($vec);
  }

  public function MergeJsonFrom(mixed $m): void {
    if (\is_vec($m)) {
      foreach ($m as $vv) {
        $val = new \google\protobuf\Value();
        $val->MergeJsonFrom($vv);
        $this->values[] = $val;
      }
    }
  }
}


class XXX_FileDescriptor_struct__proto
  implements \Protobuf\Internal\FileDescriptor {
  const string NAME = 'struct.proto';
  const string
    RAW =
      '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';
  public function Name(): string {
    return self::NAME;
  }

  public function FileDescriptorProtoBytes(): string {
    return (string)\gzuncompress(\base64_decode(self::RAW));
  }
}
