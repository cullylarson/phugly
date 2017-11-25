<?php

use PHPUnit\Framework\TestCase;
use function Phugly\liftArray;
use function Phugly\liftA;

class ToArrayTest extends TestCase {
    public function testDoesntChangeArray() {
        $x = ['asdf'];

        $this->assertEquals(liftArray($x), ['asdf']);
        $this->assertEquals(liftA($x), ['asdf']);
    }

    public function testWrapsStaticValues() {
        $x = 'asdf';
        $y = 1;

        $this->assertEquals(liftArray($x), ['asdf']);
        $this->assertEquals(liftA($x), ['asdf']);
        $this->assertEquals(liftArray($y), [1]);
        $this->assertEquals(liftA($y), [1]);
    }
}
