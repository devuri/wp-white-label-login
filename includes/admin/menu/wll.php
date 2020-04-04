<?php

# Lockdown Menu
$wllmenu = array(
  'White Label Login Settings',
  'WP White Label',
  'manage_options',
  'white-label-options',
  'wllmenu_callback',
  'dashicons-art',
  6.5,
  'wll',
  $wll,
);

  $wllsubmenu = array(
    'Logo',
    'Custom Background',
    'Custom CSS',
    'Upgrade',
  );

// initialize menu
$wll_admin_menu = new Wll_Admin_Menu($wllmenu,$wllsubmenu);
