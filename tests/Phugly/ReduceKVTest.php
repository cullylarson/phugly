<?php

use PHPUnit\Framework\TestCase;
use function Phugly\reduceKV;

class ReduceKeyValTest extends TestCase {
    public function testSimplyReduces() {
        $x = [1, 5, 10];

        $f = function($acc, $key, $val) {
            return $acc + $val;
        };

        $this->assertEquals(reduceKV($f, 0, $x), 16);
    }

    public function testGetsKeys() {
        $x = ['a' => 'one', 'b' => 'two', 'c' => 'three'];

        $f = function($acc, $key, $val) {
            return $acc . $key;
        };

        $this->assertEquals(reduceKV($f, "", $x), 'abc');
    }

    public function testKeysAndValues() {
        $x = ['a' => 'X', 'b' => 'Y', 'c' => 'Z'];

        $f = function($acc, $key, $val) {
            return $acc . $key . $val;
        };

        $this->assertEquals(reduceKV($f, "", $x), 'aXbYcZ');
    }
}
