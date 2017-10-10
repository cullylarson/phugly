<?php

use PHPUnit\Framework\TestCase;
use function Phugly\tail;

class TailTest extends TestCase {
    public function testRemovesFirstItem() {
        $x = [1, 2, 3];
        $this->assertEquals(array_values(tail($x)), [2, 3]);
    }

    public function testEmptyArrayStayEmpty() {
        $x = [];
        $this->assertEquals(tail($x), []);
    }

    public function testPreservesKeys() {
        $x = [1, 2, 3];
        $this->assertEquals(tail($x), [1 => 2, 2 => 3]);
    }
}
