<?php

use PHPUnit\Framework\TestCase;
use function Phugly\filter;

class FilterTest extends TestCase {
    public function testSimple() {
        $xs = ['a', 1, 'b', 2, 'c', 3];

        $fInt = function($x) { return is_int($x); };
        $fString = function($x) { return is_string($x); };

        $this->assertEquals(filter($fInt, $xs), [1 => 1, 3 => 2, 5 => 3]);
        $this->assertEquals(filter($fString, $xs), [0 => 'a', 2 => 'b', 4 => 'c']);
    }

    public function testCurry() {
        $xs = ['a', 1, 'b', 2, 'c', 3];

        $f = function($x) { return is_int($x); };

        $filterF = filter($f);

        $this->assertEquals($filterF($xs), [1 => 1, 3 => 2, 5 => 3]);
    }
}
