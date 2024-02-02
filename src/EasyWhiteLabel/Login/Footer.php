<?php

namespace EasyWhiteLabel\Login;

class Footer
{
    /**
     * show footer navigation.
     *
     * @var [type]
     */
    private static $nav;

    public static function menu(): void
    {
        self::$nav = wpwhitelabel()->get_setting( 'footer_nav' );
        if ( self::$nav ) { ?>
        <div align="<?php echo wpwhitelabel()->get_setting( 'footer_nav_alignment' ); ?>" style="padding: 12px;
          border-top: solid thin <?php echo wpwhitelabel()->get_setting( 'footer_nav_backgorund' ); ?>;
          border-bottom: solid thin <?php echo wpwhitelabel()->get_setting( 'footer_nav_backgorund' ); ?>;
          background-color: <?php echo wpwhitelabel()->get_setting( 'footer_nav_backgorund' ); ?>;
          box-shadow: 0 5px 15px rgba(0,0,0,.08);">
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

    /**
     * footer.
     *
     * @return mixed
     */
    public static function footer()
    {
        echo self::set_footer();

        return true;
    }

    /**
     * footer.
     *
     * add footer section to the login page
     *
     * @return mixed
     */
    protected static function set_footer()
    {
        $year = gmdate( 'Y' );
        ?>
    <div class="push"></div>
    </div><!--wrapper-->
    <div  style=" font-size: small; color:<?php echo wpwhitelabel()->get_setting( 'footer_text_color' ); ?>;" id="footer" class="footer footer-copyright" align="<?php echo wpwhitelabel()->get_setting( 'footer_alignment' ); ?>">
    <div style="padding:8px; width: 70%; margin-bottom:12px;" class="footer-text">
		<?php echo wpwhitelabel()->get_setting( 'footer_text' ); ?>
    </div><!--footer-text-->
		<?php self::menu(); ?>
    <div style="padding:8px; width: 60%; margin-bottom:4px; color:<?php echo wpwhitelabel()->get_setting( 'footer_text_color' ); ?>;" class="footer-copyright">
    Copyright © <?php echo $year; ?>
    <a href="<?php echo get_bloginfo( 'url' ); ?>">
		<?php echo get_bloginfo( 'name' ); ?>
    </a>
    <span class="wll-footer-copyright-text">
		<?php echo wpwhitelabel()->get_setting( 'copyright_text' ); ?>
    </span>
    </div><!--footer-copyright-->
    </div><!--footer-->
		<?php

        return true;
    }
}
