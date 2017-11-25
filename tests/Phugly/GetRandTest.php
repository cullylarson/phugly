<?php

use PHPUnit\Framework\TestCase;
use function Phugly\getRand;

class GetRandTest extends TestCase {
    public function testValueIsInArray() {
        $x = [
            'a' => 'A',
            'b' => 'B',
            'c' => 'C',
        ];

        $y = [
            'X',
            'Y',
            'Z',
        ];

        $this->assertSame(in_array(getRand($x), $x), true);
        $this->assertSame(in_array(getRand($y), $y), true);
    }

    public function testEmptyArray() {
        $x = [];

        $this->assertSame(getRand($x), null);
    }
}
