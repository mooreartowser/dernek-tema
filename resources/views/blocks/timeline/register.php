<?php
/**
 * Register Timeline Block
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register Block
acf_register_block_type([
    'name'              => 'peta-timeline',
    'title'             => __( 'Peta Timeline', 'dernek-tema' ),
    'description'       => __( 'Dernek tarihçesi ve önemli kilometre taşları', 'dernek-tema' ),
    'render_template'   => 'resources/views/blocks/timeline/timeline.php',
    'category'          => 'dernek-blocks',
    'icon'              => 'marker',
    'keywords'          => ['timeline', 'history', 'milestones', 'about'],
    'supports'          => [
        'align' => false,
        'mode'  => false,
        'jsx'   => true,
    ],
]);

// Register Fields
acf_add_local_field_group([
    'key' => 'group_peta_timeline',
    'title' => 'Peta Timeline Fields',
    'fields' => [
        [
            'key' => 'field_timeline_title',
            'label' => 'Bölüm Başlığı',
            'name' => 'section_title',
            'type' => 'text',
            'default_value' => 'Tarihçemiz & Kilometre Taşları',
        ],
        [
            'key' => 'field_timeline_items',
            'label' => 'Tarihçe Kayıtları',
            'name' => 'timeline_items',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Yıl Ekle',
            'default_value' => [
                [
                    'year'        => '2006',
                    'title'       => 'Kuruluş',
                    'description' => 'Bir grup gönüllü ile yetim çocuklara eğitim yardımı ulaştırmak amacıyla derneğimizi kurduk.',
                    'image'       => get_template_directory_uri() . '/assets/demo/demo_waterwell.jpg',
                ],
                [
                    'year'        => '2012',
                    'title'       => 'İlk Yurtdışı Temsilciliği',
                    'description' => 'Afrika\'da kalıcı eserler inşa etmek ve su kuyuları açmak için ilk yurtdışı temsilciliğimizi açtık.',
                    'image'       => get_template_directory_uri() . '/assets/demo/demo_relief.jpg',
                ],
                [
                    'year'        => '2020',
                    'title'       => 'Dijital Dönüşüm & CRM Entegrasyonu',
                    'description' => 'Bağışçılarımızın yardımlarını anlık takip edebileceği şeffaf ve güvenilir bir CRM altyapısına geçiş yaptık.',
                    'image'       => get_template_directory_uri() . '/assets/demo/demo_education.jpg',
                ]
            ],
            'sub_fields' => [
                [
                    'key' => 'field_timeline_year',
                    'label' => 'Yıl',
                    'name' => 'year',
                    'type' => 'text',
                    'wrapper' => ['width' => '30%'],
                ],
                [
                    'key' => 'field_timeline_item_title',
                    'label' => 'Başlık',
                    'name' => 'title',
                    'type' => 'text',
                    'wrapper' => ['width' => '70%'],
                ],
                [
                    'key' => 'field_timeline_item_desc',
                    'label' => 'Açıklama',
                    'name' => 'description',
                    'type' => 'textarea',
                    'rows' => 2,
                ],
                [
                    'key' => 'field_timeline_item_img',
                    'label' => 'Görsel (Opsiyonel)',
                    'name' => 'image',
                    'type' => 'image',
                    'return_format' => 'url',
                ],
            ]
        ]
    ],
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/peta-timeline',
            ],
        ],
    ],
]);
