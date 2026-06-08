<?php
/**
 * Register Gallery Block
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register Block
acf_register_block_type([
    'name'              => 'peta-gallery',
    'title'             => __( 'Peta Gallery', 'dernek-tema' ),
    'description'       => __( 'Fotoğraf ve Video galerisi', 'dernek-tema' ),
    'render_template'   => 'resources/views/blocks/gallery/gallery.php',
    'category'          => 'dernek-blocks',
    'icon'              => 'images-alt',
    'keywords'          => ['gallery', 'images', 'photos', 'videos', 'lightbox'],
    'supports'          => [
        'align' => false,
        'mode'  => false,
        'jsx'   => true,
    ],
]);

// Register Fields
acf_add_local_field_group([
    'key' => 'group_peta_gallery',
    'title' => 'Peta Gallery Fields',
    'fields' => [
        [
            'key' => 'field_gallery_title',
            'label' => 'Bölüm Başlığı',
            'name' => 'section_title',
            'type' => 'text',
            'default_value' => 'Faaliyetlerimizden Kareler',
        ],
        [
            'key' => 'field_gallery_images',
            'label' => 'Fotoğraf Galerisi',
            'name' => 'gallery_images',
            'type' => 'gallery',
            'return_format' => 'url',
            'default_value' => [
                get_template_directory_uri() . '/assets/demo/demo_orphan.jpg',
                get_template_directory_uri() . '/assets/demo/demo_waterwell.jpg',
                get_template_directory_uri() . '/assets/demo/demo_relief.jpg',
                get_template_directory_uri() . '/assets/demo/demo_education.jpg'
            ],
        ],
        [
            'key' => 'field_gallery_videos',
            'label' => 'Video Listesi (YouTube / Vimeo / MP4)',
            'name' => 'video_urls',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Video Ekle',
            'default_value' => [
                [
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'title'     => 'Afrika Su Kuyusu Açılış Töreni',
                ],
                [
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'title'     => 'Gıda Kolisi Dağıtım Çalışmaları',
                ]
            ],
            'sub_fields' => [
                [
                    'key' => 'field_gallery_video_url',
                    'label' => 'Video URL',
                    'name' => 'video_url',
                    'type' => 'url',
                    'wrapper' => ['width' => '50%'],
                ],
                [
                    'key' => 'field_gallery_video_title',
                    'label' => 'Video Başlığı',
                    'name' => 'title',
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
                'value' => 'acf/peta-gallery',
            ],
        ],
    ],
]);
