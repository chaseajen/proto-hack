<?hh // strict
namespace fiz\baz;

// Generated by the protocol buffer compiler.  DO NOT EDIT!
// Source: example2.proto

newtype XXX_AEnum2_t as int = int;
class AEnum2 {
  const XXX_AEnum2_t Z = 0;
  private static dict<int, string> $itos = dict[
    0 => 'Z',
  ];
  public static function NumbersToNames(): dict<int, string> {
    return self::$itos;
  }
  public static function FromInt(int $i): XXX_AEnum2_t {
    return $i;
  }
}

// message example2
class example2 implements \Protobuf\Message {
  // field zomg = 1
  public int $zomg;

  public function __construct() {
    $this->zomg = 0;
  }

  public function MergeFrom(\Protobuf\Internal\Decoder $d): void {
    while (!$d->isEOF()){
      list($fn, $wt) = $d->readTag();
      switch ($fn) {
        case 1:
          $this->zomg = $d->readVarint32Signed();
          break;
        default:
          $d->skipWireType($wt);
      }
    }
  }

  public function WriteTo(\Protobuf\Internal\Encoder $e): void {
    if ($this->zomg !== 0) {
      $e->writeTag(1, 0);
      $e->writeVarint($this->zomg);
    }
  }
  public function WriteJsonTo(\Protobuf\Internal\JsonEncoder $e): void {
    $e->writeInt32('zomg', 'zomg', $this->zomg);
  }
}


class XXX_FileDescriptor_example2__proto implements \Protobuf\Internal\FileDescriptor {
  const string NAME = 'example2.proto';
  const string RAW = 'NI+9SsRQEIXn9+bmbDRxKisRK7HYYn0CCxtLS7tdWEUwZhEFyav5cnITbnc+zsw3DM6Pv/vx9HHcbU9f0/cUzev7vD3s55sr5FpFwOZpfLvka7715yXf9UgPj58/4y4c/DLQ0x8jhRGBkcFdKFGUJKGSewBiFGaUGIAacajlARuYkVCoywXO4AUszMUC3YpeyqYSh3ruKmmo90OxO4Xlch1QL1PZN8Xui72VXFZ8FbSilSS0Tc0hLe/f/wMAAP//';
  public function Name(): string {
    return self::NAME;
  }

  public function FileDescriptorProtoBytes(): string {
    return (string)\gzdeflate(\base64_decode(self::RAW));
  }
}
