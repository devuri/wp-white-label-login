<?php

namespace EasyWhiteLabel\Bridge;

/**
 * Interface for option management.
 *
 * Defines the essential methods required for getting, updating, adding,
 * and deleting options. Also includes methods for handling multisite options.
 */
interface OptionInterface
{
    /**
     * Retrieves the value of the specified option.
     *
     * @param string $option  Name of the option to retrieve.
     * @param mixed  $default Optional. Default value to return if the option does not exist.
     *                        Default is false.
     * @return mixed Value of the option or default value if option is not found.
     */
    public function get( $option, $default = false);

    /**
     * Updates the value of an option that was already added.
     *
     * @param string $option Name of the option to update.
     * @param mixed  $value  New value for the option.
     * @return void
     */
    public function update( $option, $value);

    /**
     * Adds a new option.
     *
     * @param string $option Name of the option to add.
     * @param mixed  $value  Value for the new option.
     * @return void
     */
    public function add( $option, $value);

    /**
     * Deletes an option.
     *
     * @param string $option Name of the option to delete.
     * @return void
     */
    public function delete( $option);

    /**
     * Retrieves the value of an option for a multisite network.
     *
     * @param string $option  Name of the option to retrieve.
     * @param mixed  $default Optional. Default value to return if the option does not exist.
     *                        Default is false.
     * @return mixed Value of the site option or default value if option is not found.
     */
    public function getSiteOption( $option, $default = false);

    /**
     * Updates the value of an option for a multisite network.
     *
     * @param string $option Name of the option to update.
     * @param mixed  $value  New value for the option.
     * @return void
     */
    public function updateSiteOption( $option, $value);
}
