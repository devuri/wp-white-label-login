<?php

use WPWhiteLabel\AdminMenu;

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
    'Custom Background',
    'Custom CSS',
  );

    //  initialize menu
    new AdminMenu($wllmenu,$wllsubmenu);
