<?php

use App\App;
use App\Controllers\HomeController;
use App\Controllers\TestPageController;

require __DIR__ . '/../vendor/autoload.php';

const VIEW_PATH = __DIR__ . '/../views';
require_once __DIR__ . '/../connect.php';

$app = new App($_SERVER["REQUEST_METHOD"],$_SERVER["REQUEST_URI"],CONNECT);

$app -> getRouter() -> get('/',[HomeController::class, 'index']);
$app -> getRouter() -> get("/testPage",[TestPageController::class, "testPage"]);

$app -> run();
