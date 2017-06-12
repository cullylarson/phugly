<?php

use PHPUnit\Framework\TestCase;
use function Phugly\equal;

class EqualTest extends TestCase {
    public function testEqual() {
        $this->assertEquals(equal('asdf', 'asdf'), true);
        $this->assertEquals(equal(10000, 10000), true);
        $this->assertEquals(equal(['a' => 'A', 'b' => 'B'], ['a' => 'A', 'b' => 'B']), true);
        $this->assertEquals(equal([1, 2, 3], [1, 2, 3]), true);
    }

    public function testNotEqual() {
        $this->assertEquals(equal('asdf', 'asdff'), false);
        $this->assertEquals(equal(10000, 10001), false);
        $this->assertEquals(equal(['a' => 'X', 'b' => 'B'], ['a' => 'A', 'b' => 'B']), false);
        $this->assertEquals(equal([1, 2, 3, 4], [1, 2, 3]), false);
        $this->assertEquals(equal([1, 3, 2], [1, 2, 3]), false);
    }

    public function testCurried() {
        $equalsAsdf = equal('asdf');

        $this->assertEquals($equalsAsdf('asdf'), true);
        $this->assertEquals($equalsAsdf('qwer'), false);
    }
}
