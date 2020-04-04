<?php

// check before we make
if ( class_exists( 'WllCustomizeProControl' ) ) :
		// Pro Version control.
			$wp_customize->add_control( new WllCustomizeProControl(
				$wp_customize, 'wpwll_options[pro_version]', array(
					'section'  => 'white_label_extras',
					'settings' => array(),
					'priority' => 20,
				)
			) );
endif;
