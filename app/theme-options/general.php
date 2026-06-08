<?php
/**
 * Theme Options: Genel Ayarlar
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
        'page_title'  => __( 'Genel Ayarlar', 'dernek-tema' ),
        'menu_title'  => __( 'Genel Ayarlar', 'dernek-tema' ),
        'parent_slug' => 'dernek-settings',
        'menu_slug'   => 'dernek-general-settings',
    ] );

    // Register Field Group
    acf_add_local_field_group( [
        'key' => 'group_dernek_general_settings',
        'title' => __( 'Genel Ayarlar', 'dernek-tema' ),
        'fields' => [
            [
                'key' => 'field_general_site_logo',
                'label' => __( 'Site Logosu (Light)', 'dernek-tema' ),
                'name' => 'site_logo',
                'type' => 'image',
                'instructions' => __( 'Sitenin ana logosunu (açık renk arka planlar için) yükleyin.', 'dernek-tema' ),
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ],
            [
                'key' => 'field_general_site_logo_dark',
                'label' => __( 'Site Logosu (Dark)', 'dernek-tema' ),
                'name' => 'site_logo_dark',
                'type' => 'image',
                'instructions' => __( 'Sitenin koyu renk arka planlar için alternatif logosunu yükleyin.', 'dernek-tema' ),
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ],
            [
                'key' => 'field_general_favicon',
                'label' => __( 'Favicon', 'dernek-tema' ),
                'name' => 'favicon',
                'type' => 'image',
                'instructions' => __( 'Tarayıcı sekmesinde görünecek favicon görselini yükleyin.', 'dernek-tema' ),
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ],
            [
                'key' => 'field_general_footer_logo',
                'label' => __( 'Footer Logosu', 'dernek-tema' ),
                'name' => 'footer_logo',
                'type' => 'image',
                'instructions' => __( 'Footer alanında gösterilecek alternatifi (genelde beyaz/light sürüm) yükleyin.', 'dernek-tema' ),
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ],
            [
                'key' => 'field_general_default_page_hero',
                'label' => __( 'Varsayılan Page Hero Görseli', 'dernek-tema' ),
                'name' => 'default_page_hero',
                'type' => 'image',
                'instructions' => __( 'Normal sayfalar için kullanılacak varsayılan arka plan görseli.', 'dernek-tema' ),
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ],
            [
                'key' => 'field_general_default_project_hero',
                'label' => __( 'Varsayılan Proje Hero Görseli', 'dernek-tema' ),
                'name' => 'default_project_hero',
                'type' => 'image',
                'instructions' => __( 'Projeler için kullanılacak varsayılan arka plan görseli.', 'dernek-tema' ),
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ],
            [
                'key' => 'field_general_default_activity_hero',
                'label' => __( 'Varsayılan Faaliyet Hero Görseli', 'dernek-tema' ),
                'name' => 'default_activity_hero',
                'type' => 'image',
                'instructions' => __( 'Faaliyetler için kullanılacak varsayılan arka plan görseli.', 'dernek-tema' ),
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ],
            [
                'key' => 'field_general_default_404_hero',
                'label' => __( 'Varsayılan 404 Hero Görseli', 'dernek-tema' ),
                'name' => 'default_404_hero',
                'type' => 'image',
                'instructions' => __( '404 hata sayfaları için kullanılacak varsayılan arka plan görseli.', 'dernek-tema' ),
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'dernek-general-settings',
                ],
            ],
        ],
        'menu_order' => 10,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ] );
} );
