<?php

use PHPUnit\Framework\TestCase;
use function Phugly\also;
use Phugly as F;

class AlsoTest extends TestCase {
    public function testSimple() {
        $f1 = function($x) { return $x; };
        $f2 = function($x) { return true; };

        $this->assertEquals(also($f1, $f2, true), true);
        $this->assertEquals(also($f1, $f2, false), false);
        $this->assertEquals(also($f2, $f1, true), true);
        $this->assertEquals(also($f2, $f1, false), false);
    }

    public function testSimpleTwo() {
        $f1 = function($x) { return $x; };
        $f2 = function($x) { return !$x; };

        $this->assertEquals(also($f1, $f2, true), false);
        $this->assertEquals(also($f1, $f2, false), false);
    }

    public function testSimpleThree() {
        $f1 = function($x) { return is_array($x); };
        $f2 = function($x) { return count($x) === 3; };

        $this->assertEquals(also($f1, $f2, [1,2]), false);
        $this->assertEquals(also($f1, $f2, "asdf"), false);
        $this->assertEquals(also($f1, $f2, "asd"), false);
        $this->assertEquals(also($f1, $f2, [1,2,3]), true);
        $this->assertEquals(also($f1, $f2, ['one',2,3]), true);
        $this->assertEquals(also($f1, $f2, ['one',2,[3, 4]]), true);
    }

    public function testCurried() {
        $f1 = function($x) { return is_array($x); };
        $f2 = function($x) { return count($x) === 3; };

        $alsoApplied = also($f1, $f2);

        $this->assertEquals($alsoApplied([1,2]), false);
        $this->assertEquals($alsoApplied("asdf"), false);
        $this->assertEquals($alsoApplied("asd"), false);
        $this->assertEquals($alsoApplied([1,2,3]), true);
        $this->assertEquals($alsoApplied(['one',2,3]), true);
        $this->assertEquals($alsoApplied(['one',2,[3, 4]]), true);
    }

    public function testStatic() {
        $also = F\also;

        $f1 = function($x) { return is_array($x); };
        $f2 = function($x) { return count($x) === 3; };

        $this->assertEquals($also($f1, $f2, [1,2]), false);
        $this->assertEquals($also($f1, $f2, "asdf"), false);
        $this->assertEquals($also($f1, $f2, "asd"), false);
        $this->assertEquals($also($f1, $f2, [1,2,3]), true);
        $this->assertEquals($also($f1, $f2, ['one',2,3]), true);
        $this->assertEquals($also($f1, $f2, ['one',2,[3, 4]]), true);
    }
}
