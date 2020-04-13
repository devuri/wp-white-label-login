<?php
namespace WPWhiteLabel\Header;
/**
 *
 */
class LoginHeader
{

	/**
   * header
   *
   * add a header section to the login page
   * @return
   */
  public static function header() {
    $header  = '<div class="wrapper">';
    $header .= '<div style="background-color: '.wpwhitelabel()->setting('header_background_color').'; color: '.wpwhitelabel()->setting('header_text_color').';" id="wll-header" class="wll-header" ';
    $header .= 'align="'.wpwhitelabel()->setting('header_alignment').'">';
    $header .= '<h2 align="'.wpwhitelabel()->setting('header_alignment').'">';
    $header .= '<a  href="'.get_bloginfo('url').'" title="'.wpwhitelabel()->site_info('name').'">';
    $header .= wpwhitelabel()->setting('header_title');
    $header .= '</a>';
    $header .= '</h2>';
    $header .= '<div class="wll-site-description">';
    $header .= wpwhitelabel()->setting('header_description');
    $header .= '</div>';
    $header .= '</div>';
  	echo $header;
  }
}
