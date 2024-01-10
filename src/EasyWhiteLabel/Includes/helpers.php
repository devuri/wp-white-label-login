<?php

/**
 * Exit On form failure.
 *
 * @param null|string $message
 *
 * @return never
 */
function ewl_fail_exit( ?string $message = null )
{
    if ( ! $message ) {
        $message = esc_html__( 'The Link You Followed Has Expired or Verification Failed', 'wp-white-label-login' );
    }
    exit( $message );
}
