<?php

namespace Qwant;

/**
 * Class Config
 * @package Qwant
 * @author   Sergey Malahov
 */
class Config
{
    private $basePath;
    private $data = [];

    /**
     * Generate $basePath to configs
     *
     * @param string $basePath path to '../configs/' directory
     * getenv('APP_ENV')  gets APP_ENV variable from the httpd.ini file
     * @throws ConfigException
     */
    public function __construct($basePath)
    {
        $this->basePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->basePath .= ((getenv('APP_ENV')) ? 'development' : 'production') . DIRECTORY_SEPARATOR;
        if (!is_dir($this->basePath)) {
            throw new ConfigException('Configs base path ' . $this->basePath . ' not found.');
        }
        $this->loadConfigs();
    }

    /**
     * Load config data. Support php|ini|yml config formats.
     *
     * @param string|\SplFileInfo $configFile
     * @throws ConfigException
     */
    public function loadConfig($configFile)
    {
        if (!$configFile instanceof \SplFileInfo) {
            if (!is_string($configFile)) {
                throw new ConfigException('Mismatch type of variable.');
            }
            $path = realpath($this->basePath . $configFile);
            // check basePath at mutation
            if (strpos($configFile, '..') || (!strpos($path, realpath($this->basePath)))) {
                throw new ConfigException('Config file name: ' . $configFile . ' isn\'t correct.');
            }
            if (!is_file($path) || !is_readable($path)) {
                throw new ConfigException('Config file: ' . $path . ' not found of file isn\'t readable.');
            }
            $configFile = new \SplFileInfo($path);
        }
        $path = $configFile->getRealPath();
        $ext = $configFile->getExtension();
        $key = $configFile->getBasename('.' . $ext);

        if ('php' == $ext) {
            $this->data[$key] = include $path;
        } elseif ('ini' == $ext) {
            $this->data[$key] = parse_ini_file($path, true);
        } elseif ('yml' == $ext) {
            if (!function_exists('yaml_parse_file')) {
                throw new ConfigException("Function `yaml_parse_file` isn't supported.\n" .
                    'http://php.net/manual/en/yaml.requirements.php');
            }
            $this->data[$key] = yaml_parse_file($path);
        }
    }

    /**
     * Load all configs from basePath
     *
     */
    public function loadConfigs()
    {
        $filesList = new \FilesystemIterator($this->basePath, \FilesystemIterator::SKIP_DOTS);
        foreach ($filesList as $fileInfo):
            if ($fileInfo->isFile()) {
                $this->loadConfig($fileInfo);
            }
        endforeach;
    }

    /**
     *  Save config in '.php' file. Support only this way.
     *
     * @param string $key
     * @param string|null $configFile format: fileName.php
     * @return int
     * @throws ConfigException
     */
    public function saveConfig($key, $configFile = null)
    {
        if (strpos($configFile, '..')) {
            throw new ConfigException('File name: ' . $configFile . ' isn\'t correct.');
        }
        $configFile = is_null($configFile) ? $key . '.php' : $configFile;
        $content = "<?php" . PHP_EOL . "return " . var_export($this->getData($key), true) . ";";
        return file_put_contents($this->basePath . $configFile, $content);
    }

    /**
     * Get config data by key
     *
     * @param string|null $key
     * @return array
     */
    public function getData($key = null)
    {
        if (is_null($key)) {
            return $this->data;
        }
        // return part of configuration
        return (isset($this->data[$key])) ? $this->data[$key] : [];
    }

    /**
     * Set config data by key
     *
     * @param $key
     * @param $value
     */
    public function setData($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Return basePath
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }
}