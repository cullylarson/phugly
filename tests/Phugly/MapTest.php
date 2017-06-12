<?php

use PHPUnit\Framework\TestCase;
use Phugly as F;
use function Phugly\map;
use function Phugly\first;
use function Phugly\last;

class MapTest extends TestCase {
    public function testMapsArray() {
        $x = ['X', 'Y', 'Z'];

        $f = function($val) { return $val . '7'; };

        $this->assertEquals(map($f, $x), ['X7', 'Y7', 'Z7']);
    }

    public function testMapsFunctor() {
        $x = 'X';

        $f = function($val) { return $val . '7'; };

        $functor = new Functor($x);

        $this->assertEquals(map($f, $functor), 'X7');
    }

    public function testPreservesOrder() {
        $x = ['X', 'Y', 'Z'];

        $result = map(F\id, $x);

        // use first and last because if you use indexes, you don't really know what the actual ordering of the results are
        $this->assertEquals(first($result), 'X');
        $this->assertEquals(last($result), 'Z');
    }
}

class Functor {
    private $x;
    public function __construct($x) { $this->x = $x; }
    public function map($f) { return $f($this->x); }
}
