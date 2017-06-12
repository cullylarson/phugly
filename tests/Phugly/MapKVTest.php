<?php

use PHPUnit\Framework\TestCase;
use function Phugly\mapKV;
use function Phugly\call;
use function Phugly\compose;
use function Phugly\getAt;
use function Phugly\last;
use function Phugly\first;

class MapKVTest extends TestCase {
    public function testSimplyMaps() {
        $x = ['X', 'Y', 'Z'];

        $f = function($key, $val) {
            return $val . '7';
        };

        $this->assertEquals(mapKV($f, $x), ['X7', 'Y7', 'Z7']);
    }

    public function testPreservesKeys() {
        $x = ['a' => 'X', 'b' => 'Y', 'c' => 'Z'];

        $f = function($key, $val) {
            return $val . '7';
        };

        $this->assertEquals(mapKV($f, $x), ['a' => 'X7', 'b' => 'Y7', 'c' => 'Z7']);
    }

    public function testPassesKeys() {
        $x = ['a' => 'X', 'b' => 'Y', 'c' => 'Z'];

        $f = function($key, $val) {
            return $key . $val;
        };

        $this->assertEquals(mapKV($f, $x), ['a' => 'aX', 'b' => 'bY', 'c' => 'cZ']);
    }

    public function testPreservesOrder() {
        $x = ['a' => 'X', 'b' => 'Y', 'c' => 'Z'];

        $f = function($key, $val) {
            return $key . $val;
        };

        $firstResult = call(compose(getAt(0, null), 'array_values', mapKV($f)), $x);

        $this->assertEquals($firstResult, 'aX');
        $this->assertEquals(first(mapKV($f, $x)), 'aX');
        $this->assertEquals(last(mapKV($f, $x)), 'cZ');
    }
}
