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

interface PageInterface
{
    /**
     * Processes the data received from a form submission.
     *
     * This method is responsible for handling and processing the data
     * passed via the `$post` array, typically submitted through a form.
     * The method should implement the logic required to process this data,
     * such as validation, sanitization, and storage.
     *
     * @param array $post An associative array of data, typically from a form submission.
     *
     * @return bool Returns true if the data processing is successful, false otherwise.
     */
    public function process( array $post ): bool;

    /**
     * Renders the page content.
     *
     * This method is responsible for rendering the content of the page,
     * including any forms or UI elements. It may optionally use the
     * `$form_title` parameter to display a custom title for the form or
     * content being rendered. If `$form_title` is not provided, a default
     * or no title should be used as per the implementation.
     *
     * @param null|string $form_title Optional. The title to be used for the form or content. Default is null.
     *
     * @return void
     */
    public function render( ?string $form_title = null ): void;
}
