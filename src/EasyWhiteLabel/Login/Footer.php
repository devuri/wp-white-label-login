<?php

namespace EasyWhiteLabel\Login;

class Footer extends AbstractSettings
{
    /**
     * Outputs the footer content.
     */
    public static function footer(): void
    {
        $year              = gmdate( 'Y' );
        $footer_text_color = esc_attr( self::$whitelabel->get_setting( 'footer_text_color' ) );
        $footer_alignment  = esc_attr( self::$whitelabel->get_setting( 'footer_alignment' ) );
        $footer_text       = esc_html( self::$whitelabel->get_setting( 'footer_text' ) );
        $site_url          = esc_url( get_bloginfo( 'url' ) );
        $site_name         = esc_html( get_bloginfo( 'name' ) );
        $copyright_text    = esc_html( self::$whitelabel->get_setting( 'copyright_text' ) );

        ob_start();
        ?>

	    <div class="push"></div>
	    </div><!--wrapper-->
		    <div  style=" font-size: small; color:<?php echo $footer_text_color; ?>;" id="footer" class="footer footer-copyright" align="<?php echo $footer_alignment; ?>">
			    <div style="padding:8px; width: 70%; margin-bottom:12px;" class="footer-text">
					<?php echo $footer_text; ?>
			    </div><!--footer-text-->
					<?php self::footer_nav_menu(); ?>
				<div style="padding:8px; width: 60%; margin-bottom:4px; color:<?php echo $footer_text_color; ?>;" class="footer-copyright">
			    	Copyright © <?php echo $year; ?>
				    	<a href="<?php echo $site_url; ?>"> <?php echo $site_name; ?> </a>
				    <span class="wll-footer-copyright-text">
						<?php echo $copyright_text; ?>
				    </span>
			    </div><!--footer-copyright-->
		    </div><!--footer-->
	    <?php
        $output = ob_get_clean();
        echo $output;
    }

    private static function footer_nav_menu(): void
    {
        if ( self::$whitelabel->get_setting( 'footer_nav' ) ) {
            $footer_nav_alignment  = esc_attr( self::$whitelabel->get_setting( 'footer_nav_alignment' ) );
            $footer_nav_background = esc_attr( self::$whitelabel->get_setting( 'footer_nav_background' ) );

            ?>
	        <div class="footer-nav" style="text-align:<?php echo $footer_nav_alignment; ?>; background-color:<?php echo $footer_nav_background; ?>;">
	            <?php
                wp_nav_menu(
                    [
						'theme_location'  => 'wll-footer-nav',
						'container_class' => 'footer-navigation navigation clearfix',
					]
                );
				?>
	        </div>
	        <?php
        }
    }
}
