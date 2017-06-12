<?php

use PHPUnit\Framework\TestCase;
use Phugly as F;
use function Phugly\camelKey;

class CamelKeyTest extends TestCase {
    public function testSimple() {
        $x = ['a', 'X', 'b', 'Y', 'c', 'Z'];

        $this->assertEquals(camelKey($x), ['a' => 'X', 'b' => 'Y', 'c' => 'Z']);
    }

    public function testStatic() {
        $x = ['a', 'X', 'b', 'Y', 'c', 'Z'];

        $f = F\camelKey;

        $this->assertEquals($f($x), ['a' => 'X', 'b' => 'Y', 'c' => 'Z']);
    }
}
