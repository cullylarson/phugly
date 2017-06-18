<?php

use PHPUnit\Framework\TestCase;
use Phugly as F;
use function Phugly\getThese;

class GetTheseTest extends TestCase {

    public function testKeysExist() {
        $x = [
            'a' => 'A',
            'b' => 'B',
            'c' => 'C',
        ];

        $this->assertEquals(getThese(['a' => 'asdf', 'c' => 'qwer'], $x), ['a' => 'A', 'c' => 'C']);
        $this->assertEquals(getThese(['b' => 'asdf'], $x), ['b' => 'B']);
    }

    public function testKeysDontExist() {
        $x = [
            'a' => 'A',
            'b' => 'B',
            'c' => 'C',
        ];

        $this->assertEquals(getThese(['d' => 'asdf', 'e' => 'qwer'], $x), ['d' => 'asdf', 'e' => 'qwer']);
    }

    public function someKeysExist() {
        $x = [
            'a' => 'A',
            'b' => 'B',
            'c' => 'C',
        ];

        $this->assertEquals(getThese(['a' => 'foo', 'c' => 'blah', 'd' => 'asdf', 'e' => 'qwer'], $x), ['a' => 'A', 'c' => 'C', 'd' => 'asdf', 'e' => 'qwer']);
    }

    public function testNumericIndexes() {
        $x = ['A', 'B', 'C'];

        $this->assertEquals(getThese([0 => 'asdf', 2 => 'blah'], $x), [0 => 'A', 2 => 'C']);
        $this->assertEquals(getThese([0 => 'asdf', 3 => 'blah'], $x), [0 => 'A', 3 => 'blah']);
    }

    public function testCurried() {
        $x = [
            'a' => 'A',
            'b' => 'B',
            'c' => 'C',
        ];

        $getTheseP1 = getThese(['a' => 'foo', 'c' => 'blah', 'd' => 'asdf', 'e' => 'qwer']);

        $this->assertEquals($getTheseP1($x), ['a' => 'A', 'c' => 'C', 'd' => 'asdf', 'e' => 'qwer']);
    }

    public function testStatic() {
        $getThese = F\getThese;

        $x = [
            'a' => 'A',
            'b' => 'B',
            'c' => 'C',
        ];

        $this->assertEquals($getThese(['a' => 'foo', 'c' => 'blah', 'd' => 'asdf', 'e' => 'qwer'], $x), ['a' => 'A', 'c' => 'C', 'd' => 'asdf', 'e' => 'qwer']);
    }
}
