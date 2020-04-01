<?php

# Lockdown Menu
$wllmenu = array(
  'White Label Login Settings',
  'WP White Label',
  'manage_options',
  'white-label-options',
  'memlockdown_callback',
  6.5,
  'dashicons-art',
  'mls',
  $wll,
);

  $wllsubmenu = array(
    'Logo',
    'Background',
    'Align',
    'Color Scheme',
    'CSS'
  );

// initialize menu
new Wll_Admin_Menu($wllmenu);
