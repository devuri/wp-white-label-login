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

trait Image
{
    /**
     * Draggable grid list of images.
     * requires `draggable.js`.
     *
     * @see https://codepen.io/devuri/pen/JjmYYjR
     *
     * @param array $images
     * @param array $element
     */
    public static function image_grid( array $images = [], array $element = [] ): string
    {
        if ( empty( $images ) ) {
            return false;
        }

        $elem = array_merge(
            [
                'img_class' => 'image-grid-item',
                'div_id'    => 'image-list',
                'input_id'  => 'grid_images',
            ],
            $element
        );

        $imagelist = '';
        foreach ( $images as $key => $img ) {
            $imagelist .= static::img( $img, $elem['img_class'] );
        }

        return sprintf(
            '<tr><!-- grid element %s -->
				<th></th>
					<td>
					    <div id="%s">%s</div>
						<small style="color:#8c8f94;">double click on any item to delete</small>
						<input type="hidden" name="%s" id="%s">
					</td>
			</tr>',
            $elem['div_id'],
            $elem['div_id'],
            $imagelist,
            $elem['input_id'],
            $elem['input_id'],
        );
    }

    protected static function img( $itm_id, string $itm_class ): string
    {
        return sprintf(
            '<img class="%s" id="%s" style="padding-right: 4px; cursor: move;" width="190" src="%s">',
            $itm_class,
            $itm_id,
            wp_get_attachment_url( $itm_id ),
        );
    }
}
