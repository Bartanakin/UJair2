<?php


require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__.'/../../connect.php';

// Add all Test classes to the array
// Each of them should extend the SQLTest class
// Each test method should have attribute #[TestAttribute]

$testClasses = [
    \Tests\SQLtests\AvailableAirplanesQueryTest::class
];

\Tests\SQLtests\Engine\SQLTest::runAllTests($testClasses,new \App\DataBaseConnection(CONNECT));
