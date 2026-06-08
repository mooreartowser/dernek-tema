<?php
/**
 * Dernek Framework Bootstrap Entry Point
 *
 * This file should not contain any theme logic, helper functions, or hooks.
 * All core setup, CPT registrations, ACF layouts, and custom classes
 * are loaded via the bootstrap.php located in the app/setup directory.
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Bootstrap the framework setup and files
require_once get_template_directory() . '/app/setup/bootstrap.php';
