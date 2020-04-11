<?php
namespace WPWhiteLabel\Customize;

final class Section {

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
	protected static function new_sections(){

		self::$sections[] = 'layout';
		self::$sections[] = 'header';
		self::$sections[] = 'logo';
		self::$sections[] = 'background';
		self::$sections[] = 'css';
		self::$sections[] = 'footer';

		return self::$sections;
	}

	/**
	 * get the sections list
	 * @return [type] [description]
	 */
	public static function sections(){
		return self::new_sections();
	}
}
