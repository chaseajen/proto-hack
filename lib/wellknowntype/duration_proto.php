<?hh // strict
namespace google\protobuf;

// Generated by the protocol buffer compiler.  DO NOT EDIT!
// Source: duration.proto

class Duration implements \Protobuf\Message {
  public int $seconds;
  public int $nanos;

  public function __construct() {
    $this->seconds = 0;
    $this->nanos = 0;
  }

  public function MergeFrom(\Protobuf\Internal\Decoder $d): void {
    while (!$d->isEOF()){
      list($fn, $wt) = $d->readTag();
      switch ($fn) {
        case 1:
          $this->seconds = $d->readVarint();
          break;
        case 2:
          $this->nanos = $d->readVarint32Signed();
          break;
        default:
          $d->skipWireType($wt);
      }
    }
  }

  public function WriteTo(\Protobuf\Internal\Encoder $e): void {
    if ($this->seconds !== 0) {
      $e->writeTag(1, 0);
      $e->writeVarint($this->seconds);
    }
    if ($this->nanos !== 0) {
      $e->writeTag(2, 0);
      $e->writeVarint($this->nanos);
    }
  }

  public function WriteJsonTo(\Protobuf\Internal\JsonEncoder $e): void {
    $e->setCustomEncoding(\Protobuf\Internal\JsonEncoder::encodeDuration($this->seconds, $this->nanos));
  }

  public function MergeJsonFrom(mixed $m): void {
    $parts = \Protobuf\Internal\JsonDecoder::readDuration($m);
    $this->seconds = $parts[0];
    $this->nanos = $parts[1];
  }
}


class XXX_FileDescriptor_duration__proto implements \Protobuf\Internal\FileDescriptor {
  const string NAME = 'duration.proto';
  const string RAW =
  'eNri4kspLUosyczP0ysoyi/JF+JPz89Pz0mF8JJK05SsuDhcoEqEJLjYi1OT8/NSiiUYFR'
  .'g1mINgXCERLta8xLz8YgkmBUYN1iAIx6mGSzg5P1cPzUgnXpiBASCRAMYorfTMkozSJL3k'
  .'/Fz99PycxLx0fZhi/YKSyoLUYn2YM38wMi5iYnYPcFrFJOcOMTcAqlQvPDUnxzsvvzwvBK'
  .'QliQ1shjEgAAD///eYTTA';
  public function Name(): string {
    return self::NAME;
  }

  public function FileDescriptorProtoBytes(): string {
    return (string)\gzuncompress(\base64_decode(self::RAW));
  }
}