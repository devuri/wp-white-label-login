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
     * Retrieves the option name.
     *
     * @return string The option name.
     */
    public function get_opt_name(): string
    {
        return $this->option_name;
    }

    /**
     * Retrieves the section ID.
     *
     * @return string The section ID.
     */
    public function get_section_id(): string
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
            <form method="post" action="options.php">
                <?php self::yield_nonce( $this->option_group ); ?>
                <?php do_settings_sections( $this->page_slug ); ?>
                <?php submit_button( $button_text ); ?>
            </form>
        </div>
        <?php
    }

    public static function input( $fieldname = 'item name', $val = '', array $args = [] ): void
    {
        // changed to item-name
        $field_name = self::sanitize( $fieldname, true );

        // changed to item_name
        $field_id = self::sanitize( $fieldname );

        $params = array_merge(
            [
                'id'       => esc_attr( $field_id ),
                'name'     => esc_attr( $field_id ),
                'required' => false,
                'class'    => 'opt-input',
                'type'     => 'text',
                'button'   => null,
                'hidden'   => false,
                'disabled' => false,
                'info'     => null,
                'width'    => '200',
                'checked'  => null,
            ],
            $args,
        );

        ?>
        <div style="margin-bottom: 1.4em;" id="input-<?php echo esc_attr( $params['id'] ); ?>">
            <input name="<?php echo esc_attr( $params['name'] ); ?>" type="<?php echo esc_attr( $params['type'] ); ?>" id="<?php echo esc_attr( $params['id'] ); ?>" value="<?php echo esc_attr( $val ); ?>"  <?php echo esc_attr( $params['checked'] ); ?> >
            <label style="color:#333333;font-weight:600" for="<?php echo esc_attr( $params['id'] ); ?>"><?php echo esc_html( $fieldname ); ?></label>
            <br/>
            <?php self::_info( $params['info'] ); ?>
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

    public static function yield_nonce( string $option_group ): void
    {
        settings_fields( $option_group );
    }

    /**
     * Sanitizes a given field name to ensure its safety for use as a key or file name.
     *
     * This method employs two WordPress-sanitization functions. Firstly, `sanitize_file_name`
     * is applied to the field name to remove special characters and ensure valid file name characters.
     * Secondly, `sanitize_key` is used to sanitize the string for use as a key, which involves
     * lowercasing and removing characters that are not alphanumeric or dashes.s
     *
     * @param string $fieldname The field name to be sanitized.
     *
     * @return string Returns the sanitized version of the field name suitable for use as a key or file name.
     */
    protected static function sanitize( string $fieldname, bool $use_dashes = false ): string
    {
        $field_id = sanitize_key(
            sanitize_file_name( $fieldname )
        );

        if ( $use_dashes ) {
            return $field_id;
        }

        return str_replace( '-', '_', $field_id );
    }

    private static function _info( ?string $description_info = null, string $item_id = 'item-description' ): void
    {
        if ( ! $description_info ) {
            return;
        }

        ?>
        <p class="description" id="<?php echo esc_attr( $item_id ); ?>">
            <?php echo wp_kses_post( $description_info ); ?>
        </p>
        <?php
    }
}
