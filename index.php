<?php
/**
 * Created by PhpStorm.
 * User: Qwant
 * Date: 25-Jan-16
 * Time: 21:57
 */

use Qwant\Config\Config;


error_reporting(E_ALL);
ini_set('display_errors', 1);

$loader = require __DIR__ . '/vendor/autoload.php';

// Usage example
$configObj = new Config(__DIR__.'/src/configs');
$configObj->setConfigFile( 'mailer.php');
var_dump($componentConfig = $configObj->loadConfig());
$componentConfig = 256;
//$configObj->saveConfig($componentConfig);


