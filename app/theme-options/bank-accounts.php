<?php
/**
 * Theme Options: Banka Hesapları
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
        'page_title'  => __( 'Banka Hesapları', 'dernek-tema' ),
        'menu_title'  => __( 'Banka Hesapları', 'dernek-tema' ),
        'parent_slug' => 'dernek-settings',
        'menu_slug'   => 'dernek-bank-settings',
    ] );

    // Register Field Group
    acf_add_local_field_group( [
        'key' => 'group_dernek_bank_accounts',
        'title' => __( 'Banka Hesapları', 'dernek-tema' ),
        'fields' => [
            [
                'key' => 'field_dernek_bank_accounts',
                'label' => __( 'Banka Grupları', 'dernek-tema' ),
                'name' => 'bank_accounts',
                'type' => 'repeater',
                'instructions' => __( 'Her banka için üst bilgileri ve alt hesap satırlarını buradan yönetin.', 'dernek-tema' ),
                'required' => 0,
                'layout' => 'block',
                'button_label' => __( 'Banka Ekle', 'dernek-tema' ),
                'sub_fields' => [
                    [
                        'key' => 'field_dernek_bank_accounts_bank_name',
                        'label' => __( 'Banka Adı', 'dernek-tema' ),
                        'name' => 'bank_name',
                        'type' => 'text',
                        'required' => 1,
                        'maxlength' => 120,
                        'wrapper' => [
                            'width' => '40',
                        ],
                    ],
                    [
                        'key' => 'field_dernek_bank_accounts_account_holder',
                        'label' => __( 'Hesap Sahibi / Adı', 'dernek-tema' ),
                        'name' => 'account_holder',
                        'type' => 'text',
                        'required' => 0,
                        'maxlength' => 120,
                        'wrapper' => [
                            'width' => '30',
                        ],
                    ],
                    [
                        'key' => 'field_dernek_bank_accounts_branch_code',
                        'label' => __( 'Şube No', 'dernek-tema' ),
                        'name' => 'branch_code',
                        'type' => 'text',
                        'required' => 0,
                        'maxlength' => 60,
                        'wrapper' => [
                            'width' => '15',
                        ],
                    ],
                    [
                        'key' => 'field_dernek_bank_accounts_swift_code',
                        'label' => __( 'Swift Kodu', 'dernek-tema' ),
                        'name' => 'swift_code',
                        'type' => 'text',
                        'required' => 0,
                        'maxlength' => 60,
                        'wrapper' => [
                            'width' => '15',
                        ],
                    ],
                    [
                        'key' => 'field_dernek_bank_accounts_accounts',
                        'label' => __( 'Hesap Numaraları', 'dernek-tema' ),
                        'name' => 'accounts',
                        'type' => 'repeater',
                        'instructions' => __( 'Banka için birden fazla hesap satırı ekleyebilirsiniz.', 'dernek-tema' ),
                        'required' => 0,
                        'layout' => 'table',
                        'button_label' => __( 'Hesap No Ekle', 'dernek-tema' ),
                        'sub_fields' => [
                            [
                                'key' => 'field_dernek_bank_accounts_accounts_title',
                                'label' => __( 'Hesap Türü / Başlık', 'dernek-tema' ),
                                'name' => 'title',
                                'type' => 'text',
                                'instructions' => __( 'Örn: TL, USD, EUR', 'dernek-tema' ),
                                'required' => 1,
                                'maxlength' => 120,
                            ],
                            [
                                'key' => 'field_dernek_bank_accounts_accounts_account_number',
                                'label' => __( 'Hesap Numarası', 'dernek-tema' ),
                                'name' => 'account_number',
                                'type' => 'text',
                                'required' => 0,
                                'maxlength' => 120,
                            ],
                            [
                                'key' => 'field_dernek_bank_accounts_accounts_iban',
                                'label' => __( 'IBAN', 'dernek-tema' ),
                                'name' => 'iban_number',
                                'type' => 'text',
                                'required' => 0,
                                'maxlength' => 255,
                            ],
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
                    'value' => 'dernek-bank-settings',
                ],
            ],
        ],
        'menu_order' => 80,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ] );
} );
