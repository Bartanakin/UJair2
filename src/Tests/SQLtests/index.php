<?php


require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__.'/../../connect.php';

    $test1 = new \Tests\SQLtests\AvailableAirplanesQueryTest();

    $test1 -> setUp();
    $test1 -> test();