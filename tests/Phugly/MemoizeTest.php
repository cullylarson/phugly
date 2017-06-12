<?php

use PHPUnit\Framework\TestCase;
use Phugly as F;
use function Phugly\memoize;

class MemoizeTest extends TestCase {
    public function testCachesResult() {
        $numCalls = 0;

        $f = memoize(function($a, $b) use (&$numCalls) {
            $numCalls++;
            return $a + $b;
        });

        $this->assertEquals($f(5, 3), 8);
        $this->assertEquals($f(5, 3), 8);
        $this->assertEquals($f(5, 3), 8);
        $this->assertEquals($f(5, 3), 8);
        $this->assertEquals($f(5, 3), 8);
        $this->assertEquals($numCalls, 1);
        $this->assertEquals($f(6, 4), 10);
        $this->assertEquals($f(6, 4), 10);
        $this->assertEquals($f(6, 4), 10);
        $this->assertEquals($numCalls, 2);
    }

    public function testCachesResultStringArgs() {
        $numCalls = 0;

        $f = memoize(function($a, $b) use (&$numCalls) {
            $numCalls++;
            return $a . $b;
        });

        $this->assertEquals($f('asdf', 'foo'), 'asdffoo');
        $this->assertEquals($f('asdf', 'foo'), 'asdffoo');
        $this->assertEquals($f('asdf', 'foo'), 'asdffoo');
        $this->assertEquals($f('asdf', 'foo'), 'asdffoo');
        $this->assertEquals($f('asdf', 'foo'), 'asdffoo');
        $this->assertEquals($numCalls, 1);
        $this->assertEquals($f('qwer', 'blah'), 'qwerblah');
        $this->assertEquals($f('qwer', 'blah'), 'qwerblah');
        $this->assertEquals($f('qwer', 'blah'), 'qwerblah');
        $this->assertEquals($numCalls, 2);
    }

    public function testSameResultMultipleCalls() {
        $f = memoize(function($a, $b) {
            return $a + $b;
        });

        $this->assertEquals($f(5, 3), 8);
        $this->assertEquals($f(5, 3), 8);
        $this->assertEquals($f(5, 3), 8);
    }

    public function testDifferentResultMultipleCalls() {
        $f = memoize(function($a, $b) {
            return $a + $b;
        });

        $this->assertEquals($f(1, 2), 3);
        $this->assertEquals($f(5, 3), 8);
        $this->assertEquals($f(10, 50), 60);
    }

    public function testStatic() {
        $memoize = F\memoize;

        $numCalls = 0;

        $f = $memoize(function($a, $b) use (&$numCalls) {
            $numCalls++;
            return $a + $b;
        });

        $this->assertEquals($f(5, 3), 8);
        $this->assertEquals($f(5, 3), 8);
        $this->assertEquals($f(5, 3), 8);
        $this->assertEquals($f(5, 3), 8);
        $this->assertEquals($f(5, 3), 8);
        $this->assertEquals($numCalls, 1);
        $this->assertEquals($f(6, 4), 10);
        $this->assertEquals($f(6, 4), 10);
        $this->assertEquals($f(6, 4), 10);
        $this->assertEquals($numCalls, 2);
    }
}
