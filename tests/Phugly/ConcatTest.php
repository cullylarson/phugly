<?php

use PHPUnit\Framework\TestCase;
use Phugly as F;
use function Phugly\concat;
use function Phugly\flip;

class ConcatTest extends TestCase {
    public function testSimple() {
        $this->assertEquals(concat("asdf", "qwer"), "asdfqwer");
    }

    public function testEmpty() {
        $this->assertEquals(concat("asdf", ""), "asdf");
        $this->assertEquals(concat("", "asdf"), "asdf");
    }

    public function testFlipped() {
        $flipped = flip(F\concat);
        $this->assertEquals(concat("123", "456"), "123456");
        $this->assertEquals($flipped("123", "456"), "456123");
    }

    public function testCurried() {
        $prefixAsdf = concat("asdf");

        $this->assertEquals($prefixAsdf("123"), "asdf123");
    }

    public function testStatic() {
        $concat = F\concat;

        $this->assertEquals($concat("123", "456"), "123456");
    }
}
