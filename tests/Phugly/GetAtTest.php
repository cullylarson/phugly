<?php

use PHPUnit\Framework\TestCase;
use function Phugly\getAt;

class GetAtTest extends TestCase {
    private $x = [
        'a' => 'A',
        'b' => 'B',
        'c' => [
            'd' => 'D',
            'e' => 'E',
            'f' => [
                'g' => 'G',
                'h' => 'H',
            ],
        ],
        'i' => ['one', 'two']
    ];

    private $y = ['zero', 'one', 'two', 5 => ['five-zero', 'five-one']];

    public function testStringIndex() {
        $this->assertEquals(getAt('a', null, $this->x), 'A');
        $this->assertEquals(getAt('b', null, $this->x), 'B');
        $this->assertEquals(getAt('i', null, $this->x), ['one', 'two']);
    }

    public function testNumericIndex() {
        $this->assertEquals(getAt(0, null, $this->y), 'zero');
        $this->assertEquals(getAt(1, null, $this->y), 'one');
        $this->assertEquals(getAt(5, null, $this->y), ['five-zero', 'five-one']);
        $this->assertEquals(getAt([5, 1], null, $this->y), 'five-one');
    }

    public function testArrayIndex() {
        $this->assertEquals(getAt(['a'], null, $this->x), 'A');
        $this->assertEquals(getAt(['b'], null, $this->x), 'B');
        $this->assertEquals(getAt(['i'], null, $this->x), ['one', 'two']);
        $this->assertEquals(getAt(['c', 'd'], null, $this->x), 'D');
        $this->assertEquals(getAt(['c', 'f'], null, $this->x), ['g' => 'G', 'h' => 'H']);
    }

    public function testDefaultValue() {
        $this->assertEquals(getAt(['zzz'], null, $this->x), null);
        $this->assertEquals(getAt('zzz', null, $this->x), null);
        $this->assertEquals(getAt(['zzz'], 'asdf', $this->x), 'asdf');
        $this->assertEquals(getAt('zzz', 'asdf', $this->x), 'asdf');
        $this->assertEquals(getAt(['zzz', 'aaa'], [], $this->x), []);
        $this->assertEquals(getAt(['zzz', 'aaa'], 'asdf', $this->x), 'asdf');
        $this->assertEquals(getAt(['zzz', 'aaa'], [3, 4, 5], $this->x), [3, 4, 5]);
    }

    public function testCurried() {
        $getAtP2 = getAt('b');
        $getAtP1 = getAt('b', null);
        $getAtP1DoesntExist = getAt('zzz', 'asdf');

        $this->assertEquals($getAtP2(null, $this->x), 'B');
        $this->assertEquals($getAtP1($this->x), 'B');
        $this->assertEquals($getAtP1DoesntExist($this->x), 'asdf');
    }
}
