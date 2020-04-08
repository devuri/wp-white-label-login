<?php

namespace WPWhiteLabel\Customize;

	if (! function_exists('customizer_sections')) {
		/**
		 * customizer_sections() 
		 * @return [type] [description]
		 */
		function customizer_sections(){
 			return Section::sections();
 		}
	}
