<?php
/**
 * Register Parent Theme Options Page
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

add_action( 'acf/init', function() {
    if ( function_exists( 'acf_add_options_page' ) ) {
        acf_add_options_page( [
            'page_title' => __( 'Dernek Ayarları', 'dernek-tema' ),
            'menu_title' => __( 'Dernek Ayarları', 'dernek-tema' ),
            'menu_slug'  => 'dernek-settings',
            'capability' => 'manage_options',
            'redirect'   => true,
            'icon_url'   => 'dashicons-admin-generic',
            'position'   => 80,
        ] );
    }
}, 9 );

