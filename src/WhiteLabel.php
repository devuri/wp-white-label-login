<?php

namespace WPWhiteLabel;

use WPWhiteLabel\Login\Logo;
use WPWhiteLabel\Login\Style;
use WPWhiteLabel\Login\Background;
use WPWhiteLabel\Login\Header;
use WPWhiteLabel\Login\Footer;
use WPWhiteLabel\Customize\Customizer;
use WPWhiteLabel\UsefulPlugins\Plugins;
use WPWhiteLabel\Admin\WhiteLabelAdmin;

/**
 * Main class White_Label_Login
 */
final class WhiteLabel {

	/**
	 * $enable
	 *
	 * check whether this is turned on or off
	 * @var boolean
	 */
	public $enable;

	/**
	 * $instance
	 *
	 * setup WPWhiteLabel
	 * @var object
	 */
	private static $instance;

	/**
	 * [instance description]
	 * @param  boolean $init active
	 * @return object
	 */
	public static function init( $init = false ) {

	    if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WPWhiteLabel ) ) {

		    self::$instance = new WhiteLabel();
		    self::$instance->load_textdomain();
		    self::$instance->includes();

		    /**
		     * check if the plugin is on or off
		     * @var [type]
		     */
		    self::$instance->enable = $init;

		    /**
		     * if the plugin is on lets make the login pretty
		     * @var [type]
		     */
		    if ( self::$instance->enable ) {

				self::$instance->loaded();
		    }

	      	add_action( 'plugins_loaded', array( self::$instance, 'objects' ), 10 );

	    }
	    return self::$instance;
	}

	/**
	 * setup.
	 */
	public function __construct() {

	  	// create admin pages
	  	WhiteLabelAdmin::init();

	}

	/**
	 * Loads the plugin language files.
	 *
	 * @since 1.0.0
	 */
	public function load_textdomain() {

	    load_plugin_textdomain( 'wp-white-label-login', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * white_label_login()
	 *
	 * start up and make the login pretty
	 * return status
	 * @return boolean
	 */
	public function loaded() {
	    add_action( 'admin_menu', array( $this , 'appearance_submenu') );
	    add_action( 'init', array( $this ,'footer_navigation') );
	    add_action( 'login_enqueue_scripts', array( Style::class, 'login_styles' ) );
	    add_action( 'login_enqueue_scripts', array( Logo::class, 'login_logo') );
	    add_filter( 'login_headertext',array( Logo::class, 'logo_text' ) );
	    add_filter( 'login_head', array( Header::class, 'header') );
	    add_filter( 'login_head', array( Background::class, 'body') );
	    add_filter( 'login_footer', array( Footer::class, 'footer') );
	    add_filter( 'login_headerurl', array( $this , 'logo_link') );
	}

  	/**
	 * Include files.
	 *
	 * @since 1.0.0
	 */
	private function includes() {

		// Admin/Dashboard stuff
		if ( is_admin() ) {
			require_once WPWLL_DIR . '/lib/class-connekt-plugin-installer.php';
		}
	}

	/**
	 * Setup objects.
	 *
	 * @since 1.0.0
	 */
	public function objects() {

	    // objects
	    $this->customizer = new Customizer( self::$instance );

	    // ok sparky everything seems to be loaded
	    do_action( 'wpwhitelabel_loaded' );
	}

	/**
	 * Footer Navigation
	 *
	 * @return void
	 */
	public function footer_navigation() {
	   register_nav_menu('wll-footer-nav',__( 'Login Page Footer Navigation' ));
	}

	/**
	 * wp_slug
	 *
	 * WordPress.org repo slug
	 * @return [type] [description]
	 */
	public function slug(){
        return 'wp-white-label-login';
	}

	/**
	 * plugin directory
	 *
	 * WordPress.org repo slug
	 * @return [type] [description]
	 */
	public function dir(){
        return WPWLL_DIR;
	}

	/**
	 * [photo_sites_list description]
	 * @param  string $thikboxID [description]
	 * @return [type]            [description]
	 */
	public function photo_sites( $thikboxID = 'freestockphotosites' ){
		?>
	    <div id="<?php echo $thikboxID; ?>" style="display:none;">
	    <table class="widefat">
	    <tr style="background:#CFCFCF;">
	    <th> <b>Website</b></th>
	    </tr><?php
		    // sites list
		    $listofsites = array(
		        'stocksnap.io',
		        'pixabay.com',
		        'pexels.com',
		        'unsplash.com',
		        'burst.shopify.com',
		        'reshot.com',
		        'foodiesfeed.com',
		        'gratisography.com',
		        'gratisography.com',
		        'freestocks.org',
		        'picography.co',
		        'focastock.com',
		        'picjumbo.com',
		        'kaboompics.com',
		        'skitterphoto.com',
		        'lifeofpix.com',
		        'littlevisuals.co',
		        'jaymantri.com',
		        'picspree.com',
		        'isorepublic.com',
		        'styledstock.co',
		        'pikwizard.com',
		        'rawpixel.com',
		    );

		    // sort the array
		    sort( $listofsites );
		    foreach ( $listofsites as $skey => $site ) {
		        echo '<tr>';
		        echo '<td>';
		        echo '<a target="_blank" href="https://'.$site.'">'.ucfirst($site).'</a>';
		        echo '</td>';
		        echo '</tr>';
		    }
		    ?></table></div>
		<?php
	}

    /**
     * Appearance submenu
     *
     * Lets add a submenu for the Customizer
     * @return void [type] [description]
     */
	public function appearance_submenu() {
	    add_submenu_page(
	      'themes.php',
	        __( 'White Label Login Customizer', 'wp-white-label-login' ),
	        __( 'White Label Login', 'wp-white-label-login' ),
	        'manage_options',
	        '/customize.php?url='.urlencode(home_url('/wp-login.php'))
	    );
	}

	/**
	 * customizer_button()
	 *
	 * quick link to the customizer
	 * @return string
	 */
	public function customizer_button($cbutton_text = 'Use The Customizer'){
	    // render button
	    $customizer_button  = '<a class="button button-hero"';
	    $customizer_button .= 'href="'.admin_url('/customize.php?url='.urlencode(home_url('/wp-login.php'))).'">';
	    $customizer_button .= $cbutton_text;
	    $customizer_button .= '</a>';
	    return $customizer_button;
	}

	/**
	 * Options
	 *
	 * setup some the options array
	 * @param  string $opt
	 * @return string
	 */
	public function option($opt = 'logo'){
	    $option = array(
	      'wpwll_options'     => get_option('wpwll_options'),
	      'background_image'  => get_option('wpwll_background'),
	      'logo'              => get_option('wpwll_logo'),
	      'custom_css'        => get_option('wpwll_custom_css')
	    );
	    return $option[$opt];
	}

	/**
	 * settings
	 *
	 * setup some the options array to get a specific setting
	 *
	 * @param  string $set
	 * @return string
	 */
	public function setting( $set = 'background' ){
	    $setting = $this->option('wpwll_options');
		if ( isset( $setting[$set] ) ) {
			return $setting[$set];
		}
		return '';
	}

	/**
	 * site_info
	 *
	 * setup some site specific vars
	 *
	 * @param  string $info
	 * @return string
	 */
	public function site_info( $info = 'name' ){
	    $site_info = array(
		    'name'             => get_bloginfo( 'name' ),
		    'url'              => get_bloginfo( 'url' ),
		    'admin_url'        => get_admin_url(),
		    'background_color' => 'none',
		    'header_text'      => get_bloginfo( 'description' ),
	    );
	    return $site_info[$info];
	}

	/**
	 * logo_link
	 *
	 * change the login link to site url
	 * @return string
	 */
	public function logo_link() {
	    return $this->site_info('url');
	}

}
