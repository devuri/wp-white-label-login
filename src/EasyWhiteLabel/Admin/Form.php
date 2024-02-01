<?php
/**
 * This file is part of the Easy Video Publisher WordPress PLugin.
 *
 * (c) Uriel Wilson
 *
 * Please see the LICENSE file that was distributed with this source code
 * for full copyright and license information.
 */

namespace EasyWhiteLabel\Admin;

use EasyWhiteLabel\Admin\Form\Traits\Element\CategoryList;
use EasyWhiteLabel\Admin\Form\Traits\Element\DataList;
use EasyWhiteLabel\Admin\Form\Traits\Element\Input;
use EasyWhiteLabel\Admin\Form\Traits\Element\Nonce;
use EasyWhiteLabel\Admin\Form\Traits\Element\Select;
use EasyWhiteLabel\Admin\Form\Traits\Element\TextArea;

/**
 * ----------------------------------------------------------------------------.
 *
 * @copyright   Copyright © 2022 Uriel Wilson.
 *
 * @version     1.3.3
 *
 * @license     GPL-2.0
 * @author      Uriel Wilson
 *
 * @see        https://github.com/devuri/wp-admin-page/
 *
 * ----------------------------------------------------------------------------
 */

class Form
{
    use CategoryList;
    use DataList;
    use Input;
    use Nonce;
    use Select;
    use TextArea;

    /**
     * class version.
     */
    public const ADMINVERSION = '1.3.2';

    /**
     * processing.
     *
     * @var bool
     */
    public $processing = false;

    /**
     * user_feedback.
     *
     * give the user some feedback
     *
     * @param string $class   the css class (success | info | warning | error)
     * @param string $message output message
     *
     * @return string
     *
     * @see https://developer.wordpress.org/reference/hooks/admin_notices/
     * @see https://developer.wordpress.org/reference/functions/__/
     */
    public static function user_feedback( $message = 'Options updated', $class = 'success' ): string
    {
        $user_message  = '<div style="font-size: small; text-transform: capitalize;" id="user-feedback" class="notice notice-' . $class . ' is-dismissible">';
        $user_message .= '<p>';
        $user_message .= $message;
        $user_message .= '</p>';
        $user_message .= '</div>';

        return $user_message;
    }

    /**
     * Retrieves and escapes an option value for HTML attribute use.
     *
     * Fetches an option from the WordPress database using `get_option` and
     * sanitizes it with `esc_attr` for safe HTML attribute inclusion.
     *
     * @param string $option Name of the option to retrieve.
     *
     * @return mixed Escaped option value, or an empty string if the option does not exist.
     */
    public static function get_option( $option )
    {
        return esc_attr( get_option( $option ) );
    }

    /**
     * thickbox builder.
     *
     * @param string $linktext
     * @param string $id
     *
     * @return string .
     */
    public static function thickbox_link( $linktext = 'click here', $id = '' ): string
    {
        return sprintf(
            '<a href="#TB_inline?width=auto&inlineId=%s" class="thickbox">%s</a>',
            $id,
            $linktext,
        );
    }

    /**
     * is_description.
     *
     * set field as required, defaults to false.
     * Also used for input description since we pass back the value as output.
     *
     * @param bool  $required
     * @param mixed $description_info
     *
     * @return null|string
     */
    public static function is_description( $description_info = false ): ?string
    {
        if ( $description_info ) {
            return ' <span style="font-size: unset; color: #939698;" class="description">' . esc_html( $description_info ) . '</span>';
        }

        return null;
    }

    public static function upload( $fieldname = 'upload_image_button', $val = 'Upload Image', $required = false, $type = 'button' ): string
    {
        $fieldname      = strtolower( $fieldname );
        $upload_button  = '<tr class="input">';
        $upload_button .= '<th>';
        $upload_button .= '<label for="' . str_replace( ' ', '_', $fieldname ) . '">';
        $upload_button .= ucwords( str_replace( '_', ' ', $fieldname ) );
        $upload_button .= '</label>';
        $upload_button .= '</th>';
        $upload_button .= '<td>';
        $upload_button .= '<!-- upload field ' . $fieldname . '_input -->';
        $upload_button .= '<input id="' . str_replace( ' ', '_', $fieldname ) . '"';
        $upload_button .= 'type="' . $type . '" class="button"';
        $upload_button .= 'value="' . $val . '" />';
        $upload_button .= '<p class="description" id="' . str_replace( ' ', '-', $fieldname ) . '-description">';
        $upload_button .= strtolower( str_replace( '_', ' ', $fieldname ) );
        $upload_button .= '</p>';
        $upload_button .= '</td>';
        $upload_button .= '</tr>';
        $upload_button .= '<!-- input field ' . $fieldname . '_input -->';

        return $upload_button;
    }

    /**
     * page_list building our own $pages array.
     *
     * @param array $arg [description]
     *
     * @see https://developer.wordpress.org/reference/functions/get_pages/
     *
     * @return array
     */
    public static function page_list( $arg = [] ): array
    {
        $arg = [
            'sort_column' => 'post_date',
            'sort_order'  => 'desc',
        ];
        // get the pages
        $pages     = get_pages( $arg );
        $page_list = [];
        foreach ( $pages as $pkey => $page ) {
            $page_list[ $page->ID ] = $page->post_title;
        }

        return $page_list;
    }

    public static function tr( $html = null, $hr = '<hr>' ): string
    {
        return '<tr style="border-bottom: solid thin #e4e5e6;">' . $html . '</tr>';
    }

    public static function yield_nonce( string $option_group ): void
    {
        settings_fields( $option_group );
    }

    /**
     * Make Table.
     *
     * Use this to create a table for the form
     *
     * @param string $tag     decide to open or close table
     * @param string $tbclass ad css class
     *
     * @return null|string
     */
    public static function table( $tag = 'close', $tbclass = '' ): ?string
    {
        if ( 'open' === $tag ) {
            return '<table class="form-table ' . $tbclass . '" role="presentation"><tbody>';
        }

        if ( 'close' === $tag ) {
            return '</tbody></table>';
        }

        return null;
    }

    /**
     * [submit_button description].
     *
     * @param string $text The text of the button. Default 'Save Changes'.
     * @param string $type The type and CSS class(es) of the button. Core values include 'primary', 'small', and 'large'.
     * @param string $name name of the submit button
     * @param string $wrap True if the output button should be wrapped in a paragraph tag, false otherwise.
     *
     * @return string the button html.
     *
     * @see https://developer.wordpress.org/reference/functions/get_submit_button/
     */
    public static function submit_button( $text = 'Save Changes', $type = 'primary large', $name = 'submit', $wrap = '' ): string
    {
        return get_submit_button( $text, $type, $name, $wrap );
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

    /**
     * @return null
     */
    protected static function is_premium_disable()
    {
        // if ( ! evp_is_premium() ) {
        // return 'disabled';
        // }

        return null;
    }

    /**
     * @return null
     */
    protected static function is_premium_lock()
    {
        // if ( ! evp_is_premium() ) {
        // return '<span style="color: #ff6d36; padding-top: 3px; font-size: x-large;" class="dashicons dashicons-lock"></span>';
        // }

        return null;
    }
}
