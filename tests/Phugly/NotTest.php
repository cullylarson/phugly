<?php

use PHPUnit\Framework\TestCase;
use Phugly as F;
use function Phugly\not;

class NotTest extends TestCase {
    public function testIdentity() {
        $this->assertEquals(not(F\id, true), false);
        $this->assertEquals(not(F\id, false), true);
    }

    public function testArraySize() {
        $f = function($x) { return count($x) === 3; };

        $this->assertEquals(not($f, [1, 2, 3]), false);
        $this->assertEquals(not($f, [1, 2]), true);
        $this->assertEquals(not($f, "asdf"), true);
    }

    public function testCurried() {
        $notApplied = not(F\id);

        $this->assertEquals($notApplied(true), false);
        $this->assertEquals($notApplied(false), true);
    }

    public function testStatic() {
        $not = F\not;

        $this->assertEquals($not(F\id, true), false);
        $this->assertEquals($not(F\id, false), true);
    }
}
