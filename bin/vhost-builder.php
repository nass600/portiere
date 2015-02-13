<?php

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../autoload.php')) {
    require __DIR__ . '/../autoload.php';
} else {
    throw new Exception("sdasd");
}

$app = new Nass600\Tool\Application('Vhost Builder', '1.0.0');
$app->run();