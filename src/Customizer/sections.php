<?php

namespace WPWhiteLabel;

	if (! function_exists('customizer_sections')) {
		/**
		 * [wll_options description]
		 * @return [type] [description]
		 */
		function customizer_sections(){
 			return Options::sections();
 		}
	}
