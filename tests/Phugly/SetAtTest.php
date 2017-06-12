<?php

use PHPUnit\Framework\TestCase;
use function Phugly\setAt;

class SetAtTest extends TestCase {
    public function testStringIndex() {
        $x = ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']];

        $this->assertEquals(setAt('a', 'asdf', $x), ['a' => 'asdf', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']]);
        $this->assertEquals(setAt('c', 'asdf', $x), ['a' => 'A', 'b' => 'B', 'c' => 'asdf']);
    }

    public function testNumericIndex() {
        $x = ['A', 'B', 5 => ['C', 'D']];

        $this->assertEquals(setAt(0, 'asdf', $x), ['asdf', 'B', 5 => ['C', 'D']]);
        $this->assertEquals(setAt(1, 'asdf', $x), ['A', 'asdf', 5 => ['C', 'D']]);
        $this->assertEquals(setAt(5, 'asdf', $x), ['A', 'B', 5 => 'asdf']);
        $this->assertEquals(setAt([5, 1], 'asdf', $x), ['A', 'B', 5 => ['C', 'asdf']]);
    }

    public function testArrayIndex() {
        $x = ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']];

        $this->assertEquals(setAt(['a'], 'asdf', $x), ['a' => 'asdf', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']]);
        $this->assertEquals(setAt(['c'], 'asdf', $x), ['a' => 'A', 'b' => 'B', 'c' => 'asdf']);
        $this->assertEquals(setAt(['c', 'e'], 'asdf', $x), ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'asdf']]);
    }

    public function testIndexDoesntExist() {
        $x = ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']];

        $this->assertEquals(setAt(['g'], 'asdf', $x), ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E'], 'g' => 'asdf']);
        $this->assertEquals(setAt(['g', 'h', 'i'], 'asdf', $x), ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E'], 'g' => ['h' => ['i' => 'asdf']]]);
    }

    public function testNoMutation() {
        $x = ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']];
        $y = setAt(['g', 'h', 'i'], 'asdf', $x);

        $this->assertEquals($x, ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']]);
        $this->assertEquals($y, ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E'], 'g' => ['h' => ['i' => 'asdf']]]);
    }

    public function testCurried() {
        $setAtP2 = setAt('b');
        $setAtP1 = setAt('b', 'asdf');

        $x = ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']];

        $this->assertEquals($setAtP2('qwer', $x), ['a' => 'A', 'b' => 'qwer', 'c' => ['d' => 'D', 'e' => 'E']]);
        $this->assertEquals($setAtP1($x), ['a' => 'A', 'b' => 'asdf', 'c' => ['d' => 'D', 'e' => 'E']]);
    }
}
