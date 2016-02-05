<?php

namespace Qwant\Config;

/**
 * Created by PhpStorm.
 * User: Qwant
 * Date: 05-Feb-16
 * Time: 11:29
 */
class Config
{
    public $path;

    public function setPath($path)
    {
        $this->path = rtrim($path, '/');
    }

    public function loadConfig($path = null)
    {
        if (! $path) $path = $this->path;
        if (is_file($path) && is_readable($path)) {
            return include $path;
        }
    }

    public function saveConfig($params, $path = null)
    {
        if (! $path) $path = $this->path;
        $content = "<?php" . PHP_EOL . "return " . var_export($params, true) . ";";
        return file_put_contents($path, $content);
    }
}