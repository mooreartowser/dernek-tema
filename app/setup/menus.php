<?php
/**
 * Navigation Menus Registration
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! function_exists( 'dernek_register_menus' ) ) {
    /**
     * Register navigation menus.
     */
    function dernek_register_menus() {
        register_nav_menus(
            [
                'primary'          => esc_html__( 'Birincil Menü (Header)', 'dernek-tema' ),
                'footer'           => esc_html__( 'Alt Bilgi Menüsü (Footer)', 'dernek-tema' ),
                'footer_secondary' => esc_html__( 'Alt Bilgi İkincil Menü (Footer)', 'dernek-tema' ),
            ]
        );
    }
}
add_action( 'init', 'dernek_register_menus' );
