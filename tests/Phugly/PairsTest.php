<?php

use PHPUnit\Framework\TestCase;
use function Phugly\pairs;

class PairsTest extends TestCase {
    public function testAssoc() {
        $x = ['a' => 'X', 'b' => 'Y', 'c' => 'Z'];

        $this->assertEquals(pairs($x), [['a', 'X'], ['b', 'Y'], ['c', 'Z']]);
    }

    public function testNumeric() {
        $x = ['X', 'Y', 'Z'];

        $this->assertEquals(pairs($x), [[0, 'X'], [1, 'Y'], [2, 'Z']]);
    }
}
