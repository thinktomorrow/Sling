<?php

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase{


    public function setUp() {

        // For some reason the xml convertErrorsToExceptions is not being honoured so we do it like this:
        set_error_handler(function($errno, $errstr, $errfile, $errline) {
            throw new ErrorException($errstr . " on line " . $errline . " in file " . $errfile);
        });
    }

    public function tearDown() {
        restore_error_handler();
    }


}
