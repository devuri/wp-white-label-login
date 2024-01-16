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

trait DataList
{
    public static function datalist(
        array $options = [],
        string $fieldname = 'name',
        ?string $js = null,
        bool $required = false
    ): string {
        $fieldname = strtolower( $fieldname );

        // set selected option
        $selected = self::selected( $options );

        $selects = '';
        if ( \is_array( $options ) ) {
            foreach ( $options as $optkey => $optvalue ) {
                $selects .= '<option value="' . $optvalue . '">';
            }
        }

        return sprintf(
            '<!-- input field %s input -->
				<tr class="input-%s"><th>
					<label for="%s">%s</label>
				</th>
					<td>
					<input style="padding: 8px 4px 8px 8px;" list="%s" id="%s" name="%s" />

					<datalist id="%s">
						%s
					</datalist>
						<p class="description" id="%s">%s %s</p>
					</td>
				</tr>',
            $fieldname,
            // <!-- comment.
            str_replace( ' ', '-', $fieldname ),
            // class.
            str_replace( ' ', '_', $fieldname ),
            // for label.
            ucwords( str_replace( '_', ' ', $fieldname ) ),
            // label.
            str_replace( ' ', '-', $fieldname ),
            // list.
            str_replace( ' ', '-', $fieldname . '-choice' ),
            // input id.
            str_replace( ' ', '-', $fieldname . '-choice' ),
            // input name.
            str_replace( ' ', '-', $fieldname ),
            // datalist id.
            $selects,
            // options in list.
            str_replace( ' ', '-', $fieldname ),
            // <p> id
            strtolower( str_replace( '_', ' ', $fieldname ) ),
            // <p> content.
            static::is_description( $required )
            // <p> required text.
        );
    }
}
