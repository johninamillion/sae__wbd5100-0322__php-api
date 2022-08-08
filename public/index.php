<?php

namespace SAE\PHPAPI;

/**
 * Enable error reporting
 *
 * @return void
 */
function enable_error_reporting() : void {
    error_reporting( E_ALL );
    ini_set( 'display_errors', '1' );
    ini_set( 'display_startup_errors', '1' );
}

/**
 * Load configuration file from the project root directory
 *
 * @return void
 */
function load_configuration() : void {
    /** @var string $configuration_file */
    $configuration_file = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config.php';

    if ( !file_exists( $configuration_file ) ) {
        trigger_error(
            sprintf(
                _( 'The configuration file (%s) doesn\'t exist.' ),
                $configuration_file
            ),
            E_USER_ERROR
        );
    }

    require_once $configuration_file;
}

/**
 * Load autoloader from the vendor folder
 *
 * @return void
 */
function load_autoloader() : void {
    /** @var string $autoload_file */
    $autoload_file = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

    if ( !file_exists( $autoload_file ) ) {
        trigger_error(
            sprintf(
                _( 'The autoload file (%s) doesn\'t exist. Please run composer update in your project root directory.' ),
                $autoload_file
            ),
            E_USER_ERROR
        );
    }

    require_once $autoload_file;
}

enable_error_reporting();
load_configuration();
load_autoloader();
( new Application() )->run();