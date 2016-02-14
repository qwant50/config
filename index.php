<?php

use Qwant\Config;

$loader = require __DIR__ . '/vendor/autoload.php';

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

//  Reads all files .php | .ini | .yaml from folder
$config = new Config(__DIR__ . '/src/configs');

var_dump($config->getData());
