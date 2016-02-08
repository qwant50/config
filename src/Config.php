<?php

namespace Qwant;


class Config
{
    protected $basePath;
    public $data = [];

    /**
     * @param string $basePath path to '../configs/' directory
     * getenv('APP_ENV')  gets APP_ENV variable from the httpd.ini file
     * @throws \Exception
     */
    public function __construct($basePath)
    {
        $this->basePath = rtrim($basePath, '/') . '/';
        $this->basePath .= (getenv('APP_ENV')) ? 'development/' : 'production/';
        if (!is_dir($this->basePath)) {
            throw new \Exception('Configs base path ' . $this->basePath . ' not found.');
        }
        $this->loadConfigs();
    }

    /**
     * @param string $configFile
     * @return mixed
     * @throws \Exception
     */
    public function loadConfig($configFile)
    {
        $path = $this->basePath . $configFile;
        if (is_file($path) && is_readable($path)) {
            $this->data[substr($configFile, 0, -4)] = include $path;
        } else {
            throw new \Exception('Config file ' . $path . ' not found.');
        }
    }

    public function loadConfigs()
    {
        $filesList = array_diff(scandir($this->basePath), ['..', '.']);
        foreach ($filesList as $file):
            if (!is_dir($this->basePath . $file)) {
                $this->loadConfig($file);
            }
        endforeach;
    }

    /**
     * @param string $key
     * @param string|null $configFile
     * @return int
     */
    public function saveConfig($key, $configFile = null)
    {
        $configFile = strtolower(is_null($configFile) ? $key . '.php' : $configFile);

        $content = "<?php" . PHP_EOL . "return " . var_export($this->getData($key), true) . ";";
        return file_put_contents($this->basePath . $configFile, $content);
    }

    public function getData($key = null)
    {
        if (is_null($key)) {
            return $this->data;
        }
        // return part of configuration
        if (isset($this->data[$key])) {
            return $this->data[$key];
        } else {
            return null;
        }
    }

    public function setData($key, $value)
    {
        $this->data[$key] = $value;
    }
}