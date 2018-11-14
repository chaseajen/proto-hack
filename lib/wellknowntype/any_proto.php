<?hh // strict
namespace google\protobuf;

// Generated by the protocol buffer compiler.  DO NOT EDIT!
// Source: any.proto

class Any implements \Protobuf\Message {
  public string $type_url;
  public string $value;

  public function __construct() {
    $this->type_url = '';
    $this->value = '';
  }

  public function MergeFrom(\Protobuf\Internal\Decoder $d): void {
    while (!$d->isEOF()) {
      list($fn, $wt) = $d->readTag();
      switch ($fn) {
        case 1:
          $this->type_url = $d->readString();
          break;
        case 2:
          $this->value = $d->readString();
          break;
        default:
          $d->skipWireType($wt);
      }
    }
  }

  public function WriteTo(\Protobuf\Internal\Encoder $e): void {
    if ($this->type_url !== '') {
      $e->writeTag(1, 2);
      $e->writeString($this->type_url);
    }
    if ($this->value !== '') {
      $e->writeTag(2, 2);
      $e->writeString($this->value);
    }
  }

  public function WriteJsonTo(\Protobuf\Internal\JsonEncoder $e): void {
    $e->writeString('type_url', 'typeUrl', $this->type_url, false);
    $e->writeBytes('value', 'value', $this->value, false);
  }

  public function MergeJsonFrom(mixed $m): void {
    if ($m === null)
      return;
    $d = \Protobuf\Internal\JsonDecoder::readObject($m);
    foreach ($d as $k => $v) {
      switch ($k) {
        case 'type_url':
        case 'typeUrl':
          $this->type_url = \Protobuf\Internal\JsonDecoder::readString($v);
          break;
        case 'value':
          $this->value = \Protobuf\Internal\JsonDecoder::readBytes($v);
          break;
      }
    }
  }
}


class XXX_FileDescriptor_any__proto
  implements \Protobuf\Internal\FileDescriptor {
  const string NAME = 'any.proto';
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
