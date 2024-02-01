<?php

// start plugin.
if ( ! \defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// delete settings in the options table.
delete_option( 'wpwll_logo' );
delete_option( 'wpwll_background' );
delete_option( 'wpwll_logo_url' );
delete_option( 'wpwll_background_url' );
delete_option( 'wpwll_align' );
delete_option( 'wpwll_custom_css' );
delete_option( 'wpwll_copyright_text' );
delete_option( 'wpwll_options' );
delete_option( 'wpwll_page_access' );

// finally clear the cache
wp_cache_flush();
