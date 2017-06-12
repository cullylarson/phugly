<?php

use PHPUnit\Framework\TestCase;
use function Phugly\hasAt;

class HasAtTest extends TestCase {
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
        $this->assertEquals(hasAt('a', $this->x), true);
        $this->assertEquals(hasAt('b', $this->x), true);
        $this->assertEquals(hasAt('i', $this->x), true);
        $this->assertEquals(hasAt('w', $this->x), false);
    }

    public function testNumericIndex() {
        $this->assertEquals(hasAt(0, $this->y), true);
        $this->assertEquals(hasAt(1, $this->y), true);
        $this->assertEquals(hasAt(5, $this->y), true);
        $this->assertEquals(hasAt([5, 1], $this->y), true);
        $this->assertEquals(hasAt(10, $this->y), false);
        $this->assertEquals(hasAt([5, 10], $this->y), false);
    }

    public function testArrayIndex() {
        $this->assertEquals(hasAt(['a'], $this->x), true);
        $this->assertEquals(hasAt(['b'], $this->x), true);
        $this->assertEquals(hasAt(['i'], $this->x), true);
        $this->assertEquals(hasAt(['c', 'd'], $this->x), true);
        $this->assertEquals(hasAt(['c', 'f'], $this->x), true);
        $this->assertEquals(hasAt(['g'], $this->x), false);
        $this->assertEquals(hasAt(['c', 'g'], $this->x), false);
    }

    public function testCurried() {
        $hasAtP2 = hasAt('b');
        $hasAtP1 = hasAt('c');
        $hasAtP1DoesntExist = hasAt('zzz');

        $this->assertEquals($hasAtP2($this->x), true);
        $this->assertEquals($hasAtP1($this->x), true);
        $this->assertEquals($hasAtP1DoesntExist($this->x), false);
    }
}
