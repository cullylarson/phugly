<?php

use PHPUnit\Framework\TestCase;
use Phugly as F;
use function Phugly\liftF;

class LiftFTest extends TestCase {
    public function testSimple() {
        $f = liftF(function($x) {
            return $x . 'A';
        });

        $fCalled = $f('X');

        $this->assertEquals($fCalled(), 'XA');
    }

    public function testStatic() {
        $lF = F\liftF;

        $f = $lF(function($x) {
            return $x . 'A';
        });

        $fCalled = $f('X');

        $this->assertEquals($fCalled(), 'XA');
    }
}
