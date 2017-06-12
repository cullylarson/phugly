<?php

use PHPUnit\Framework\TestCase;
use Phugly as F;
use function Phugly\bookend;
use function Phugly\first;
use function Phugly\last;

class BookendTest extends TestCase {
    public function testString() {
        $this->assertEquals(bookend('A', 'Z', 'asdf'), 'AasdfZ');
    }

    public function testArray() {
        $x = ['a', 'b', 'c'];

        $result = bookend('1', '9', $x);

        $this->assertEquals($result, ['1', 'a', 'b', 'c', '9']);
        $this->assertEquals($result[0], '1');
        $this->assertEquals($result[count($result)-1], '9');
    }

    public function testAssocArray() {
        $x = ['a' => 'X', 'b' => 'Y', 'c' => 'Z'];

        $result = bookend('1', '9', $x);

        $this->assertEquals($result, ['1', 'a' => 'X', 'b' => 'Y', 'c' => 'Z', '9']);
        $this->assertEquals(first($result), '1');
        $this->assertEquals(last($result), '9');
    }

    public function testCurried() {
        $x = ['a', 'b', 'c'];

        $f = bookend('1', '9');

        $result = $f($x);

        $this->assertEquals($result, ['1', 'a', 'b', 'c', '9']);
        $this->assertEquals($result[0], '1');
        $this->assertEquals($result[count($result)-1], '9');
    }

    public function testStatic() {
        $f = F\bookend;

        $x = ['a', 'b', 'c'];

        $result = $f('1', '9', $x);

        $this->assertEquals($result, ['1', 'a', 'b', 'c', '9']);
        $this->assertEquals($result[0], '1');
        $this->assertEquals($result[count($result)-1], '9');
    }
}
