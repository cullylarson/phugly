<?php

use PHPUnit\Framework\TestCase;
use function Phugly\flatten;

class FlattenTest extends TestCase {
    public function testFlattenAlreadyOneDimensional() {
        $x = [1, 2, 3];
        $this->assertEquals($x, flatten($x));
    }

    public function testPreservesOneDimensionalOrder() {
        $x = [1, 2, 3];
        $flat = flatten($x);

        $this->assertEquals($flat[0], 1);
        $this->assertEquals($flat[1], 2);
        $this->assertEquals($flat[2], 3);
    }

    public function testFlattenMultiDimensional() {
        $x = [1, 2, 3, [4, 5, [6, 7]]];
        $this->assertEquals([1, 2, 3, 4, 5, 6, 7], flatten($x));
    }

    public function testPreservesMultiDimensionalOrder() {
        $x = [1, 2, 3, [4, 5, [6, 7]]];
        $flat = flatten($x);

        $this->assertEquals($flat[0], 1);
        $this->assertEquals($flat[1], 2);
        $this->assertEquals($flat[2], 3);
        $this->assertEquals($flat[3], 4);
        $this->assertEquals($flat[4], 5);
        $this->assertEquals($flat[5], 6);
        $this->assertEquals($flat[6], 7);
    }

    public function testFlattenMultiDimensional2() {
        $x = [['a', 'b'], 1, 'c', ['d', 'e', ['f', 'g']], 2];
        $this->assertEquals(['a', 'b', 1, 'c', 'd', 'e', 'f', 'g', 2], flatten($x));
    }

    public function testPreservesMultiDimensionalOrder2() {
        $x = [['a', 'b'], 1, 'c', ['d', 'e', ['f', 'g']], 2];
        $flat = flatten($x);

        $this->assertEquals($flat[0], 'a');
        $this->assertEquals($flat[1], 'b');
        $this->assertEquals($flat[2], 1);
        $this->assertEquals($flat[3], 'c');
        $this->assertEquals($flat[4], 'd');
        $this->assertEquals($flat[5], 'e');
        $this->assertEquals($flat[6], 'f');
        $this->assertEquals($flat[7], 'g');
        $this->assertEquals($flat[8], 2);
    }
}
