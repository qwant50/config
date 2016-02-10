<?php

namespace Qwant;


class Config
{
    protected $basePath;
    public $data = [];

    /**
     * @param string $basePath path to '../configs/' directory
     * getenv('APP_ENV')  gets APP_ENV variable from the httpd.ini file
     * @throws ConfigException
     */
    public function __construct($basePath)
    {
        $this->basePath = rtrim($basePath, '/') . '/';
        $this->basePath .= (getenv('APP_ENV')) ? 'development/' : 'production/';
        if (!is_dir($this->basePath)) {
            throw new ConfigException('Configs base path ' . $this->basePath . ' not found.');
        }
        $this->loadConfigs();
    }

    /**
     * Load config data. Support php|ini|yaml config formats.
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
            if (strpos($configFile, '..')) {
                throw new ConfigException('File name: ' . $configFile . ' isnt correct.');
            }
            $path = realpath($this->basePath . $configFile);
            if (!is_file($path) || !is_readable($path)) {
                throw new ConfigException('Config file ' . $path . ' not found of file isnt readable.');
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
        } elseif ('yaml' == $ext) {
            if (!function_exists('yaml_parse_file')) {
                throw new ConfigException('Function `yaml_parse_file` isnt supported.
                http://php.net/manual/en/yaml.requirements.php');
            }
            $this->data[$key] = yaml_parse_file($path);
        }
    }

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
     *  Save config in php file. Support only this way.
     *
     * @param string $key
     * @param string|null $configFile  format: fileName.ext
     * @return int
     * @throws ConfigException
     */
    public function saveConfig($key, $configFile = null)
    {
        if (strpos($configFile, '..')) {
            throw new ConfigException('File name: ' . $configFile . ' isnt correct.');
        }
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
        return (isset($this->data[$key])) ? $this->data[$key] : [];
    }

    public function setData($key, $value)
    {
        $this->data[$key] = $value;
    }
}