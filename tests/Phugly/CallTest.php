<?php

use PHPUnit\Framework\TestCase;
use function Phugly\call;

class CallTest extends TestCase {
    public function testSimple() {
        $f = function($x, $y, $z) {
            return $x + $y + $z;
        };

        $this->assertEquals(call($f, 1, 5, 20), 26);
    }
}
