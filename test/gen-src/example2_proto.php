<?hh // strict
namespace fiz\baz;

// Generated by the protocol buffer compiler.  DO NOT EDIT!
// Source: example2.proto

newtype AEnum2_EnumType as int = int;
class AEnum2 {
  const AEnum2_EnumType Z = 0;
  public static function FromInt(int $i): AEnum2_EnumType {
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
          $this->zomg = $d->readVarInt128();
          break;
        default:
          $d->skipWireType($wt);
      }
    }
  }

  public function WriteTo(\Protobuf\Internal\Encoder $e): void {
    if ($this->zomg !== 0) {
      $e->writeTag(1, 0);
      $e->writeVarInt128($this->zomg);
    }
  }
}

