<?php

namespace EasyWhiteLabel;

use EasyWhiteLabel\Admin\OptionSettings;

class PageAccess
{
    protected $input_name;
    protected $setting;
    protected $options;
    protected $site_pages;
    protected $is_enabled;
    protected $redirect_url;
    protected $redirect_id;
    protected $page_ids;

    public function __construct( OptionSettings $setting )
    {
        $this->setting    = $setting;
        $this->input_name = $this->setting->get_opt_name();
        $this->options    = $this->setting->get_option();
        $this->site_pages = get_pages();

        // Initialize settings
        add_action(
            'admin_init',
            function (): void {
                $this->setting->register();
                $this->settings( $this->setting );
            }
        );

        $this->redirect_id = $this->options['redirect'] ?? null;
        $this->is_enabled  = $this->options['enabled'] ?? null;
        $this->page_ids    = array_merge( $this->options['pages'] ?? [], [ $this->redirect_id ] );

        add_action( 'template_redirect', [ $this, 'restrict_page_access' ] );
    }

    public static function init( OptionSettings $setting )
    {
        return new self( $setting );
    }

    public function page_redirect_cb(): void
    {
        $this->site_pages[] = (object) [
            'ID'         => 'login',
            'post_title' => 'Login Page',
        ];
        foreach ( $this->site_pages as $page ) {
            $checked    = checked( $this->redirect_id, $page->ID, false );
            $page_title = 'login' === $page->ID ? esc_html( $page->post_title ) : esc_html( "$page->ID $page->post_title" );
            $this->render_redirect_input( $page_title, $page, $checked );
        }
    }

    public function pages_field_cb(): void
    {
        $this->page_ids = $this->options['pages'] ?? [];
        foreach ( $this->site_pages as $page ) {
            $checked = \in_array( $page->ID, $this->page_ids ) ? 'checked' : '';
            $this->render_pages_input( $page, $checked );
        }
    }

    public function page_enable_access_redirect_cb(): void
    {
        $checked = $this->is_enabled ? 'checked' : '';

        $this->setting::input(
            __( 'Enable Page Access Redirect', 'wp-white-label-login' ),
            1,
            [
                'type'    => 'checkbox',
                'name'    => "{$this->input_name}[enabled]",
                'id'      => 'spr_pages_enable_access',
                'checked' => $checked,
            ]
        );
    }

    public function restrict_page_access(): void
    {
        $this->redirect_url = $this->_permalink();

        if ( ! $this->is_enabled ) {
            return;
        }

        $this->page_ids = array_merge( $this->options['pages'] ?? [], [ $this->redirect_id ] );

        if ( current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( is_admin() ) {
            return;
        }

        if ( ! is_page( $this->page_ids ) && ! empty( $this->page_ids ) ) {
            wp_redirect( $this->redirect_url );
            exit;
        }
    }

    protected function render_redirect_input( string $page_title, object $page, $checked ): void
    {
        $this->setting::input(
            $page_title,
            $page->ID,
            [
                'type'    => 'radio',
                'name'    => "{$this->input_name}[redirect]",
                'id'      => 'spr_redirect_page_id',
                'checked' => $checked,
            ]
        );
    }

    protected function render_pages_input( object $page, $checked ): void
    {
        $this->setting::input(
            "$page->ID $page->post_title",
            $page->ID,
            [
                'type'    => 'checkbox',
                'name'    => "{$this->input_name}[pages][{$page->ID}]",
                'id'      => "spr_pages_{$page->ID}",
                'checked' => $checked,
            ]
        );
    }

    protected function settings( $setting ): void
    {
        // Define sections and fields
        $setting->init( 'spr_pages_section' )
            ->add_section( __( 'Select the pages that should be accessible. Others will redirect to the homepage.', 'wp-white-label-login' ) )
            ->add_field( 'spr_select_pages', __( 'Page Access', 'wp-white-label-login' ), [ $this, 'pages_field_cb' ] );

        $setting->init( 'spr_redirect_page' )
            ->add_section( __( 'Select a custom page to redirect user (optional)', 'wp-white-label-login' ) )
            ->add_field( 'spr_redirect_page_id', __( 'Redirect', 'wp-white-label-login' ), [ $this, 'page_redirect_cb' ] );

        $setting->init( 'spr_enable_redirect' )
            ->add_section( __( 'Enable Page Access Redirect', 'wp-white-label-login' ) )
            ->add_field( 'spr_enable_redirect', __( 'Enable Redirect', 'wp-white-label-login' ), [ $this, 'page_enable_access_redirect_cb' ] );
    }

    private function _permalink(): string
    {
        if ( 'login' === $this->redirect_id || ! $this->redirect_id ) {
            return esc_url( wp_login_url() );
        }

        if ( $this->redirect_id ) {
            return esc_url( get_permalink( (int) $this->redirect_id ) );
        }

        return esc_url( get_home_url( '/' ) );
    }
}
