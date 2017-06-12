<?php

use PHPUnit\Framework\TestCase;
use function Phugly\prefix;

class PrefixTest extends TestCase {
    public function testSimple() {
        $this->assertEquals(prefix('asdf', 'qwer'), 'asdfqwer');
    }

    public function testCurried() {
        $makeMr = prefix('Mr. ');

        $this->assertEquals($makeMr('Larson'), 'Mr. Larson');
    }
}
