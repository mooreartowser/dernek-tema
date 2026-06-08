<?php
/**
 * Register Content Section Block
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register Block
acf_register_block_type([
    'name'              => 'peta-content-section',
    'title'             => __( 'Peta Content Section', 'dernek-tema' ),
    'description'       => __( 'Standart içerik alanı (İki sütunlu görsel & metin)', 'dernek-tema' ),
    'render_template'   => 'resources/views/blocks/content-section/content-section.php',
    'category'          => 'dernek-blocks',
    'icon'              => 'editor-paragraph',
    'keywords'          => ['content', 'text', 'section', 'wysiwyg'],
    'supports'          => [
        'align' => false,
        'mode'  => false,
        'jsx'   => true,
    ],
]);

// Register Fields
acf_add_local_field_group([
    'key' => 'group_peta_content_section',
    'title' => 'Peta Content Section Fields',
    'fields' => [
        [
            'key' => 'field_content_sec_title',
            'label' => 'Başlık',
            'name' => 'title',
            'type' => 'text',
            'default_value' => 'Hizmet Alanlarımız ve Amacımız',
        ],
        [
            'key' => 'field_content_sec_editor',
            'label' => 'İçerik',
            'name' => 'content',
            'type' => 'wysiwyg',
            'default_value' => '<p>Dernek olarak, yardımlaşma ve dayanışma bilincini yaygınlaştırmak amacıyla eğitim, gıda ve sağlık gibi hayati alanlarda sürdürülebilir insani yardım faaliyetleri yürütmekteyiz. Her projemizde şeffaflık ve liyakat ilkelerini ön planda tutmaktayız.</p>',
        ],
        [
            'key' => 'field_content_sec_cta_text',
            'label' => 'CTA Metni',
            'name' => 'cta_text',
            'type' => 'text',
            'default_value' => 'Faaliyet Raporu',
            'wrapper' => ['width' => '50%'],
        ],
        [
            'key' => 'field_content_sec_cta_url',
            'label' => 'CTA URL',
            'name' => 'cta_url',
            'type' => 'text',
            'default_value' => '/hakkimizda',
            'wrapper' => ['width' => '50%'],
        ],
        [
            'key' => 'field_content_sec_image',
            'label' => 'Görsel (Opsiyonel)',
            'name' => 'image',
            'type' => 'image',
            'return_format' => 'url',
            'default_value' => get_template_directory_uri() . '/assets/demo/demo_orphan.jpg',
        ],
    ],
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/peta-content-section',
            ],
        ],
    ],
]);
