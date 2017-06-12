<?php

use PHPUnit\Framework\TestCase;
use Phugly as F;
use function Phugly\firstN;

class FirstNTest extends TestCase {
    public function testNumericIndex() {
        $x = ['a', 'b', 'c'];

        $this->assertEquals(firstN(2, $x), ['a', 'b']);
    }

    public function testNumericIndexesPreserved() {
        $x = [0 => 'a', 5 => 'b', 6 => 'c'];

        $this->assertEquals(firstN(2, $x), [0 => 'a', 5 => 'b']);
    }

    public function testNumericIndexesPreservedOutOfOrder() {
        $x = [100 => 'a', 15 => 'b', 6 => 'c'];

        $this->assertEquals(firstN(2, $x), [100 => 'a', 15 => 'b']);
    }

    public function testAssoc() {
        $x = ['a' => 100, 'b' => 200, 'c' => 300];

        $this->assertEquals(firstN(2, $x), ['a' => 100, 'b' => 200]);
    }

    public function testOutOfRange() {
        $x = ['a', 'b', 'c'];

        $this->assertEquals(firstN(5, $x), ['a', 'b', 'c']);
    }

    public function testEmpty() {
        $x = [];

        $this->assertEquals(firstN(5, $x), []);
    }

    public function testNZero() {
        $x = ['a', 'b', 'c'];

        $this->assertEquals(firstN(0, $x), []);
    }

    public function testImmutable() {
        $x = ['a', 'b', 'c'];

        $this->assertEquals(firstN(2, $x), ['a', 'b']);
        $this->assertEquals($x, ['a', 'b', 'c']);
    }

    public function testCurried() {
        $firstTwo = firstN(2);
        $x = ['a', 'b', 'c'];

        $this->assertEquals($firstTwo($x), ['a', 'b']);
    }

    public function testStatic() {
        $firstN = F\firstN;
        $x = ['a', 'b', 'c'];

        $this->assertEquals($firstN(2, $x), ['a', 'b']);
    }
}
