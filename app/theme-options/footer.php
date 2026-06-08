<?php
/**
 * Theme Options: Footer Ayarları
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
        'page_title'  => __( 'Footer Ayarları', 'dernek-tema' ),
        'menu_title'  => __( 'Footer Ayarları', 'dernek-tema' ),
        'parent_slug' => 'dernek-settings',
        'menu_slug'   => 'dernek-footer-settings',
    ] );

    // Register Field Group
    acf_add_local_field_group( [
        'key' => 'group_dernek_footer_settings',
        'title' => __( 'Footer Ayarları', 'dernek-tema' ),
        'fields' => [
            [
                'key' => 'field_footer_copyright',
                'label' => __( 'Copyright Metni', 'dernek-tema' ),
                'name' => 'footer_copyright',
                'type' => 'text',
                'instructions' => __( 'Telif hakkı bildirim yazısı (Örn: © 2026 Dernek Adı. Tüm Hakları Saklıdır.).', 'dernek-tema' ),
                'required' => 0,
            ],
            [
                'key' => 'field_footer_description',
                'label' => __( 'Footer Açıklaması', 'dernek-tema' ),
                'name' => 'footer_description',
                'type' => 'textarea',
                'instructions' => __( 'Footer logosunun altında gösterilecek tanıtıcı kısa metin.', 'dernek-tema' ),
                'required' => 0,
                'rows' => 3,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'dernek-footer-settings',
                ],
            ],
        ],
        'menu_order' => 60,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ] );
} );
