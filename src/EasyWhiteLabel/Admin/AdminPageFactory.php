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

class AdminPageFactory
{
    public static function create( string $page_key, array $options = [] ): void
    {
        $use_javascript = $options['use_javascript'] ?? true;
    }
}
