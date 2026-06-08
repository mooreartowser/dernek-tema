<?php
/**
 * Register Hero Block and Fields
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register Gutenberg Block
acf_register_block_type([
    'name'              => 'peta-hero',
    'title'             => __( 'Peta Hero', 'dernek-tema' ),
    'description'       => __( 'Anasayfa ve iç sayfa giriş alanları', 'dernek-tema' ),
    'render_template'   => 'resources/views/blocks/hero/hero.php',
    'category'          => 'dernek-blocks',
    'icon'              => 'cover-image',
    'keywords'          => ['hero', 'slider', 'banner'],
    'supports'          => [
        'align' => false,
        'mode'  => false,
        'jsx'   => true,
    ],
    'example'           => [
        'attributes' => [
            'mode' => 'preview',
            'data' => [
                'eyebrow'            => 'ACİL YARDIM ÇAĞRISI',
                'title'              => 'Savaş Mağduru Ailelere Umut Olun',
                'description'        => 'Zorlu kış şartlarında hayatta kalma mücadelesi veren binlerce aileye gıda, barınak ve tıbbi malzeme ulaştırmak için ekiplerimiz sahada.',
                'cta_text'           => 'Hemen Bağış Yap',
                'cta_url'            => '#',
                'secondary_cta_text' => 'Faaliyetlerimizi İnceleyin',
                'secondary_cta_url'  => '#',
                'overlay_toggle'     => 1,
            ]
        ]
    ]
]);

// Register ACF fields
acf_add_local_field_group([
    'key' => 'group_peta_hero',
    'title' => 'Peta Hero Fields',
    'fields' => [
        [
            'key' => 'field_hero_eyebrow',
            'label' => 'Eyebrow (Üst Başlık)',
            'name' => 'eyebrow',
            'type' => 'text',
            'default_value' => 'ACİL YARDIM ÇAĞRISI',
        ],
        [
            'key' => 'field_hero_title',
            'label' => 'Başlık',
            'name' => 'title',
            'type' => 'text',
            'default_value' => 'Savaş Mağduru Ailelere Umut Olun',
        ],
        [
            'key' => 'field_hero_description',
            'label' => 'Açıklama',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 3,
            'default_value' => 'Zorlu kış şartlarında hayatta kalma mücadelesi veren binlerce aileye gıda, barınak ve tıbbi malzeme ulaştırmak için ekiplerimiz sahada. Siz de bağışlarınızla destek olabilirsiniz.',
        ],
        [
            'key' => 'field_hero_cta_text',
            'label' => 'CTA Buton Metni',
            'name' => 'cta_text',
            'type' => 'text',
            'default_value' => 'Hemen Bağış Yap',
            'wrapper' => ['width' => '50%'],
        ],
        [
            'key' => 'field_hero_cta_url',
            'label' => 'CTA URL',
            'name' => 'cta_url',
            'type' => 'text',
            'default_value' => '/online-bagis',
            'wrapper' => ['width' => '50%'],
        ],
        [
            'key' => 'field_hero_secondary_cta_text',
            'label' => 'İkinci CTA Buton Metni',
            'name' => 'secondary_cta_text',
            'type' => 'text',
            'default_value' => 'Faaliyetlerimizi İnceleyin',
            'wrapper' => ['width' => '50%'],
        ],
        [
            'key' => 'field_hero_secondary_cta_url',
            'label' => 'İkinci CTA URL',
            'name' => 'secondary_cta_url',
            'type' => 'text',
            'default_value' => '/faaliyetler',
            'wrapper' => ['width' => '50%'],
        ],
        [
            'key' => 'field_hero_bg_image',
            'label' => 'Arka Plan Görseli',
            'name' => 'bg_image',
            'type' => 'image',
            'return_format' => 'url',
            'default_value' => get_template_directory_uri() . '/assets/demo/demo_relief.jpg',
            'wrapper' => ['width' => '50%'],
        ],
        [
            'key' => 'field_hero_mobile_image',
            'label' => 'Mobil Görsel',
            'name' => 'mobile_image',
            'type' => 'image',
            'return_format' => 'url',
            'default_value' => get_template_directory_uri() . '/assets/demo/demo_relief.jpg',
            'wrapper' => ['width' => '50%'],
        ],
        [
            'key' => 'field_hero_overlay_toggle',
            'label' => 'Koyu Overlay Aç/Kapat',
            'name' => 'overlay_toggle',
            'type' => 'true_false',
            'default_value' => 1,
            'ui' => 1,
        ],
    ],
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/peta-hero',
            ],
        ],
    ],
]);
