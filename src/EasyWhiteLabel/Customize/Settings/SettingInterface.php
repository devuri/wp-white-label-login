<?php

namespace EasyWhiteLabel\Customize\Settings;

use EasyWhiteLabel\Customize\CustomizerPanel;

interface SettingInterface
{
    /**
     * Initializes settings for the Customizer panel.
     *
     * This method should be implemented by classes to add their own settings
     * to the WordPress Customizer.
     *
     * @param CustomizerPanel $customize The Customizer panel instance where settings will be added.
     *
     * @return void
     */
    public function create( CustomizerPanel $customize): void;
}
