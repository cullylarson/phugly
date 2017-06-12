<?php

use PHPUnit\Framework\TestCase;
use function Phugly\repeat;

class RepeatTest extends TestCase {
    public function testRunsNTimes() {
        $count = 0;

        $f = function() use (&$count) {
            $count++;
        };

        repeat($f, 27, null);

        $this->assertEquals($count, 27);
    }

    public function testTakesParam() {
        $count = 0;

        $f = function($x) use (&$count) {
            $count++;

            return $x . $count;
        };

        $this->assertEquals(repeat($f, 7, 'A'), ['A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7']);
    }

    public function testReturnsResults() {
        $f = function() {
            return 19;
        };

        $this->assertEquals(repeat($f, 7, null), [19, 19, 19, 19, 19, 19, 19]);
    }
}
