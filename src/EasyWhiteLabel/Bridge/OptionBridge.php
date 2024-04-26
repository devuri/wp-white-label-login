<?php

namespace EasyWhiteLabel\Bridge;

class OptionBridge implements OptionInterface
{
    private $cache = [];
    private $enable_cache;

	public function __construct( bool $enable_cache = true )
    {
        $this->enable_cache = $enable_cache;
	}

    public function get( $option, $default = false )
    {
		if ( ! $this->enable_cache ) {
			return get_option( $option, $default );
		}

        if ( ! isset( $this->cache[ $option ] ) ) {
            $value = get_option( $option, $default );
            if ( false === $value && null !== $default ) {
                $value = $default;
            }
            $this->cache[ $option ] = $value;
        }
        return $this->cache[ $option ];
    }

    public function update( $option, $value )
    {
        $updated = update_option( $option, $value );
        if ( ! $updated ) {
            throw new \Exception( "Failed to update option '{$option}'." );
        }
        $this->cache[ $option ] = $value;
		// Update cache
        return $updated;
    }

    public function add( $option, $value )
    {
        $added = add_option( $option, $value );
        if ( ! $added ) {
            throw new \Exception( "Failed to add option '{$option}'." );
        }
        $this->cache[ $option ] = $value;
		// Update cache
        return $added;
    }

    public function delete( $option )
    {
        $deleted = delete_option( $option );
        if ( ! $deleted ) {
            throw new \Exception( "Failed to delete option '{$option}'." );
        }
        unset( $this->cache[ $option ] );
		// Invalidate cache
        return $deleted;
    }

    public function getSiteOption( $option, $default = false )
    {
        if ( ! isset( $this->cache[ $option ] ) ) {
            $value = get_site_option( $option, $default );
            if ( false === $value && null !== $default ) {
                $value = $default;
            }
            $this->cache[ $option ] = $value;
        }
        return $this->cache[ $option ];
    }

    public function updateSiteOption( $option, $value )
    {
        $updated = update_site_option( $option, $value );
        if ( ! $updated ) {
            throw new \Exception( "Failed to update site option '{$option}'." );
        }
        $this->cache[ $option ] = $value;
		// Update cache
        return $updated;
    }
}
