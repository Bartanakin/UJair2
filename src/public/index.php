<?php

use App\App;

require __DIR__ . '/../vendor/autoload.php';

$app = new App();

$app -> getRouter() -> get('/',function(){echo "Hello world";});

$app -> run();
