<?php

use PHPUnit\Framework\TestCase;
use Phugly as F;
use function Phugly\rest;

class RestTest extends TestCase {
    public function testNumericIndex() {
        $x = ['a', 'b', 'c'];

        $this->assertEquals(rest(2, $x), [2 => 'c']);
    }

    public function testNumericIndexesPreserved() {
        $x = [0 => 'a', 5 => 'b', 6 => 'c'];

        $this->assertEquals(rest(2, $x), [6 => 'c']);
    }

    public function testNumericIndexesPreservedOutOfOrder() {
        $x = [100 => 'a', 15 => 'b', 6 => 'c'];

        $this->assertEquals(rest(2, $x), [6 => 'c']);
    }

    public function testAssoc() {
        $x = ['a' => 100, 'b' => 200, 'c' => 300];

        $this->assertEquals(rest(2, $x), ['c' => 300]);
    }

    public function testOutOfRange() {
        $x = ['a', 'b', 'c'];

        $this->assertEquals(rest(5, $x), []);
    }

    public function testEmpty() {
        $x = [];

        $this->assertEquals(rest(5, $x), []);
    }

    public function testNZero() {
        $x = ['a', 'b', 'c'];

        $this->assertEquals(rest(0, $x), ['a', 'b', 'c']);
    }

    public function testImmutable() {
        $x = ['a', 'b', 'c'];

        $this->assertEquals(rest(2, $x), [2 => 'c']);
        $this->assertEquals($x, ['a', 'b', 'c']);
    }

    public function testCurried() {
        $afterOne = rest(1);
        $x = ['a', 'b', 'c'];

        $this->assertEquals($afterOne($x), [1 => 'b', 2 => 'c']);
    }

    public function testStatic() {
        $rest = F\rest;
        $x = ['a', 'b', 'c'];

        $this->assertEquals($rest(2, $x), [2 => 'c']);
    }
}
