<?php
/**
 * Dernek Framework Bootstrap Orchestrator
 *
 * This file dynamically loads all components of the framework in a strict order:
 * 1. Helpers (utility functions)
 * 2. Setup (theme features, enqueues, menus - excluding bootstrap.php itself)
 * 3. Theme Options (theme option pages & panels)
 * 4. CPTs (Custom Post Types and Taxonomies)
 * 5. ACF (Advanced Custom Fields definitions)
 * 6. Services (core business logic)
 * 7. Integrations (external APIs, CRM integrations, etc.)
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Dernek Framework Autoloader / Bootstrap class.
 */
class Dernek_Framework_Bootstrap {

    /**
     * Array of directories to load in sequence.
     * Path is relative to the theme root.
     *
     * @var array
     */
    private static $directories = [
        'app/helpers',
        'app/setup',
        'app/theme-options',
        'app/cpt',
        'app/acf',
        'app/providers',
        'app/services',
        'app/integrations',
    ];

    /**
     * Run the bootloader.
     */
    public static function run() {
        $theme_dir = get_template_directory();

        foreach ( self::$directories as $dir ) {
            $path = $theme_dir . '/' . $dir;

            if ( ! is_dir( $path ) ) {
                continue;
            }

            // Find all PHP files in the directory
            $files = glob( $path . '/*.php' );

            if ( empty( $files ) ) {
                continue;
            }

            // Sort files alphabetically to ensure consistent loading order
            asort( $files );

            foreach ( $files as $file ) {
                // Prevent loading bootstrap.php recursively
                if ( basename( $file ) === 'bootstrap.php' ) {
                    continue;
                }

                // Load file safely
                require_once $file;
            }
        }
    }
}

// Run the bootstrap
Dernek_Framework_Bootstrap::run();
