<?php

use PHPUnit\Framework\TestCase;
use function Phugly\dumpM;

class DumpMTest extends TestCase {
    public function testWorksOnCommandLine() {
        $somethingUnique = "sfRQX@qz1!z@!!82BW&DBXc53";
        $message = "@H3gKd!7d^IWXi@7knnh#IAiN";

        ob_start();
        dumpM($message, $somethingUnique);
        $result = ob_get_clean();

        if(function_exists('php_sapi_name') && php_sapi_name() === 'cli') {
            $this->assertNotSame(strpos($result, $somethingUnique), false);
            $this->assertNotSame(strpos($result, $message), false);
            $this->assertSame(strpos($result, '<pre>'), false);
        }
    }

    // I don't know how to test if this works on the web
}
