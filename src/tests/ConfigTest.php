<?php

use Qwant\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadAllConfigsIni()
    {
        $config = new Config(dirname(dirname(__DIR__)) . '/src/tests');
        $data = $config->getData();
        $this->AssertTrue(isset($data['file']));
    }

    public function testLoadAllConfigsPhp()
    {
        $config = new Config(dirname(dirname(__DIR__)) . '/src/tests');
        $data = $config->getData();
        $this->AssertTrue(isset($data['testFile']));
    }

    public function testSaveConfigPhp()
    {
        $config = new Config(dirname(dirname(__DIR__)) . '/src/tests');
        $testFileName = 'newFile.php';
        if (is_file($config->getBasePath() . $testFileName)) {
            unlink($config->getBasePath() . $testFileName);
        }
        $config->saveConfig('testFile', $testFileName);
        $this->AssertFileExists($config->getBasePath() . $testFileName);
    }

    public function testGetDataPhp()
    {
        $config = new Config(dirname(dirname(__DIR__)) . '/src/tests');
        $this->AssertEquals('value1', $config->getData('testFile')['key1']);
    }
}