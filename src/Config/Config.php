<?php

namespace Qwant\Config;


class Config
{
    protected $basePath;
    public $configFile;

    /**
     * @param string $basePath path to '../configs/' directory
     * getenv('APP_ENV')  gets APP_ENV variable from the httpd.ini file
     */
    public function __construct($basePath)
    {
        $this->basePath = rtrim($basePath, '/') . '/';
        $this->basePath .= (getenv('APP_ENV')) ? 'development/' : 'production/';
    }

    /**
     * @param string $configFile Config file's name, example - auth.php
     */
    public function setConfigFile($configFile)
    {
        $this->configFile = $configFile;
    }

    /**
     * @param string $configFile
     * @return array
     */
    public function loadConfig($configFile = null)
    {
        if (!$configFile) {
            $configFile = $this->configFile;
        }
        $path = $this->basePath . $configFile;
        if (is_file($path) && is_readable($path)) {
            return include $path;
        }
    }

    /**
     * @param $params
     * @param string $configFile
     * @return int
     */
    public function saveConfig($params, $configFile = null)
    {
        if (!$configFile) {
            $configFile = $this->configFile;
        }
        $content = "<?php" . PHP_EOL . "return " . var_export($params, true) . ";";
        return file_put_contents($this->basePath . $configFile, $content);
    }
}