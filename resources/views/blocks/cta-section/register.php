<?php
/**
 * Register CTA Section Block
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register Block
acf_register_block_type([
    'name'              => 'peta-cta-section',
    'title'             => __( 'Peta CTA Section', 'dernek-tema' ),
    'description'       => __( 'Bağış çağrısı veya kurumsal yönlendirme alanı', 'dernek-tema' ),
    'render_template'   => 'resources/views/blocks/cta-section/cta-section.php',
    'category'          => 'dernek-blocks',
    'icon'              => ' megaphone',
    'keywords'          => ['cta', 'call-to-action', 'donation', 'appeal'],
    'supports'          => [
        'align' => false,
        'mode'  => false,
        'jsx'   => true,
    ],
]);

// Register Fields
acf_add_local_field_group([
    'key' => 'group_peta_cta_section',
    'title' => 'Peta CTA Section Fields',
    'fields' => [
        [
            'key' => 'field_cta_title',
            'label' => 'Başlık',
            'name' => 'title',
            'type' => 'text',
            'default_value' => 'Bir Yetimin Hayatını Değiştirmek Sizin Elinizde',
        ],
        [
            'key' => 'field_cta_description',
            'label' => 'Açıklama',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 3,
            'default_value' => 'Dünya genelinde milyonlarca yetim çocuk sıcak bir yuva, eğitim ve sağlıklı gıda bekliyor. Aylık düzenli bağışlarınızla bir yetime sponsor olabilir, onun geleceğini aydınlatabilirsiniz.',
        ],
        [
            'key' => 'field_cta_text',
            'label' => 'CTA Buton Metni',
            'name' => 'cta_text',
            'type' => 'text',
            'default_value' => 'Yetim Sponsoru Ol',
            'wrapper' => ['width' => '50%'],
        ],
        [
            'key' => 'field_cta_url',
            'label' => 'CTA URL',
            'name' => 'cta_url',
            'type' => 'text',
            'default_value' => '/online-bagis',
            'wrapper' => ['width' => '50%'],
        ],
        [
            'key' => 'field_cta_bg_image',
            'label' => 'Arka Plan Görseli',
            'name' => 'bg_image',
            'type' => 'image',
            'return_format' => 'url',
            'default_value' => get_template_directory_uri() . '/assets/demo/demo_relief.jpg',
        ],
        [
            'key' => 'field_cta_impact_cards',
            'label' => 'Etki Kartları (Repeater)',
            'name' => 'impact_cards',
            'type' => 'repeater',
            'layout' => 'table',
            'button_label' => 'Kart Ekle',
            'default_value' => [
                [
                    'title'       => '150 TL',
                    'description' => 'Bir yetimin günlük sıcak yemek ihtiyacını karşılar.',
                ],
                [
                    'title'       => '4500 TL',
                    'description' => 'Bir yetimin yıllık eğitim masraflarını üstlenir.',
                ]
            ],
            'sub_fields' => [
                [
                    'key' => 'field_cta_card_title',
                    'label' => 'Kart Başlığı / Miktar',
                    'name' => 'title',
                    'type' => 'text',
                    'wrapper' => ['width' => '30%'],
                ],
                [
                    'key' => 'field_cta_card_desc',
                    'label' => 'Kart Açıklaması',
                    'name' => 'description',
                    'type' => 'text',
                ],
            ]
        ]
    ],
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/peta-cta-section',
            ],
        ],
    ],
]);
