<?php

namespace EasyWhiteLabel\Customize;


class LoginTemplate {
    public function __construct() {
        add_action('init', array($this, 'add_rewrite_rule'));
        add_action('template_redirect', array($this, 'redirect_login_preview'));
        add_filter('query_vars', array($this, 'add_query_vars'), 0);
    }

    public function add_rewrite_rule() {
        add_rewrite_rule('^wpwl-login-preview/?$', 'index.php?wpwl_login_preview=1', 'top');
    }

    public function add_query_vars($vars) {
        $vars[] = 'wpwl_login_preview';
        return $vars;
    }

    public function redirect_login_preview() {
        $login_preview = intval(get_query_var('wpwl_login_preview'));
        if ($login_preview) {

			wp_head();
			ob_start();
			$_REQUEST['action'] = 'login'; // Set the action to 'login'
			include ABSPATH . 'wp-login.php';
			$login_form_html = ob_get_clean();
			echo $login_form_html;

			do_action( 'wp_footer' );
            exit;
        }
    }
}
