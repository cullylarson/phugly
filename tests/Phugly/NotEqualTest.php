<?php

use PHPUnit\Framework\TestCase;
use function Phugly\notEqual;

class NotEqualTest extends TestCase {
    public function testEqual() {
        $this->assertEquals(notEqual('asdf', 'asdf'), false);
        $this->assertEquals(notEqual(10000, 10000), false);
        $this->assertEquals(notEqual(['a' => 'A', 'b' => 'B'], ['a' => 'A', 'b' => 'B']), false);
        $this->assertEquals(notEqual([1, 2, 3], [1, 2, 3]), false);
    }

    public function testNotEqual() {
        $this->assertEquals(notEqual('asdf', 'asdff'), true);
        $this->assertEquals(notEqual(10000, 10001), true);
        $this->assertEquals(notEqual(['a' => 'X', 'b' => 'B'], ['a' => 'A', 'b' => 'B']), true);
        $this->assertEquals(notEqual([1, 2, 3, 4], [1, 2, 3]), true);
        $this->assertEquals(notEqual([1, 3, 2], [1, 2, 3]), true);
    }

    public function testCurried() {
        $notAsdf = notEqual('asdf');

        $this->assertEquals($notAsdf('asdf'), false);
        $this->assertEquals($notAsdf('qwer'), true);
    }
}
