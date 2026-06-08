<?php
/**
 * Theme Options: Header Ayarları
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
        'page_title'  => __( 'Header Ayarları', 'dernek-tema' ),
        'menu_title'  => __( 'Header Ayarları', 'dernek-tema' ),
        'parent_slug' => 'dernek-settings',
        'menu_slug'   => 'dernek-header-settings',
    ] );

    // Register Field Group
    acf_add_local_field_group( [
        'key' => 'group_dernek_header_settings',
        'title' => __( 'Header Ayarları', 'dernek-tema' ),
        'fields' => [
            [
                'key' => 'field_header_cta_title',
                'label' => __( 'Header CTA Başlığı', 'dernek-tema' ),
                'name' => 'header_cta_title',
                'type' => 'text',
                'instructions' => __( 'Header alanındaki butonun yazısı (Örn: Bağış Yap).', 'dernek-tema' ),
                'required' => 0,
            ],
            [
                'key' => 'field_header_cta_url',
                'label' => __( 'Header CTA URL', 'dernek-tema' ),
                'name' => 'header_cta_url',
                'type' => 'text',
                'instructions' => __( 'Butonun yönlendirileceği adres (Örn: /iletisim veya https://example.com/iletisim).', 'dernek-tema' ),
                'required' => 0,
            ],
            [
                'key' => 'field_header_donate_cta_title',
                'label' => __( 'Donate CTA Başlığı', 'dernek-tema' ),
                'name' => 'header_donate_cta_title',
                'type' => 'text',
                'instructions' => __( 'Bağış butonunun yazısı (Örn: Hemen Bağış Yap).', 'dernek-tema' ),
                'required' => 0,
            ],
            [
                'key' => 'field_header_donate_cta_url',
                'label' => __( 'Donate CTA URL', 'dernek-tema' ),
                'name' => 'header_donate_cta_url',
                'type' => 'text',
                'instructions' => __( 'Bağış butonunun adresi (Örn: /online-bagis).', 'dernek-tema' ),
                'required' => 0,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'dernek-header-settings',
                ],
            ],
        ],
        'menu_order' => 50,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ] );
} );
