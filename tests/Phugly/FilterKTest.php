<?php

use PHPUnit\Framework\TestCase;
use function Phugly\filterK;

class FilterKTest extends TestCase {
    public function testSimple() {
        $xs = ['a' => 'A', 1 => 'One', 'b' => 'B', 5 => 'Five'];

        $f = function($key) { return is_int($key); };

        $this->assertEquals(filterK($f, $xs), [1 => 'One', 5 => 'Five']);
    }

    public function testCurry() {
        $xs = ['a' => 'A', 1 => 'One', 'b' => 'B', 5 => 'Five'];

        $f = function($key) { return is_int($key); };

        $filterKF = filterK($f);

        $this->assertEquals($filterKF($xs), [1 => 'One', 5 => 'Five']);
    }
}
