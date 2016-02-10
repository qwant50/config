<?php

use Qwant\Config;

$loader = require __DIR__ . '/vendor/autoload.php';

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);


$configObj = new Config(__DIR__ . '/src/configs');

//$configObj->loadConfig('component.php');
//$configObj->loadConfigs();
var_dump($configObj->data);
