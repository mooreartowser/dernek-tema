<?php
/**
 * Register Featured Donations Block
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register Block
acf_register_block_type([
    'name'              => 'peta-featured-donations',
    'title'             => __( 'Peta Featured Donations', 'dernek-tema' ),
    'description'       => __( 'Öne çıkan bağış kategorileri tanıtım kartları', 'dernek-tema' ),
    'render_template'   => 'resources/views/blocks/featured-donations/featured-donations.php',
    'category'          => 'dernek-blocks',
    'icon'              => 'heart',
    'keywords'          => ['donations', 'featured', 'cards', 'appeal'],
    'supports'          => [
        'align' => false,
        'mode'  => false,
        'jsx'   => true,
    ],
]);

// Register Fields
acf_add_local_field_group([
    'key' => 'group_peta_featured_donations',
    'title' => 'Peta Featured Donations Fields',
    'fields' => [
        [
            'key' => 'field_feat_don_title',
            'label' => 'Bölüm Başlığı',
            'name' => 'title',
            'type' => 'text',
            'default_value' => 'Hızlı Bağış Kategorileri',
        ],
        [
            'key' => 'field_feat_don_desc',
            'label' => 'Bölüm Açıklaması',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 2,
            'default_value' => 'İyilik yapmak istediğiniz alanı seçerek bağışınızı hemen ulaştırabilirsiniz.',
        ],
        [
            'key' => 'field_feat_don_source_type',
            'label' => __( 'Veri Kaynağı', 'dernek-tema' ),
            'name' => 'source_type',
            'type' => 'select',
            'choices' => [
                'manual' => __( 'Manuel Giriş (ACF Repeater)', 'dernek-tema' ),
                'crm'    => __( 'Canlı CRM Kataloğu (CRM)', 'dernek-tema' ),
            ],
            'default_value' => 'manual',
            'wrapper' => [ 'width' => '50%' ],
        ],
        [
            'key' => 'field_feat_don_crm_categories',
            'label' => __( 'CRM Kategorileri', 'dernek-tema' ),
            'name' => 'crm_categories',
            'type' => 'select',
            'instructions' => __( 'Blokta görüntülenecek canlı CRM kategorilerini seçin.', 'dernek-tema' ),
            'required' => 0,
            'conditional_logic' => [
                [
                    [
                        'field' => 'field_feat_don_source_type',
                        'operator' => '==',
                        'value' => 'crm',
                    ],
                ],
            ],
            'multiple' => 1,
            'ui' => 1,
            'ajax' => 1,
            'choices' => [],
            'wrapper' => [ 'width' => '50%' ],
        ],
        [
            'key' => 'field_feat_don_cards',
            'label' => 'Tanıtım Kartları',
            'name' => 'cards',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Kart Ekle',
            'conditional_logic' => [
                [
                    [
                        'field' => 'field_feat_don_source_type',
                        'operator' => '==',
                        'value' => 'manual',
                    ],
                ],
            ],
            'default_value' => [
                [
                    'image'       => get_template_directory_uri() . '/assets/demo/demo_orphan.jpg',
                    'title'       => 'Yetim Bağışı',
                    'description' => 'Bir yetimin aylık eğitim ve sıcak yemek masraflarını karşılayın.',
                    'url'         => '/online-bagis',
                ],
                [
                    'image'       => get_template_directory_uri() . '/assets/demo/demo_waterwell.jpg',
                    'title'       => 'Su Kuyusu Bağışı',
                    'description' => 'Temiz suya hasret coğrafyalarda kalıcı su kuyuları açın.',
                    'url'         => '/online-bagis',
                ],
                [
                    'image'       => get_template_directory_uri() . '/assets/demo/demo_relief.jpg',
                    'title'       => 'Acil İnsani Yardım',
                    'description' => 'Afet, savaş ve açlık bölgelerine acil gıda ve çadır ulaştırın.',
                    'url'         => '/online-bagis',
                ]
            ],
            'sub_fields' => [
                [
                    'key' => 'field_feat_don_card_img',
                    'label' => 'Kart Görseli',
                    'name' => 'image',
                    'type' => 'image',
                    'return_format' => 'url',
                ],
                [
                    'key' => 'field_feat_don_card_title',
                    'label' => 'Kart Başlığı',
                    'name' => 'title',
                    'type' => 'text',
                    'wrapper' => ['width' => '50%'],
                ],
                [
                    'key' => 'field_feat_don_card_url',
                    'label' => 'Kart Yönlendirme URL',
                    'name' => 'url',
                    'type' => 'text',
                    'wrapper' => ['width' => '50%'],
                ],
                [
                    'key' => 'field_feat_don_card_desc',
                    'label' => 'Açıklama',
                    'name' => 'description',
                    'type' => 'textarea',
                    'rows' => 2,
                ],
            ]
        ]
    ],
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/peta-featured-donations',
            ],
        ],
    ],
]);

// Register AJAX Query Hook for CRM Categories Select Field in Block
add_filter( 'acf/fields/select/query/key=field_feat_don_crm_categories', function( $response, $options ) {
    if ( ! function_exists( 'kadim_crm_bridge' ) ) {
        return $response;
    }
    
    $search = sanitize_text_field( (string) ( $options['s'] ?? '' ) );
    $paged = max( 1, (int) ( $options['paged'] ?? 1 ) );
    
    $catalog_browser = \kadim_crm_bridge()->catalog_browser();
    $result = $catalog_browser->search_categories( $search, '', $paged, 20 );
    
    return [
        'results' => array_map(
            static fn( array $item ): array => [
                'id'   => (string) ( $item['code'] ?? $item['id'] ?? '' ),
                'text' => (string) ( $item['text'] ?? $item['name'] ?? '' )
            ],
            $result['items'] ?? []
        ),
        'more' => (bool) ( $result['more'] ?? false ),
    ];
}, 10, 2 );

// Register Prepare Field Hook to load labels of selected items on post edit page load
add_filter( 'acf/prepare_field/key=field_feat_don_crm_categories', function( $field ) {
    $field['ui'] = 1;
    $field['ajax'] = 1;
    
    if ( ! function_exists( 'kadim_crm_bridge' ) ) {
        return $field;
    }
    
    $selected_values = isset( $field['value'] ) ? (array) $field['value'] : [];
    $selected_values = array_values( array_filter( array_map( 'strval', $selected_values ) ) );
    
    if ( ! empty( $selected_values ) ) {
        $catalog_browser = \kadim_crm_bridge()->catalog_browser();
        $field['choices'] = array_replace( (array) ( $field['choices'] ?? [] ), $catalog_browser->get_category_labels( $selected_values ) );
    }
    
    return $field;
} );
