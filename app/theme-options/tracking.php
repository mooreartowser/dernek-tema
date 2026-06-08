<?php
/**
 * Theme Options: Takip Kodları
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_add_options_sub_page' ) || ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    // Register Sub Page
    acf_add_options_sub_page( [
        'page_title'  => __( 'Takip Kodları', 'dernek-tema' ),
        'menu_title'  => __( 'Takip Kodları', 'dernek-tema' ),
        'parent_slug' => 'dernek-settings',
        'menu_slug'   => 'dernek-tracking-settings',
    ] );

    // Register Field Group
    acf_add_local_field_group( [
        'key' => 'group_dernek_tracking_settings',
        'title' => __( 'Takip Kodları', 'dernek-tema' ),
        'fields' => [
            [
                'key' => 'field_tracking_ga',
                'label' => __( 'Google Analytics Takip Kodu', 'dernek-tema' ),
                'name' => 'tracking_ga',
                'type' => 'textarea',
                'instructions' => __( 'Google Analytics (gtag.js) script kodunu yapıştırın (Örn: <script>...</script>).', 'dernek-tema' ),
                'required' => 0,
                'rows' => 4,
            ],
            [
                'key' => 'field_tracking_gtm',
                'label' => __( 'Google Tag Manager Kodu (Header)', 'dernek-tema' ),
                'name' => 'tracking_gtm',
                'type' => 'textarea',
                'instructions' => __( 'Google Tag Manager header script kodunu yapıştırın (Örn: <script>...</script>).', 'dernek-tema' ),
                'required' => 0,
                'rows' => 4,
            ],
            [
                'key' => 'field_tracking_gsc',
                'label' => __( 'Google Search Console Doğrulama Kodu', 'dernek-tema' ),
                'name' => 'tracking_gsc',
                'type' => 'text',
                'instructions' => __( 'Google Search Console meta doğrulama tag\'inin "content" değerini girin.', 'dernek-tema' ),
                'required' => 0,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'dernek-tracking-settings',
                ],
            ],
        ],
        'menu_order' => 70,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ] );
} );
