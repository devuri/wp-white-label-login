<?php

use WPAdminPage\AdminPage;

  $wllmenu = array(
    'White Label Login Settings',
    'WP White Label',
    'manage_options',
    'white-label-options',
    'wllmenu_callback',
    'dashicons-art',
    6.5,
    'wll',
    wpwhitelabel(),
  );

  $wllsubmenu = array(
    'Logo',
    'Background',
    'CSS',
    /*'Login Redirect',*/
    'Useful Plugins',
  );

    //  initialize menu
    new AdminPage($wllmenu,$wllsubmenu);
