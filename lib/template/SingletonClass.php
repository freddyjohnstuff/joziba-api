<?php

namespace app\lib\template;

final class SingletonClass
{

    private static ?SingletonClass $instance = null;

    /**
     * @return SingletonClass
     */
    public static function getInstance(): SingletonClass
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /*
     * multiple construct, clone, wakeup,
     */
    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}


    /*
     *  TODO: Write here main functions!
     */

}