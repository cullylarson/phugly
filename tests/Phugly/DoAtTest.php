<?php

use PHPUnit\Framework\TestCase;
use Phugly as F;
use function Phugly\doAt;

class DoAtTest extends TestCase {
    public function testStringIndex() {
        $arr = [ 'asdf' => 10, 'foo' => 'blah', 'more' => [ 20 => 'qwer', ], ];

        $f = function($x) {
            return $x . 'A';
        };

        $this->assertEquals(doAt('foo', '', $f, $arr), [ 'asdf' => 10, 'foo' => 'blahA', 'more' => [ 20 => 'qwer',  ],  ]);
    }

    public function testNumericIndex() {
        $arr = [ 'asdf' => 10, 30 => 40,  'foo' => 'blah', 'more' => [ 20 => 'qwer', ], ];

        $f = function($x) {
            return $x + 10;
        };

        $this->assertEquals(doAt(30, 0, $f, $arr), [ 'asdf' => 10, 30 => 50,  'foo' => 'blah', 'more' => [ 20 => 'qwer',  ],  ]);
    }

    public function testArrayIndex() {
        $arr = [ 'asdf' => 10, 30 => 40,  'foo' => 'blah', 'more' => [ 20 => 'qwer', ], ];

        $f = function($x) {
            return $x . 'B';
        };

        $this->assertEquals(doAt(['more', 20], '', $f, $arr), [ 'asdf' => 10, 30 => 40,  'foo' => 'blah', 'more' => [ 20 => 'qwerB',  ],  ]);
    }

    public function testNoIndex() {
        $arr = [ 'asdf' => 10, 30 => 40,  'foo' => 'blah', 'more' => [ 20 => 'qwer', ], ];

        $f = function($x) {
            return $x . 'B';
        };

        $this->assertEquals(doAt('aaaa', '', $f, $arr), [ 'asdf' => 10, 30 => 40,  'foo' => 'blah', 'more' => [ 20 => 'qwer',  ], 'aaaa' => 'B'  ]);
        $this->assertEquals(doAt(50, '', $f, $arr), [ 'asdf' => 10, 30 => 40,  'foo' => 'blah', 'more' => [ 20 => 'qwer',  ], 50 => 'B'  ]);
        $this->assertEquals(doAt(['aaaa', 20], '', $f, $arr), [ 'asdf' => 10, 30 => 40,  'foo' => 'blah', 'more' => [ 20 => 'qwer',  ], 'aaaa' => [20 => 'B']  ]);
    }

    public function testCurried() {
        $arr = [ 'asdf' => 10, 30 => 40,  'foo' => 'blah', 'more' => [ 20 => 'qwer', ], ];

        $f = function($x) {
            return $x . 'B';
        };

        $doAtApp = doAt(['more', 20], '', $f);

        $this->assertEquals($doAtApp($arr), [ 'asdf' => 10, 30 => 40,  'foo' => 'blah', 'more' => [ 20 => 'qwerB',  ],  ]);
    }

    public function testStatic() {
        $arr = [ 'asdf' => 10, 30 => 40,  'foo' => 'blah', 'more' => [ 20 => 'qwer', ], ];

        $f = function($x) {
            return $x . 'B';
        };

        $doAt = F\doAt;

        $this->assertEquals($doAt(['more', 20], '', $f, $arr), [ 'asdf' => 10, 30 => 40,  'foo' => 'blah', 'more' => [ 20 => 'qwerB',  ],  ]);
    }
}
