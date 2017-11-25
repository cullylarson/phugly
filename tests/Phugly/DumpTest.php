<?php

use PHPUnit\Framework\TestCase;
use function Phugly\dump;

class DumpTest extends TestCase {
    public function testWorksOnCommandLine() {
        $somethingUnique = "sfRQX@qz1!z@!!82BW&DBXc53";

        ob_start();
        dump($somethingUnique);
        $result = ob_get_clean();

        if(function_exists('php_sapi_name') && php_sapi_name() === 'cli') {
            $this->assertNotSame(strpos($result, $somethingUnique), false);
            $this->assertSame(strpos($result, '<pre>'), false);
        }
    }

    // I don't know how to test if this works on the web
}
