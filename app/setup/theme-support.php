<?php
/**
 * Theme Support Setup
 *
 * Registers support for various WordPress features.
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! function_exists( 'dernek_theme_setup' ) ) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     */
    function dernek_theme_setup() {
        // Add default RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        // Let WordPress manage the document title.
        add_theme_support( 'title-tag' );

        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );

        // Switch default core markup for search form, comment form, etc., to output valid HTML5.
        add_theme_support(
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            ]
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );

        // Add support for core custom logo.
        add_theme_support(
            'custom-logo',
            [
                'height'      => 250,
                'width'       => 250,
                'flex-width'  => true,
                'flex-height' => true,
            ]
        );

        // Add support for Gutenberg Block Editor Styles.
        add_theme_support( 'editor-styles' );

        // Load compiled Tailwind CSS stylesheet in the Gutenberg editor iframe.
        add_editor_style( 'assets/css/app.css' );
    }
}
add_action( 'after_setup_theme', 'dernek_theme_setup' );

/**
 * Gutenberg allowed blocks filter to prevent acf/peta-hero on front page
 */
add_filter( 'allowed_block_types_all', function( $allowed_blocks, $editor_context ) {
    if ( ! empty( $editor_context->post ) ) {
        $post_id = $editor_context->post->ID;
        $front_page_id = (int) get_option( 'page_on_front' );
        
        if ( $post_id === $front_page_id ) {
            if ( is_array( $allowed_blocks ) ) {
                return array_diff( $allowed_blocks, [ 'acf/peta-hero' ] );
            } else {
                $registered_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
                if ( ! empty( $registered_blocks ) ) {
                    $allowed = array_keys( $registered_blocks );
                    return array_diff( $allowed, [ 'acf/peta-hero' ] );
                }
            }
        }
    }
    return $allowed_blocks;
}, 10, 2 );
