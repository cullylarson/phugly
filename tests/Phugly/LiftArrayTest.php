<?php

use PHPUnit\Framework\TestCase;
use function Phugly\liftArray;

class ToArrayTest extends TestCase {
    public function testDoesntChangeArray() {
        $x = ['asdf'];

        $this->assertEquals(liftArray($x), ['asdf']);
    }

    public function testWrapsStaticValues() {
        $x = 'asdf';
        $y = 1;

        $this->assertEquals(liftArray($x), ['asdf']);
        $this->assertEquals(liftArray($y), [1]);
    }
}
