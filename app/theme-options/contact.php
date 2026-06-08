<?php
/**
 * Theme Options: İletişim Bilgileri
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
        'page_title'  => __( 'İletişim Bilgileri', 'dernek-tema' ),
        'menu_title'  => __( 'İletişim Bilgileri', 'dernek-tema' ),
        'parent_slug' => 'dernek-settings',
        'menu_slug'   => 'dernek-contact-settings',
    ] );

    // Register Field Group
    acf_add_local_field_group( [
        'key' => 'group_dernek_contact_settings',
        'title' => __( 'İletişim Bilgileri', 'dernek-tema' ),
        'fields' => [
            [
                'key' => 'field_contact_phone',
                'label' => __( 'Telefon', 'dernek-tema' ),
                'name' => 'contact_phone',
                'type' => 'text',
                'instructions' => __( 'Kurumun resmi irtibat telefon numarasını girin (Örn: +90 212 000 00 00).', 'dernek-tema' ),
                'required' => 0,
            ],
            [
                'key' => 'field_contact_whatsapp',
                'label' => __( 'Whatsapp', 'dernek-tema' ),
                'name' => 'contact_whatsapp',
                'type' => 'text',
                'instructions' => __( 'Whatsapp yönlendirmesi için kullanılacak numara (Örn: +905320000000).', 'dernek-tema' ),
                'required' => 0,
            ],
            [
                'key' => 'field_contact_email',
                'label' => __( 'E-posta', 'dernek-tema' ),
                'name' => 'contact_email',
                'type' => 'text',
                'instructions' => __( 'İletişim için kullanılacak e-posta adresi.', 'dernek-tema' ),
                'required' => 0,
            ],
            [
                'key' => 'field_contact_address',
                'label' => __( 'Adres', 'dernek-tema' ),
                'name' => 'contact_address',
                'type' => 'textarea',
                'instructions' => __( 'Kurumun fiziksel adres bilgisi.', 'dernek-tema' ),
                'required' => 0,
                'rows' => 3,
            ],
            [
                'key' => 'field_contact_maps_embed',
                'label' => __( 'Google Maps Embed Kodu', 'dernek-tema' ),
                'name' => 'contact_maps_embed',
                'type' => 'textarea',
                'instructions' => __( 'Google Haritalar\'dan aldığınız <iframe> embed kodunu buraya yapıştırın.', 'dernek-tema' ),
                'required' => 0,
                'rows' => 4,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'dernek-contact-settings',
                ],
            ],
        ],
        'menu_order' => 30,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ] );
} );
