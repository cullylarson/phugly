<?php

use PHPUnit\Framework\TestCase;
use function Phugly\compose;

class ComposeTest extends TestCase {
    public function testStandardLibFunctionLast() {
        $x = ['a' => 'X', 'b' => 'Y'];

        $doNothing = function(array $x) { return $x; };

        $composed = compose('array_values', $doNothing);

        $this->assertEquals($composed($x), ['X', 'Y']);
    }
}
