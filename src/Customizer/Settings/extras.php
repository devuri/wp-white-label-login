<?php

// check before we make
if ( class_exists( 'WllCustomizeProControl' ) ) :
		// Pro Version control.
			$this->customizer()->add_control( new WllCustomizeProControl(
				$this->customizer(), 'wpwll_options[pro_version]', array(
					'section'  => 'white_label_extras',
					'settings' => array(),
					'priority' => 20,
				)
			) );
endif;
