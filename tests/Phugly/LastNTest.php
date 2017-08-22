<?php

use PHPUnit\Framework\TestCase;
use Phugly as F;
use function Phugly\lastN;

class LastNTest extends TestCase {
    public function testNumericIndex() {
        $x = ['a', 'b', 'c'];

        $this->assertEquals(lastN(2, $x), [1 => 'b', 2 => 'c']);
    }

    public function testNumericIndexesPreserved() {
        $x = [0 => 'a', 5 => 'b', 6 => 'c'];

        $this->assertEquals(lastN(2, $x), [5 => 'b', 6 => 'c']);
    }

    public function testNumericIndexesPreservedOutOfOrder() {
        $x = [100 => 'a', 15 => 'b', 6 => 'c'];

        $this->assertEquals(lastN(2, $x), [15 => 'b', 6 => 'c']);
    }

    public function testAssoc() {
        $x = ['a' => 100, 'b' => 200, 'c' => 300];

        $this->assertEquals(lastN(2, $x), ['b' => 200, 'c' => 300]);
    }

    public function testOutOfRange() {
        $x = ['a', 'b', 'c'];

        $this->assertEquals(lastN(5, $x), ['a', 'b', 'c']);
    }

    public function testEmpty() {
        $x = [];

        $this->assertEquals(lastN(5, $x), []);
    }

    public function testNZero() {
        $x = ['a', 'b', 'c'];

        $this->assertEquals(lastN(0, $x), []);
    }

    public function testImmutable() {
        $x = ['a', 'b', 'c'];

        $this->assertEquals(lastN(2, $x), [1 => 'b', 2 => 'c']);
        $this->assertEquals($x, ['a', 'b', 'c']);
    }

    public function testCurried() {
        $lastTwo = lastN(2);
        $x = ['a', 'b', 'c'];

        $this->assertEquals($lastTwo($x), [1 => 'b', 2 => 'c']);
    }

    public function testStatic() {
        $lastN = F\lastN;
        $x = ['a', 'b', 'c'];

        $this->assertEquals($lastN(2, $x), [1 => 'b', 2 =>'c']);
    }

    public function testAddMoreValues() {
        $x = ['a' => 'A', 'b' => 'B', 'c' => 'C'];

        $this->assertEquals(lastN(2, $x), ['b' => 'B', 'c' => 'C']);

        $x['d'] = 'D';

        $this->assertEquals(lastN(2, $x), ['c' => 'C', 'd' => 'D']);
    }
}
