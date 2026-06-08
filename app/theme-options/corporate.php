<?php
/**
 * Theme Options: Kurumsal Bilgiler
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
        'page_title'  => __( 'Kurumsal Bilgiler', 'dernek-tema' ),
        'menu_title'  => __( 'Kurumsal Bilgiler', 'dernek-tema' ),
        'parent_slug' => 'dernek-settings',
        'menu_slug'   => 'dernek-corporate-settings',
    ] );

    // Register Field Group
    acf_add_local_field_group( [
        'key' => 'group_dernek_corporate_settings',
        'title' => __( 'Kurumsal Bilgiler', 'dernek-tema' ),
        'fields' => [
            [
                'key' => 'field_corporate_company_name',
                'label' => __( 'Kurum Adı', 'dernek-tema' ),
                'name' => 'company_name',
                'type' => 'text',
                'instructions' => __( 'Kurumun tam yasal veya marka adını girin.', 'dernek-tema' ),
                'required' => 1,
            ],
            [
                'key' => 'field_corporate_company_short_description',
                'label' => __( 'Kısa Açıklama', 'dernek-tema' ),
                'name' => 'company_short_description',
                'type' => 'textarea',
                'instructions' => __( 'Kurumun footer veya kısa tanıtım alanlarında kullanılacak tek cümlelik kısa açıklaması.', 'dernek-tema' ),
                'required' => 0,
                'rows' => 3,
            ],
            [
                'key' => 'field_corporate_company_about',
                'label' => __( 'Kurum Hakkında', 'dernek-tema' ),
                'name' => 'company_about',
                'type' => 'wysiwyg',
                'instructions' => __( 'Kurumun detaylı tanıtım veya hakkında metnini girin.', 'dernek-tema' ),
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'dernek-corporate-settings',
                ],
            ],
        ],
        'menu_order' => 20,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ] );
} );
