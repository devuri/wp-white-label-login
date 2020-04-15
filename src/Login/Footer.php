<?php

namespace WPWhiteLabel\Footer;
 /**
  *
  */
 class LoginFooter {

	 /**
    * footer
    *
    * add footer section to the login page
    * @return string
    */
   protected static function set_footer() {
   	$year = date("Y");

     $footer  = '<div class="push"></div>';
     $footer .= '</div><!--wrapper-->';
     $footer .= '<div  style="font-size: small; color: '.wpwhitelabel()->setting('footer_text_color').';" id="footer" class="footer footer-copyright" align="'.wpwhitelabel()->setting('footer_alignment').'">';
     $footer .= '<div style="width: 70%; font-size: small; margin-bottom:12px;" class="footer_text">';
     $footer .= wpwhitelabel()->setting('footer_text');
     $footer .= '</div><!--footer_text-->';
     $footer .= 'Copyright © '.$year.' ';
     $footer .= '<a href=" '.wpwhitelabel()->site_info('url').' ">';
     $footer .= wpwhitelabel()->site_info('name');
     $footer .= '</a> ';
     $footer .= '<span class="wll-footer-copyright-text"> ';
     $footer .= wpwhitelabel()->setting('copyright_text');
     $footer .= '</span> ';
     $footer .= '</div><!--footer-copyright--> ';
   	echo $footer;
   }

   /**
     * footer
     * @return string
     */
    public static function footer() {
      echo self::set_footer();
    }
 }
