<?php

use EasyWhiteLabel\Admin\Pages\BackgroundPage;

$ewl_background_settings = new BackgroundPage();

$ewl_background_settings->process( $_POST );

$ewl_background_settings->render();
