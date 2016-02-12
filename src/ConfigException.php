<?php
/**
 * Created by PhpStorm.
 * User: Qwant
 * Date: 09-Feb-16
 * Time: 23:03
 */

namespace Qwant;


class ConfigException extends \Exception
{
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        $message = __CLASS__ . ' ' . $message;
        parent::__construct($message, $code, $previous);
    }
}