<?php

use PHPUnit\Framework\TestCase;
use function Phugly\suffix;

class SuffixTest extends TestCase {
    public function testSimple() {
        $this->assertEquals(suffix('asdf', 'qwer'), 'qwerasdf');
    }

    public function testCurried() {
        $makeEsq = suffix(', Esq.');

        $this->assertEquals($makeEsq('Mr. Larson'), 'Mr. Larson, Esq.');
    }
}
