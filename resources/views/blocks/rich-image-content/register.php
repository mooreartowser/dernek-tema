<?php
/**
 * Register Rich Image Content Block
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register Block
acf_register_block_type([
    'name'              => 'peta-rich-image-content',
    'title'             => __( 'Peta Rich Image Content', 'dernek-tema' ),
    'description'       => __( 'Kurumsal sayfalar ve faaliyet içerikleri', 'dernek-tema' ),
    'render_template'   => 'resources/views/blocks/rich-image-content/rich-image-content.php',
    'category'          => 'dernek-blocks',
    'icon'              => 'align-left',
    'keywords'          => ['image', 'content', 'rich', 'corporate'],
    'supports'          => [
        'align' => false,
        'mode'  => false,
        'jsx'   => true,
    ],
]);

// Register Fields
acf_add_local_field_group([
    'key' => 'group_peta_rich_image_content',
    'title' => 'Peta Rich Image Content Fields',
    'fields' => [
        [
            'key' => 'field_ric_eyebrow',
            'label' => 'Eyebrow (Üst Başlık)',
            'name' => 'eyebrow',
            'type' => 'text',
            'default_value' => 'KURUMSAL',
        ],
        [
            'key' => 'field_ric_title',
            'label' => 'Başlık',
            'name' => 'title',
            'type' => 'text',
            'default_value' => '20 Yıllık Tecrübeyle İyiliğin Sesi Oluyoruz',
        ],
        [
            'key' => 'field_ric_description',
            'label' => 'Açıklama',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 3,
            'default_value' => 'Kurulduğumuz günden bu yana, savaş, afet ve yoksulluk yaşanan coğrafyalarda sürdürülebilir projeler üreterek insanların kendi ayakları üzerinde durmasını sağlıyoruz.',
        ],
        [
            'key' => 'field_ric_layout_direction',
            'label' => 'Görsel Hizalama',
            'name' => 'layout_direction',
            'type' => 'select',
            'choices' => [
                'left'  => 'Görsel Sol',
                'right' => 'Görsel Sağ',
            ],
            'default_value' => 'left',
        ],
        [
            'key' => 'field_ric_image_1',
            'label' => 'Görsel 1',
            'name' => 'image_1',
            'type' => 'image',
            'return_format' => 'url',
            'default_value' => get_template_directory_uri() . '/assets/demo/demo_relief.jpg',
            'wrapper' => ['width' => '25%'],
        ],
        [
            'key' => 'field_ric_image_2',
            'label' => 'Görsel 2',
            'name' => 'image_2',
            'type' => 'image',
            'return_format' => 'url',
            'default_value' => get_template_directory_uri() . '/assets/demo/demo_orphan.jpg',
            'wrapper' => ['width' => '25%'],
        ],
        [
            'key' => 'field_ric_image_3',
            'label' => 'Görsel 3',
            'name' => 'image_3',
            'type' => 'image',
            'return_format' => 'url',
            'default_value' => get_template_directory_uri() . '/assets/demo/demo_waterwell.jpg',
            'wrapper' => ['width' => '25%'],
        ],
        [
            'key' => 'field_ric_image_4',
            'label' => 'Görsel 4',
            'name' => 'image_4',
            'type' => 'image',
            'return_format' => 'url',
            'default_value' => get_template_directory_uri() . '/assets/demo/demo_education.jpg',
            'wrapper' => ['width' => '25%'],
        ],
        [
            'key' => 'field_ric_features',
            'label' => 'Özellikler',
            'name' => 'features',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Özellik Ekle',
            'default_value' => [
                [
                    'icon'        => 'ri:group-line',
                    'title'       => 'Şeffaf Yönetim',
                    'description' => 'Tüm bağışlarınız bağımsız denetim kuruluşlarınca denetlenir ve raporlanır.',
                    'cta_text'    => 'Raporları İncele',
                    'cta_url'     => '/projeler',
                ],
                [
                    'icon'        => 'ri:heart-3-line',
                    'title'       => 'Gönüllü Ağı',
                    'description' => 'Dünya genelindeki 10,000+ gönüllümüz ile yardımları en ücra köşelere ulaştırıyoruz.',
                    'cta_text'    => 'Gönüllü Ol',
                    'cta_url'     => '/iletisim',
                ]
            ],
            'sub_fields' => [
                [
                    'key' => 'field_ric_feat_icon',
                    'label' => 'İkon',
                    'name' => 'icon',
                    'type' => 'text',
                    'wrapper' => [
                        'class' => 'mbk-icon-picker',
                    ],
                ],
                [
                    'key' => 'field_ric_feat_title',
                    'label' => 'Başlık',
                    'name' => 'title',
                    'type' => 'text',
                    'wrapper' => ['width' => '50%'],
                ],
                [
                    'key' => 'field_ric_feat_description',
                    'label' => 'Açıklama',
                    'name' => 'description',
                    'type' => 'textarea',
                    'rows' => 2,
                ],
                [
                    'key' => 'field_ric_feat_cta_text',
                    'label' => 'CTA Metni',
                    'name' => 'cta_text',
                    'type' => 'text',
                    'wrapper' => ['width' => '50%'],
                ],
                [
                    'key' => 'field_ric_feat_cta_url',
                    'label' => 'CTA URL',
                    'name' => 'cta_url',
                    'type' => 'text',
                    'wrapper' => ['width' => '50%'],
                ],
            ]
        ]
    ],
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/peta-rich-image-content',
            ],
        ],
    ],
]);
