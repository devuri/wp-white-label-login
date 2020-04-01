<?php

# Lockdown Menu
$wll_menu = array(
  'White Label Login Settings',
  'WP White Label',
  'manage_options',
  'white-label-login-options',
  'memlockdown_callback',
  6.5,
  'dashicons-art',
  'mls',
  $wll,
);

  $wll_submenu = array(
    'Logo',
    'Background',
    'Align',
    'CSS'
  );

// initialize menu
new Wll_Admin_Menu($wll_menu);
