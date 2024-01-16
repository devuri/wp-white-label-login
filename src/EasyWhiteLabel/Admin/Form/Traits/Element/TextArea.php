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

trait TextArea
{
    /**
     * Textarea.
     *
     * @param string $fieldname field name
     * @param bool   $required  set the filed to required
     *
     * @return string
     */
    public static function textarea( $fieldname = 'name', $required = false ): string
    {
        $fieldname = strtolower( $fieldname );

        // lets build out the textarea
        $textarea  = '<!-- ' . $fieldname . '_textarea -->';
        $textarea .= '<tr class="textarea">';
        $textarea .= '<th>';
        $textarea .= '<label for="' . str_replace( ' ', '_', $fieldname ) . '">';
        $textarea .= ucwords( str_replace( '_', ' ', $fieldname ) );
        $textarea .= $required;
        $textarea .= '</label>';
        $textarea .= '</th>';
        $textarea .= '<td>';
        $textarea .= '<textarea class="uk-textarea" name="' . str_replace( ' ', '_', $fieldname ) . '_textarea" rows="8" cols="50">';
        $textarea .= '</textarea>';
        $textarea .= '<p class="description" id="' . str_replace( ' ', '-', $fieldname ) . '-description">';
        $textarea .= strtolower( str_replace( '_', ' ', $fieldname ) );
        $textarea .= static::is_description( $required );
        $textarea .= '</p>';
        $textarea .= '</td>';
        $textarea .= '</tr>';
        $textarea .= '<!-- ' . $fieldname . '_textarea -->';

        return $textarea;
    }

    /**
     * Alias for textarea method.
     *
     * @param string $fieldname
     * @param bool   $required
     *
     * @return string
     */
    public static function text_area( $fieldname = 'name', $required = false ): string
    {
        return static::textarea( $fieldname, $required );
    }
}
