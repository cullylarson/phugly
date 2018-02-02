<?php

use PHPUnit\Framework\TestCase;
use Phugly as F;
use function Phugly\replace;

class ReplaceTest extends TestCase {
    public function testDoesStringReplace() {
        $this->assertEquals(replace('1', 'A', '123412341234'), 'A234A234A234');
    }

    public function testStringSameWhenNotFound() {
        $this->assertEquals(replace('9', 'A', '123412341234'), '123412341234');
    }

    public function testEmpyString() {
        $this->assertEquals(replace('9', 'A', ''), '');
    }

    public function testNotString() {
        // should just return the original subject, unaltered
        $this->assertEquals(replace('9', 'A', []), []);
    }

    public function testStatic() {
        $replace = F\replace;

        $this->assertEquals($replace('1', 'A', '123412341234'), 'A234A234A234');
    }
}
