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
   public static function footer() {
   	$year = date("Y");

     //$footer  = '<br/><br/> </div>';
     $footer  = '<div  style="color: '.wpwhitelabel()->setting('footer_text_color').';" id="footer" class="footer-copyright" align="'.wpwhitelabel()->setting('footer_alignment').'">';
     $footer .= '<p class="footer_text">';
     $footer .= wpwhitelabel()->setting('footer_text');
     $footer .= '</p>';
     $footer .= 'Copyright © ';
     //$footer .= '<a href=" '.wpwhitelabel()->site_info('url').' ">';
     $footer .= wpwhitelabel()->site_info('name');
     //$footer .= '</a> ';
     $footer .= '<span class="wll-footer-copyright-text"> ';
     $footer .= wpwhitelabel()->setting('copyright_text');
     $footer .= '</span> ';
     $footer .= '</div> ';
   	echo $footer;
   }
 }
