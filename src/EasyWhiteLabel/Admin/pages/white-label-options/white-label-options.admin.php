<?php

use EasyWhiteLabel\Admin\Pages\SettingsPage;

$ewl_settings = new SettingsPage();

$ewl_settings->process( $_POST );

$ewl_settings->render();
