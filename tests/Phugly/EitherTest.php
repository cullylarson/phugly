<?php

use PHPUnit\Framework\TestCase;
use function Phugly\either;
use Phugly as F;

class EitherTest extends TestCase {
    public function testSimple() {
        $f1 = function($x) { return $x; };
        $f2 = function($x) { return true; };

        $this->assertEquals(either($f1, $f2, true), true);
        $this->assertEquals(either($f1, $f2, false), true);
        $this->assertEquals(either($f2, $f1, true), true);
        $this->assertEquals(either($f2, $f1, false), true);
    }

    public function testSimpleTwo() {
        $f1 = function($x) { return $x; };
        $f2 = function($x) { return !$x; };

        $this->assertEquals(either($f1, $f2, true), true);
        $this->assertEquals(either($f1, $f2, false), true);
    }

    public function testSimpleThree() {
        $f1 = function($x) { return is_array($x); };
        $f2 = function($x) { return count($x) === 3 || strlen($x) === 3; };

        $this->assertEquals(either($f1, $f2, [1,2]), true);
        $this->assertEquals(either($f1, $f2, "asdf"), false);
        $this->assertEquals(either($f1, $f2, "asd"), true);
        $this->assertEquals(either($f1, $f2, [1,2,3]), true);
        $this->assertEquals(either($f1, $f2, ['one',2,3]), true);
        $this->assertEquals(either($f1, $f2, ['one',2,[3, 4]]), true);
        $this->assertEquals(either($f1, $f2, ['one',2,[3, 4],'blah']), true);
    }

    public function testSimpleFour() {
        $f1 = function($x) { return $x; };
        $f2 = function($x) { return false; };

        $this->assertEquals(either($f1, $f2, true), true);
        $this->assertEquals(either($f1, $f2, false), false);
        $this->assertEquals(either($f2, $f1, true), true);
        $this->assertEquals(either($f2, $f1, false), false);
    }

    public function testCurried() {
        $f1 = function($x) { return is_array($x); };
        $f2 = function($x) { return count($x) === 3 || strlen($x) === 3; };

        $eitherApplied = either($f1, $f2);

        $this->assertEquals($eitherApplied([1,2]), true);
        $this->assertEquals($eitherApplied("asdf"), false);
        $this->assertEquals($eitherApplied("asd"), true);
        $this->assertEquals($eitherApplied([1,2,3]), true);
        $this->assertEquals($eitherApplied(['one',2,3]), true);
        $this->assertEquals($eitherApplied(['one',2,[3, 4]]), true);
        $this->assertEquals($eitherApplied(['one',2,[3, 4]],'blah'), true);
    }

    public function testStatic() {
        $either = F\either;

        $f1 = function($x) { return is_array($x); };
        $f2 = function($x) { return count($x) === 3 || strlen($x) === 3; };

        $this->assertEquals($either($f1, $f2, [1,2]), true);
        $this->assertEquals($either($f1, $f2, "asdf"), false);
        $this->assertEquals($either($f1, $f2, "asd"), true);
        $this->assertEquals($either($f1, $f2, [1,2,3]), true);
        $this->assertEquals($either($f1, $f2, ['one',2,3]), true);
        $this->assertEquals($either($f1, $f2, ['one',2,[3, 4]]), true);
        $this->assertEquals($either($f1, $f2, ['one',2,[3, 4],'blah']), true);
    }
}
