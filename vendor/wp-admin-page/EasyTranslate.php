<?php

namespace WPAdminPage\Translate\Form;

/**
 *
 */
class Translate_Easy {

	/**
	 * $textdomain
	 *
	 * the textdomain for the current plugin
	 * @var string
	 */
	private $textdomain;

	/**
	 * __construct
	 *
	 * new up and get the plugin textdomain
	 * @param object $plugin [get the current plugin object]
	 * @param string $plugin_textdomain [plugin textdomain]
	 */
	function __construct( object $plugin , string $plugin_textdomain = 'default' ) {
		// plugin textdomain
		$this->textdomain = $plugin->textdomain;
	}

	/**
	 * Translate
	 *
	 * translate_text('some text')
	 * @param string $text_to_translate
	 * @link https://developer.wordpress.org/reference/functions/translate/
	 */
	public function translate_text( string $text_to_translate='' ) {
			$text = translate( $text_to_translate, $this->textdomain );
			return $text;
	}

	/**
	 * text()
	 *
	 * easily call echo translate_text() on text values
	 * @param  string $text [description]
	 * @return string [translated text]
	 */
	public function text( string $text='' ){
		$e_text = $this->translate_text($text);
		echo $e_text;
	}

}
