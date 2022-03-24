<?php

require __DIR__ . '/../vendor/autoload.php';

echo "Hello world!";

$id = new \Ramsey\Uuid\UuidFactory();

echo    $id -> uuid4();