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
    'Background',
    'Custom Background',
    'Form Align',
    //'CSS',
    'Custom CSS',
    //'Color Scheme',
    //'Login Themes'
  );

// initialize menu
$wll_admin_menu = new Wll_Admin_Menu($wllmenu,$wllsubmenu);
