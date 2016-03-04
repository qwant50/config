<?php

use Qwant\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{

    public $conf;

    public function setUp()
    {
        $this->conf = new Config(dirname(dirname(__DIR__)) . '/src/tests');
    }

    public function testLoadAllConfigsIni()
    {
        $data = $this->conf->getData();
        $this->AssertTrue(isset($data['file']));
    }

    public function testLoadAllConfigsPhp()
    {
        $data = $this->conf->getData();
        $this->AssertTrue(isset($data['testFile']));
    }

    public function testSaveConfigPhp()
    {
        $testFileName = 'newFile.php';
        if (is_file($this->conf->getBasePath() . $testFileName)) {
            unlink($this->conf->getBasePath() . $testFileName);
        }
        $this->conf->saveConfig('testFile', $testFileName);
        $this->AssertFileExists($this->conf->getBasePath() . $testFileName);
    }

    public function testGetDataPhp()
    {
        $this->AssertEquals('value1', $this->conf->getData('testFile')['key1']);
    }

    public function testSomthing()
    {
        $this->expectException(InvalidArgumentException::class);
    }
}
