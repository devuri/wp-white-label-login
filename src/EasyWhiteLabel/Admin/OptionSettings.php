<?php

namespace EasyWhiteLabel\Admin;

class OptionSettings
{
    protected $option_name;
    protected $option_group;
    protected $page_slug;
    protected $section_id;
    protected $args;
    protected $_option;

    /**
     * Constructs the OptionSettings object.
     *
     * @param string $option_name  The name of the option to be used in the options table.
     * @param string $option_group A grouping for the options. This should match the group name used in settings_fields().
     * @param string $page_slug    The slug name of the page under which to add sections.
     * @param array  $args         Additional arguments for the register_setting function.
     */
    public function __construct( string $option_name, string $option_group, string $page_slug, array $args = [] )
    {
        $this->option_name  = $option_name;
        $this->option_group = $option_group;
        $this->page_slug    = $page_slug;
        $this->args         = $args;
        $this->_option      = get_option( $this->option_name );
    }

    /**
     * Retrieves the current value of the option from the database.
     *
     * @return mixed The option value.
     */
    public function get_option()
    {
        return $this->_option;
    }

    /**
     * Retrieves the section ID.
     *
     * @return string The section ID.
     */
    public function get_section_id()
    {
        return $this->section_id;
    }

    /**
     * Initializes the section and registers settings.
     *
     * @param string $section_id Unique identifier for the settings section.
     *
     * @return self
     */
    public function init( string $section_id ): self
    {
        $this->section_id = $section_id;

        return $this;
    }

    /**
     * Registers the setting with WordPress, allowing it to be stored in the database.
     */
    public function register(): void
    {
        register_setting( $this->option_group, $this->option_name, $this->args );
    }

    /**
     * Adds a new section to a settings page.
     *
     * @param mixed       $callback_or_description Either a function that fills the section with the desired content or a string description.
     * @param null|string $title                   The title of the section.
     * @param array       $args                    Additional arguments.
     *
     * @return self
     */
    public function add_section( $callback_or_description = null, ?string $title = null, array $args = [] ): self
    {
        $callback = $callback_or_description;

        if ( \is_string( $callback_or_description ) ) {
            $description = $callback_or_description;
            $callback    = function () use ( $description ): void {
                echo "<p>{$description}</p>";
            };
        }

        add_settings_section( $this->section_id, $title, $callback, $this->page_slug, $args );

        return $this;
    }

    /**
     * Adds a new field to a settings section of a settings page.
     *
     * @param string   $field_id Unique identifier for the field. Used in the 'id' attribute of tags.
     * @param string   $title    The title of the field.
     * @param callable $callback Function that fills the field with the desired inputs as part of the larger form. The function should echo its output.
     * @param array    $args     Additional arguments.
     *
     * @return self
     */
    public function add_field( string $field_id, string $title, callable $callback, array $args = [] ): self
    {
        add_settings_field( $field_id, $title, $callback, $this->page_slug, $this->section_id, $args );

        return $this;
    }

    public function page_html( string $button_text = 'Save Settings' ): void
    {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields( $this->option_group );
				do_settings_sections( $this->page_slug );
				submit_button( $button_text );
				?>
            </form>
        </div>
        <?php
    }

    public function create_page( string $page_title, string $menu_title, string $menu_slug = 'selective-page-access', string $capability = 'manage_options', ?int $position = null ): void
    {
        add_options_page(
            $page_title,
            $menu_title,
            $capability,
            $menu_slug,
            [ $this, 'page_html' ],
            $position
        );
    }
}
