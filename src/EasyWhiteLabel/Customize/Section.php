<?php

namespace EasyWhiteLabel\Customize;

final class Section
{
    /**
     * $sections.
     *
     * $sections array
     *
     * @var array
     */
    private static $sections = [];

    /**
     * get the sections list.
     *
     * @return [type] [description]
     */
    public static function sections()
    {
        return self::new_sections();
    }

    /**
     * lets build out the customizer sections.
     *
     * Create new customizer sections here is where we will add new panel sections
     *
     * @return array
     */
    protected static function new_sections()
    {
        self::$sections['layout']     = 'layout';
        self::$sections['header']     = 'header';
        self::$sections['logo']       = 'logo';
        self::$sections['login']      = 'login';
        self::$sections['form']       = 'form';
        self::$sections['button']     = 'button';
        self::$sections['links']      = 'links';
        self::$sections['background'] = 'background';
        self::$sections['menu']       = 'menu';
        self::$sections['footer']     = 'footer';
        self::$sections['css']        = 'css';

        return self::$sections;
    }
}
