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

trait Select
{
    /**
     * select field.
     *
     * @param array  $options   [description]
     * @param string $fieldname
     * @param string $js
     * @param bool   $required
     *
     * @return string .
     */
    public static function select_channels( $options = [], $fieldname = 'name', $js = null, $required = false ): string
    {
        $fieldname = strtolower( $fieldname );

        // set selected option
        $selected = self::selected( $options );

        if ( \array_key_exists( 'selected', $options ) ) {
            unset( $options['selected'] );
        }

        // set
        $js_function    = ( $js ) ? $js : '';
        $defualt_select = '<option selected="selected">Select an option</option>';

        // lets build out the select field
        $select  = '';
        $select .= '<tr class="input-' . str_replace( ' ', '-', $fieldname ) . '">';
        $select .= '<th>';
        $select .= '<label for="' . str_replace( ' ', '_', $fieldname ) . '">';
        $select .= ucwords( str_replace( '_', ' ', $fieldname ) );
        $select .= '</label>';
        $select .= '</th>';
        $select .= '<td>';
        $select .= '<select onchange="' . $js_function . '" name="' . strtolower( str_replace( ' ', '_', $fieldname ) ) . '" id="' . strtolower( str_replace( ' ', '_', $fieldname ) ) . '" class="uk-select">';
        // Options list Output.
        if ( \is_array( $options ) ) {
            foreach ( $options as $key => $value ) {
                asort( $value );
                $select .= '<option value="' . $value['channel_id'] . '">' . ucfirst( $value['title'] ) . '</option>';
            }
        }
        $select .= '</select>';
        $select .= ' <strong>' . ucwords( str_replace( '_', ' ', $selected ) ) . '</strong>';
        $select .= '<p class="description" id="' . str_replace( ' ', '-', $fieldname ) . '-description">';
        $select .= strtolower( str_replace( '_', ' ', $fieldname ) );
        $select .= self::is_description( $required );
        $select .= '</p>';
        $select .= '</td>';
        $select .= '</tr>';
        $select .= '<!-- select field ' . $fieldname . '_input -->';

        return $select;
    }

    /**
     * select field.
     *
     * @param array  $options   [description]
     * @param string $fieldname
     * @param string $js
     * @param bool   $required
     *
     * @return string .
     */
    public static function select( $options = [], $fieldname = 'name', $js = null, $required = false ): string
    {
        $fieldname = strtolower( $fieldname );

        // set selected option
        $selected = self::selected( $options );

        if ( \array_key_exists( 'selected', $options ) ) {
            unset( $options['selected'] );
        }

        // set
        $js_function    = ( $js ) ? $js : '';
        $defualt_select = '<option selected="selected">Select an option</option>';

        // lets build out the select field
        $select  = '';
        $select .= '<tr class="input-' . str_replace( ' ', '-', $fieldname ) . '">';
        $select .= '<th>';
        $select .= '<label for="' . str_replace( ' ', '_', $fieldname ) . '">';
        $select .= ucwords( str_replace( '_', ' ', $fieldname ) );
        $select .= '</label>';
        $select .= '</th>';
        $select .= '<td>';
        $select .= '<select onchange="' . $js_function . '" name="' . strtolower( str_replace( ' ', '_', $fieldname ) ) . '" id="' . strtolower( str_replace( ' ', '_', $fieldname ) ) . '" class="uk-select" ' . self::is_premium_disable() . '>';
        // Options list Output.
        if ( \is_array( $options ) ) {
            foreach ( $options as $optkey => $optvalue ) {
                $select .= '<option value="' . $optkey . '">' . ucfirst( $optvalue ) . '</option>';
            }
        }
        $select .= '</select>';
        $select .= ' <strong style="color: #fdc006;">' . ucwords( str_replace( '_', ' ', $selected ) ) . '</strong>' . self::is_premium_lock();
        $select .= '<p class="description" id="' . str_replace( ' ', '-', $fieldname ) . '-description">';
        $select .= strtolower( str_replace( '_', ' ', $fieldname ) );
        $select .= self::is_description( $required );
        $select .= '</p>';
        $select .= '</td>';
        $select .= '</tr>';
        $select .= '<!-- select field ' . $fieldname . '_input -->';

        return $select;
    }


    /**
     * Set the Selected value.
     *
     * @param array $options the options list
     *
     * @return string
     */
    private static function selected( $options = null ): string
    {
        if ( \array_key_exists( 'selected', $options ) ) {
            $selected = $options['selected'];
        } else {
            $selected = '';
        }

        return $selected;
    }
}
