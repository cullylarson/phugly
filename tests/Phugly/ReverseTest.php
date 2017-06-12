<?php

use PHPUnit\Framework\TestCase;
use function Phugly\reverse;
use function Phugly\first;
use function Phugly\last;

class ReverseTest extends TestCase {
    function testNumericKeys() {
        $x = ['A', 'B', 'C', 'D'];

        $result = reverse($x);

        $this->assertEquals(first($result), 'D');
        $this->assertEquals(last($result), 'A');
    }

    function testAssoc() {
        $x = ['a' => 'X', 'b' => 'Y', 'c' => 'Z'];

        $result = reverse($x);

        $this->assertEquals(first($result), 'Z');
        $this->assertEquals(last($result), 'X');
    }
}
