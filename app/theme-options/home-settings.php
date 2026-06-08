<?php
/**
 * Theme Options: Ana Sayfa Ayarları
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
        'page_title'  => __( 'Ana Sayfa Ayarları', 'dernek-tema' ),
        'menu_title'  => __( 'Ana Sayfa Ayarları', 'dernek-tema' ),
        'parent_slug' => 'dernek-settings',
        'menu_slug'   => 'dernek-home-settings',
    ] );

    // Register Field Group
    acf_add_local_field_group( [
        'key' => 'group_dernek_home_settings',
        'title' => __( 'Ana Sayfa Ayarları', 'dernek-tema' ),
        'fields' => [
            [
                'key' => 'field_home_slides',
                'label' => __( 'Ana Sayfa Slider Slaytları', 'dernek-tema' ),
                'name' => 'home_slides',
                'type' => 'repeater',
                'instructions' => __( 'Ana sayfadaki manşet slider alanına slayt ekleyin.', 'dernek-tema' ),
                'required' => 0,
                'layout' => 'block',
                'button_label' => __( 'Yeni Slayt Ekle', 'dernek-tema' ),
                'sub_fields' => [
                    [
                        'key' => 'field_home_slide_title',
                        'label' => __( 'Slayt Başlığı', 'dernek-tema' ),
                        'name' => 'slide_title',
                        'type' => 'text',
                        'required' => 1,
                    ],
                    [
                        'key' => 'field_home_slide_desc',
                        'label' => __( 'Slayt Açıklaması', 'dernek-tema' ),
                        'name' => 'slide_description',
                        'type' => 'textarea',
                        'rows' => 2,
                        'required' => 0,
                    ],
                    [
                        'key' => 'field_home_slide_cta',
                        'label' => __( 'Buton Metni', 'dernek-tema' ),
                        'name' => 'slide_cta',
                        'type' => 'text',
                        'default_value' => __( 'Daha Fazla Bilgi', 'dernek-tema' ),
                        'wrapper' => ['width' => '50'],
                    ],
                    [
                        'key' => 'field_home_slide_cta_url',
                        'label' => __( 'Buton Bağlantısı (URL)', 'dernek-tema' ),
                        'name' => 'slide_cta_url',
                        'type' => 'text',
                        'default_value' => '#',
                        'wrapper' => ['width' => '50'],
                    ],
                    [
                        'key' => 'field_home_slide_desktop_image',
                        'label' => __( 'Masaüstü Görseli', 'dernek-tema' ),
                        'name' => 'slide_desktop_image',
                        'type' => 'image',
                        'required' => 1,
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'wrapper' => ['width' => '50'],
                    ],
                    [
                        'key' => 'field_home_slide_mobile_image',
                        'label' => __( 'Mobil Görsel (Opsiyonel)', 'dernek-tema' ),
                        'name' => 'slide_mobile_image',
                        'type' => 'image',
                        'required' => 0,
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                        'wrapper' => ['width' => '50'],
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'dernek-home-settings',
                ],
            ],
        ],
        'menu_order' => 45,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ] );
} );
