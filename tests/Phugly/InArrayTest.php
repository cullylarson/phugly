<?php

use PHPUnit\Framework\TestCase;
use function Phugly\inArray;

class InArrayTest extends TestCase {
    public function testSimple() {
        $x = ['a', 'b', 'c'];

        $this->assertEquals(inArray($x, '3'), false);
        $this->assertEquals(inArray($x, 'a'), true);
    }

    public function testCurry() {
        $x = ['a', 'b', 'c'];

        $inArrayX = inArray($x);

        $this->assertEquals($inArrayX('3'), false);
        $this->assertEquals($inArrayX('a'), true);
    }
}
