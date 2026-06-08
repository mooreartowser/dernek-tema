<?php
/**
 * ACF Custom Fields for Standard Pages
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( [
        'key' => 'group_page_custom_fields',
        'title' => __( 'Sayfa Özel Ayarları', 'dernek-tema' ),
        'fields' => [
            [
                'key' => 'field_page_custom_hero_image',
                'label' => __( 'Özel Hero Görseli (Custom Hero Image)', 'dernek-tema' ),
                'name' => 'custom_hero_image',
                'type' => 'image',
                'instructions' => __( 'Bu sayfa için özel bir Hero arka plan görseli yükleyin. Belirtilmezse varsayılan sayfa hero görseli kullanılır.', 'dernek-tema' ),
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ],
            [
                'key' => 'field_page_custom_hero_description',
                'label' => __( 'Özel Hero Açıklaması', 'dernek-tema' ),
                'name' => 'custom_hero_description',
                'type' => 'textarea',
                'instructions' => __( 'Hero başlığının altında gösterilecek özel açıklama metni.', 'dernek-tema' ),
                'required' => 0,
                'rows' => 2,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
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
