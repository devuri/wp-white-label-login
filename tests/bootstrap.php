<?php

\define('SOP_TEST_MODE', true);
\define('SOP_INTEGRATION_MODE', getenv('SOP_INTEGRATION_MODE')); // true to run integration tests.
\define('SOP_API_TEST_KEY', getenv('SOP_API_TEST_KEY'));

// github actions environment variables.
\define('SOP_GITHUB_EVENT_NAME', getenv('GITHUB_EVENT_NAME'));
\define('SOP_GITHUB_REF', getenv('GITHUB_REF'));
\define('SOP_GITHUB_EVENT_PATH', getenv('GITHUB_EVENT_PATH'));
\define('SOP_GITHUB_HEAD_REF', getenv('GITHUB_HEAD_REF'));
\define('SOP_RUNNER_OS', getenv('RUNNER_OS'));

// Integration or unit tests.
function is_integration_test(): bool
{
    if (getenv('SOP_INTEGRATION_TEST')) {
        return true;
    }

    if (\defined('SOP_INTEGRATION_MODE') && true === SOP_INTEGRATION_MODE) {
        return true;
    }

    return false;
}

// integration or unit tests.
if (is_integration_test()) {
    $_tests_dir = getenv('WP_TESTS_DIR');

    \define('FS_METHOD', 'direct');
    \define('TEST_DIR', \dirname(__FILE__));
    \define('PHPUNIT_RUNNER', true);

    // wp config
    // \define('WP_TESTS_CONFIG_FILE_PATH', \dirname(__FILE__) . '/wp-tests-config.php' );

    if ( ! $_tests_dir) {
        $_tests_dir = rtrim(sys_get_temp_dir(), '/\\') . '/wordpress-tests-lib';
    }

    if ( ! file_exists($_tests_dir . '/includes/functions.php')) {
        echo "Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL;
        exit(1);
    }

    // Give access to tests_add_filter() function.
    require_once $_tests_dir . '/includes/functions.php';

    // Manually load the plugin being tested.
    tests_add_filter('muplugins_loaded', function (): void {
        require \dirname(__FILE__, 2) . '/white-label-login.php';
    } );

    // Start up the WP testing environment.
    require $_tests_dir . '/includes/bootstrap.php';
} else {
    require \dirname(__FILE__, 2) . '/vendor/autoload.php';

    require \dirname(__FILE__, 2) . '/vendor/szepeviktor/phpstan-wordpress/bootstrap.php';

    require \dirname(__FILE__, 2) . '/tests/stubs.php';
}
