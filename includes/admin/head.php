<?php

  if (!is_user_logged_in()) {
    wp_die();
  }

  if (!current_user_can('manage_options')) {
    wp_die();
  }


?><head>
<div id="wll-important-notice">
  <span class="wll-notice-message">
    If you found a bug or have suggestions head over to the
    <a href="https://wordpress.org/support/plugin/<?php print($this->wp_slug); ?>" target="_blank" rel="noopener noreferrer">Plugins Support Section</a>.
  </span>
</div>
<header class="wll-header">
</header>
<div class="wll-container">
         <div class="updated notice notice-my-class is-dismissible" data-notice="prefix_deprecated">
             <p><?php _e( 'Rate this plugin', 'wp-white-label-login' ); ?>
               <a href="https://wordpress.org/support/plugin/<?php print($this->wp_slug); ?>" target="_blank" rel="noopener noreferrer">Plugins Page WordPress.org</a>
             </p>
         </div>
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
