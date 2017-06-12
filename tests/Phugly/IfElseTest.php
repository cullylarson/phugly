<?php

use PHPUnit\Framework\TestCase;
use Phugly as F;
use function Phugly\ifElse;
use function Phugly\always;

class IfElseTest extends TestCase {
    public function testSimpleIf() {
        $fTrue = always(true);
        $fFalse = always(false);

        $do = ifElse($fTrue, $fTrue, $fFalse);

        $this->assertEquals($do(null), true);
    }

    public function testSimpleElse() {
        $fTrue = always(true);
        $fFalse = always(false);

        $do = ifElse($fFalse, $fTrue, $fFalse);

        $this->assertEquals($do(null), false);
    }

    public function testPassingValueToIf() {
        $fTrue = always(true);
        $fFalse = always(false);

        $do = ifElse($fTrue, F\id, $fFalse);

        $this->assertEquals($do('asdf'), 'asdf');
    }

    public function testPassingValueToElse() {
        $fTrue = always(true);
        $fFalse = always(false);

        $do = ifElse($fFalse, $fTrue, F\id);

        $this->assertEquals($do('asdf'), 'asdf');
    }

    public function testPassingValueToPredicate() {
        $predicate = function($x) { return $x === 'asdf'; };
        $fTrue = always(true);
        $fFalse = always(false);

        $do = ifElse($predicate, $fTrue, $fFalse);

        $this->assertEquals($do('asdf'), true);
        $this->assertEquals($do('qwer'), false);
    }
}
