<?php

namespace EasyWhiteLabel\Bridge;

class Option
{
    private static $instance;

    /**
     * Private constructor to prevent direct instantiation.
     */
    private function __construct()
    {
    }

    /**
     * Returns an instance of OptionBridge or any class that implements OptionInterface.
     * Utilizes the singleton pattern to ensure only one instance is created.
     *
     * @return OptionInterface
     */
    public static function init(): OptionInterface
    {
        if (null === self::$instance) {
            self::$instance = new OptionBridge();
        }

        return self::$instance;
    }

    /**
     * Prevent instance cloning.
     */
    private function __clone()
    {
    }

    /**
     * Prevent instance unserialization.
     */
    private function __wakeup()
    {
    }
}
