<?php
/**
 * This file is part of the Easy Video Publisher WordPress PLugin.
 *
 * (c) Uriel Wilson
 *
 * Please see the LICENSE file that was distributed with this source code
 * for full copyright and license information.
 */

namespace EasyWhiteLabel\Admin\Form\Traits\Element;

// @codingStandardsIgnoreFile.

trait Input
{
    /**
     * Generates an HTML input field with optional parameters and a submit button.
     *
     * This static function creates an HTML input field, allowing customization through
     * various parameters. It supports adding a label, custom classes, different input types,
     * and an optional submit button. It also includes accessibility features like `aria-describedby`.
     * The function adheres to WordPress coding standards, ensuring compatibility within WordPress projects.
     *
     * @param string $fieldname The name of the field, defaulting to 'item name'. It is sanitized and
     *                          used for both the input's name and its label. Two versions of sanitization
     *                          are performed: one for the field name (hyphenated) and one for the field ID (underscored).
     * @param string $val       The default value for the input field.
     * @param array  $args      Optional. An array of additional parameters to customize the input field. Possible keys include:
     *                          - 'required' (bool)   : If true, marks the input as required.
     *                          - 'class' (string)    : Additional CSS classes for the input element.
     *                          - 'type' (string)     : The type of the input (e.g., 'text', 'email').
     *                          - 'button' (string)   : If set, adds a submit button with the given label.
     *                          - 'hidden' (bool)     : If true, hides the input field.
     *                          - 'disabled' (bool)   : If true, disables the input field.
     *                          - 'info' (bool|string): Additional information or instructions for the input field.
     *                          - 'width' (string): The <td> width for the input field.
     *
     * @return string The HTML markup for the input field and optional button.
     */
    public static function input( $fieldname = 'item name', $val = '', array $args = [] ): string
    {
        $params = array_merge(
            [
                'required' => false,
                'class'    => 'uk-input',
                'type'     => 'text',
                'button'   => null,
                'hidden'   => false,
                'disabled' => false,
                'info'     => false,
                'width'    => '200',
            ],
            $args,
        );

        // changed to item-name
        $field_name = self::sanitize( $fieldname, true );

        // changed to item_name
        $field_id = self::sanitize( $fieldname );

        // return built out the input
        return sprintf(
            '<!-- input field %s input -->
            <tr class="input-%s"><th>
                <label for="%s">%s</label>
            </th>
                <td width="%s">
                    <input type="%s" name="%s"
                    id="%s" aria-describedby="%s"
                    value="%s" class="%s">
					<p class="description" id="%s">%s %s</p>
                </td>
				<td>%s<p class="description" style="visibility: hidden;">...</p></td>
            </tr>',
            // <!-- comment
            $field_name,
            // class
            $field_name,
            // for label
            $field_id,
            // label
            ucwords( str_replace( '_', ' ', $field_id ) ),
            // width
            $params['width'],
            // type
            $params['type'],
            // name
            $field_id,
            // id
            $field_id,
            // describedby
            $field_name,
            // value
            $val,
            // input class
            esc_attr(  $params['class'] ),
            // <p> id
            $field_name,
            // <p> content
            str_replace( '_', ' ', $field_id ),
            // <p> required text
            static::is_description( $params['info'] ),
            // submit button
            self::input_button( $params['button'] )
        );
    }

    /**
     * input_val.
     *
     * Get the input field $_POST data
     *
     * @param string $input_field input name
     *
     * @return null|string
     */
    public static function input_val( $input_field = null ): ?string
    {
        $input = sanitize_text_field( $_POST[ $input_field ] );
        if ( ! empty( $input ) ) {
            return $input;
        }

        return null;
    }

    /**
     * hidden Input Field.
     *
     * @param string $fieldname the name of the field
     * @param string $val
     *
     * @return string
     */
    public static function input_hidden( $fieldname = 'name', $val = '...' ): string
    {
        $fieldname = strtolower( $fieldname );

        // lets build out the input
        $input_hidden  = '<!-- input field ' . $fieldname . '_input -->';
        $input_hidden .= '<tr class="input">';
        $input_hidden .= '<th>';
        $input_hidden .= '</th>';
        $input_hidden .= '<td>';
        $input_hidden .= '<input type="hidden" name="' . self::sanitize( $fieldname ) . '" id="' . self::sanitize( $fieldname ) . '" value="' . $val . '" class="uk-input">';
        $input_hidden .= '</td>';
        $input_hidden .= '</tr>';
        $input_hidden .= '<!-- input field ' . $fieldname . '_input -->';

        return $input_hidden;
    }

    /**
     * A very basic version of the wp editor.
     *
     * @param string $content   .
     * @param string $editor_id .
     * @param array  $options   .
     *
     * @return false|string
     *
     * @see https://developer.wordpress.org/reference/functions/wp_editor/
     * @see https://developer.wordpress.org/reference/classes/_wp_editors/parse_settings/
     */
    public static function editor( $content = '', $editor_id = 'new_editor', $options = [] )
    {
        ob_start();
        $args = array_merge(
            [
                'media_buttons' => false,
                'quicktags'     => false,
                'tinymce'       => [
                    'toolbar1' => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,bullist,numlist,outdent,indent,blockquote,link,unlink,undo,redo',
                    'toolbar2' => '',
                    'toolbar3' => '',
                ],
            ],
            $options
        );
        wp_editor( $content, $editor_id, $args );

        return ob_get_clean();
    }

    /**
     * Get the ID.
     *
     * @param mixed      $name
     * @param null|mixed $label
     * @param mixed      $description
     */
    public static function button( string $name='Send', $label = null, $description = '', ?string $bg_color = null ): string
    {
        $button_id = self::sanitize( $name );

        $button = '<a name="' . $button_id . '" class="button button-secondary button-large" id="' . $button_id . '" href="#">' . $name . '</a>';

        return self::info( $label, $button, $description, false, $bg_color);
    }

    /**
     * Info for the current item.
     *
     * @param string     $th_label    the heading label
     * @param string     $text        the text description.
     * @param bool       $hr          whether to add bottom border.
     * @param null|mixed $description
     * @param null|mixed $bg_color
     *
     * @return string table row.
     */
    public static function info(?string $th_label = null, $text = null, $description = null, $hr = false, $bg_color = null): string
    {
        $border = $hr ? 'border-bottom: solid thin #ccd0d4;' : '';

        if ( $bg_color ) {
            $background = "background-color: $bg_color;";
        } else {
            $background = '';
        }

        return sprintf(
            '<tr style="%s %s">
                <th>%s</th>
                <td>%s <p id="desc_%s" class="description">%s</p></td>
            </tr>',
            $border,
            $background,
            $th_label,
            $text,
            self::sanitize( $th_label ),
            $description,
        );
    }

    public static function upload( $fieldname = 'upload_image_button', $val = 'Upload Image', $required = false, $type = 'button' )
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
        $upload_button .= '<strong>.</strong>';
        $upload_button .= '</p>';
        $upload_button .= '</td>';
        $upload_button .= '</tr>';
        $upload_button .= '<!-- input field ' . $fieldname . '_input -->';

        return $upload_button;
    }

    /**
     * [thickbox_link description].
     *
     * @param string $linktext
     * @param string $id
     *
     * @return string [type] [description]
     */
    public static function thickboxlink( $linktext = 'click here', $id = '' )
    {
        $link  = '<a href="#TB_inline?width=auto&inlineId=' . $id . '" class="thickbox">';
        $link .= $linktext;
        $link .= '</a>';

        return $link;
    }

    /**
     * Set input button for inline buttons.
     *
     * @param ?string $button
     *
     * @return [type]          [description]
     */
    protected static function input_button( ?string $button ): ?string
    {
        if ( ! \is_null( $button ) ) {
            $button_id = 'submit_' . self::sanitize( $button );

            return static::submit_button( ucwords($button) , 'primary large', $button_id );
        }

        return null;
    }
}
