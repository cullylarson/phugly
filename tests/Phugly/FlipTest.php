<?php

use PHPUnit\Framework\TestCase;
use function Phugly\flip;

class FlipTest extends TestCase {
    public function testTwoArgs() {
        $f = function($x, $y) {
            return $x . $y;
        };

        $flipped = flip($f);

        $this->assertEquals($f('A', 'B'), 'AB');
        $this->assertEquals($flipped('A', 'B'), 'BA');
    }

    public function testManyArgs() {
        $f = function($w, $x, $y, $z) {
            return $w . $x . $y . $z;
        };

        $flipped = flip($f);

        $this->assertEquals($f('A', 'B', 'C', 'D'), 'ABCD');
        $this->assertEquals($flipped('A', 'B', 'C', 'D'), 'BACD');
    }

    public function testCurried() {
        $f = function($w, $x, $y, $z) {
            return $w . $x . $y . $z;
        };

        $flipped = flip($f);

        $flippedPartial = $flipped('A');

        $this->assertEquals($flippedPartial('B', 'C', 'D'), 'BACD');
    }
}
