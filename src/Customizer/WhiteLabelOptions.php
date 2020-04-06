<?php


class WhiteLabelOptions {

	/**
	 * $sections
	 *
	 * $sections array
	 * @var array
	 */
	private static $sections = array();

	/**
	 * lets build out the customizer sections
	 *
	 * Create new customizer sections here is where we will add new panel sections
	 * @return array
	 */
	protected static function new(){

		self::$sections[] = 'layout';
		self::$sections[] = 'header';
		self::$sections[] = 'logo';
		self::$sections[] = 'background';
		self::$sections[] = 'css';
		self::$sections[] = 'footer';

		return self::$sections;
	}

	public static function sections(){
		return self::new();
	}


}
