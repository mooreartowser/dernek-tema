<?php
/**
 * Register Featured Projects Block
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register Block
acf_register_block_type([
    'name'              => 'peta-featured-projects',
    'title'             => __( 'Peta Featured Projects', 'dernek-tema' ),
    'description'       => __( 'Seçilen projeleri listeleme (CPT Entegrasyon)', 'dernek-tema' ),
    'render_template'   => 'resources/views/blocks/featured-projects/featured-projects.php',
    'category'          => 'dernek-blocks',
    'icon'              => 'portfolio',
    'keywords'          => ['projects', 'featured', 'cpt', 'relationship'],
    'supports'          => [
        'align' => false,
        'mode'  => false,
        'jsx'   => true,
    ],
]);

// Register Fields
acf_add_local_field_group([
    'key' => 'group_peta_featured_projects',
    'title' => 'Peta Featured Projects Fields',
    'fields' => [
        [
            'key' => 'field_feat_proj_title',
            'label' => 'Bölüm Başlığı',
            'name' => 'title',
            'type' => 'text',
            'default_value' => 'Öne Çıkan Yardım Projeleri',
        ],
        [
            'key' => 'field_feat_proj_desc',
            'label' => 'Bölüm Açıklaması',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 2,
            'default_value' => 'Sizlerin destekleriyle hayata geçirdiğimiz ve devam eden bazı yardım projelerimiz.',
        ],
        [
            'key' => 'field_feat_proj_relation',
            'label' => 'Projeleri Seçin',
            'name' => 'selected_projects',
            'type' => 'relationship',
            'post_type' => ['project'],
            'filters' => ['search'],
            'elements' => ['featured_image'],
            'return_format' => 'object',
        ],
    ],
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/peta-featured-projects',
            ],
        ],
    ],
]);
