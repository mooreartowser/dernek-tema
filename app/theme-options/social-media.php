<?php
/**
 * Theme Options: Sosyal Medya
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
        'page_title'  => __( 'Sosyal Medya', 'dernek-tema' ),
        'menu_title'  => __( 'Sosyal Medya', 'dernek-tema' ),
        'parent_slug' => 'dernek-settings',
        'menu_slug'   => 'dernek-social-settings',
    ] );

    // Register Field Group
    acf_add_local_field_group( [
        'key' => 'group_dernek_social_settings',
        'title' => __( 'Sosyal Medya', 'dernek-tema' ),
        'fields' => [
            [
                'key' => 'field_social_links',
                'label' => __( 'Sosyal Medya Hesapları', 'dernek-tema' ),
                'name' => 'social_links',
                'type' => 'repeater',
                'instructions' => __( 'Kurumun sosyal medya kanallarını buraya ekleyin.', 'dernek-tema' ),
                'required' => 0,
                'layout' => 'table',
                'button_label' => __( 'Sosyal Medya Hesabı Ekle', 'dernek-tema' ),
                'sub_fields' => [
                    [
                        'key' => 'field_social_links_platform',
                        'label' => __( 'Platform', 'dernek-tema' ),
                        'name' => 'platform',
                        'type' => 'select',
                        'required' => 1,
                        'choices' => [
                            'facebook'  => 'Facebook',
                            'instagram' => 'Instagram',
                            'x'         => 'X (Twitter)',
                            'youtube'   => 'YouTube',
                            'linkedin'  => 'LinkedIn',
                            'tiktok'    => 'TikTok',
                            'other'     => __( 'Diğer', 'dernek-tema' ),
                        ],
                        'default_value' => 'facebook',
                        'wrapper' => [
                            'width' => '30',
                        ],
                    ],
                    [
                        'key' => 'field_social_links_url',
                        'label' => __( 'Profil URL Adresi', 'dernek-tema' ),
                        'name' => 'url',
                        'type' => 'url',
                        'required' => 1,
                        'placeholder' => 'https://...',
                        'wrapper' => [
                            'width' => '70',
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'dernek-social-settings',
                ],
            ],
        ],
        'menu_order' => 40,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ] );
} );
