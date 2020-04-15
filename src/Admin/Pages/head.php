<?php

  if (!is_user_logged_in()) {
    wp_die();
  }

  if (!current_user_can('manage_options')) {
    wp_die();
  }

  add_thickbox();

?><head>
<div id="wll-important-notice">
  <span class="wll-notice-message">
    Do you have suggestions head over to the
    <a href="https://wordpress.org/support/plugin/<?php print($this->slug); ?>" target="_blank" rel="noopener noreferrer">Plugins Support Section</a>.
    If you enjoy using this plugin
    <a href="https://wordpress.org/plugins/wp-white-label-login/#reviews" target="_blank" rel="noopener noreferrer">please leave a positive feedback here.</a>.
  </span>
</div>
<header class="wll-header">
</header>
<div class="wll-container">
  <div class="wll-admin-wrap"><?php

          if (!$this->admin_smenu) {

              // do not show for admin submenu setttings pages
              echo $this->get_menu_title();
              $this->dynamic_tab_menu();

            } elseif ($this->admin_smenu) {

              #admin submenu items
              echo '<h2>';
              echo ucwords(
                str_replace( '-', ' ',$this->get_thepage_name())
              );
              echo '</h2>';
              echo '<hr>';
            }


         ?><div class="wll-child">
            <div class="wll-grid-item">
                <div class="wll-padding">
                  <p><!---innner paragraph -->
