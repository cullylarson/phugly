<?php

use PHPUnit\Framework\TestCase;
use function Phugly\objProps;

class ObjPropsTest extends TestCase {
    public function testGetOneValue() {
        $x = new stdClass();
        $x->a = 'X';
        $x->b = 'Y';
        $x->c = 'Z';

        $this->assertEquals(objProps(['a'], $x), ['a' => 'X']);
    }

    public function testGetMultipleValues() {
        $x = new stdClass();
        $x->a = 'X';
        $x->b = 'Y';
        $x->c = 'Z';

        $this->assertEquals(objProps(['a', 'c'], $x), ['a' => 'X', 'c' => 'Z']);
    }

    public function testOneNonExistentValue() {
        $x = new stdClass();
        $x->a = 'X';
        $x->b = 'Y';
        $x->c = 'Z';

        $this->assertEquals(objProps(['d'], $x), []);
    }

    public function testMultipleNonExistentValue() {
        $x = new stdClass();
        $x->a = 'X';
        $x->b = 'Y';
        $x->c = 'Z';

        $this->assertEquals(objProps(['d', 'w'], $x), []);
    }
}
