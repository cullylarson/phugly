<?php

use PHPUnit\Framework\TestCase;
use function Phugly\append;

class AppendTest extends TestCase {
    public function testStringIndex() {
        $x = ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']];

        $this->assertEquals(append('a', 'asdf', $x), ['a' => ['A', 'asdf'], 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']]);
        $this->assertEquals(append('c', 'asdf', $x), ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E', 'asdf']]);
    }

    public function testNullIndex() {
        $x = ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']];

        $this->assertEquals(append(null, 'asdf', $x), ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E'], 'asdf']);
    }

    public function testNumericIndex() {
        $x = ['A', 'B', 5 => ['C', 'D']];

        $this->assertEquals(append(0, 'asdf', $x), [['A', 'asdf'], 'B', 5 => ['C', 'D']]);
        $this->assertEquals(append(1, 'asdf', $x), ['A', ['B', 'asdf'], 5 => ['C', 'D']]);
        $this->assertEquals(append(5, 'asdf', $x), ['A', 'B', 5 => ['C', 'D', 'asdf']]);
        $this->assertEquals(append([5, 1], 'asdf', $x), ['A', 'B', 5 => ['C', ['D', 'asdf']]]);
    }

    public function testArrayIndex() {
        $x = ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']];

        $this->assertEquals(append(['a'], 'asdf', $x), ['a' => ['A', 'asdf'], 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']]);
        $this->assertEquals(append(['c'], 'asdf', $x), ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E', 'asdf']]);
        $this->assertEquals(append(['c', 'e'], 'asdf', $x), ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => ['E', 'asdf']]]);
    }

    public function testIndexDoesntExist() {
        $x = ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']];

        $this->assertEquals(append(['g'], 'asdf', $x), ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E'], 'g' => ['asdf']]);
        $this->assertEquals(append(['g', 'h', 'i'], 'asdf', $x), ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E'], 'g' => ['h' => ['i' => ['asdf']]]]);
    }

    public function testNoMutation() {
        $x = ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']];
        $y = append(['g', 'h', 'i'], 'asdf', $x);

        $this->assertEquals($x, ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']]);
        $this->assertEquals($y, ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E'], 'g' => ['h' => ['i' => ['asdf']]]]);
    }

    public function testCurried() {
        $appendP2 = append(['a']);
        $appendP1 = append(['a'], 'asdf');

        $x = ['a' => 'A', 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']];

        $this->assertEquals($appendP2('qwer', $x), ['a' => ['A', 'qwer'], 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']]);
        $this->assertEquals($appendP1($x), ['a' => ['A', 'asdf'], 'b' => 'B', 'c' => ['d' => 'D', 'e' => 'E']]);
    }
}
