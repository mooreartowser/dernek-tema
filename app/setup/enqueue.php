<?php
/**
 * Enqueue scripts and styles
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! function_exists( 'dernek_enqueue_scripts' ) ) {
    /**
     * Enqueue scripts and styles.
     */
    function dernek_enqueue_scripts() {
        // Enqueue Google Fonts
        wp_enqueue_style( 'dernek-fonts', 'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,300;1,9..144,400&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap', [], null );

        // Theme main stylesheet.
        wp_enqueue_style( 'dernek-main-style', get_template_directory_uri() . '/style.css', [], '1.0.0' );

        // Enqueue intl-tel-input for international phone flags, masks and validation
        wp_enqueue_style( 'intl-tel-input', 'https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/css/intlTelInput.min.css', [], '24.5.0' );
        wp_enqueue_script( 'intl-tel-input', 'https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/intlTelInput.min.js', [], '24.5.0', true );

        // Theme resources stylesheet (compiled / assets).
        if ( file_exists( get_template_directory() . '/assets/css/app.css' ) ) {
            wp_enqueue_style( 'dernek-theme-styles', get_template_directory_uri() . '/assets/css/app.css', [], '1.0.0' );
        }

        // Theme resources javascript.
        if ( file_exists( get_template_directory() . '/assets/js/app.js' ) ) {
            wp_enqueue_script( 'dernek-theme-scripts', get_template_directory_uri() . '/assets/js/app.js', [ 'jquery' ], '1.0.0', true );
        }

        // Standard comment reply script if needed.
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'dernek_enqueue_scripts' );

/**
 * Enqueue Google Fonts for the block editor.
 */
add_action( 'enqueue_block_editor_assets', function() {
    wp_enqueue_style( 'dernek-editor-fonts', 'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,300;1,9..144,400&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap', [], null );
} );
