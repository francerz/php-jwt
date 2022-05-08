<?php

namespace Francerz\JWT\SignAlgorithms;

use Francerz\JWT\SignAlgorithmInterface;

class NoneAlgorithm implements SignAlgorithmInterface
{
    private static $_instance = null;
    
    public static function getInstance()
    {
        if (!isset(static::$_instance)) {
            static::$_instance = new static();
        }
        return static::$_instance;
    }

    private function __construct() { }
    
    public function getKey()
    {
        return 'none';
    }

    public function sign($token)
    {
        return '';
    }
}
