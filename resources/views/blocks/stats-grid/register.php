<?php
/**
 * Register Stats Grid Block
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register Block
acf_register_block_type([
    'name'              => 'peta-stats-grid',
    'title'             => __( 'Peta Stats Grid', 'dernek-tema' ),
    'description'       => __( 'Dernek yardım ve başarı istatistikleri', 'dernek-tema' ),
    'render_template'   => 'resources/views/blocks/stats-grid/stats-grid.php',
    'category'          => 'dernek-blocks',
    'icon'              => 'gridgroups',
    'keywords'          => ['stats', 'grid', 'numbers', 'counters'],
    'supports'          => [
        'align' => false,
        'mode'  => false,
        'jsx'   => true,
    ],
]);

// Register Fields
acf_add_local_field_group([
    'key' => 'group_peta_stats_grid',
    'title' => 'Peta Stats Grid Fields',
    'fields' => [
        [
            'key' => 'field_stats_title',
            'label' => 'Bölüm Başlığı',
            'name' => 'section_title',
            'type' => 'text',
            'default_value' => 'Rakamlarla İyilik Yolculuğumuz',
        ],
        [
            'key' => 'field_stats_repeater',
            'label' => 'İstatistikler',
            'name' => 'stats',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'İstatistik Ekle',
            'default_value' => [
                [
                    'icon'        => 'ri:water-flash-line',
                    'value'       => '4.200+',
                    'title'       => 'Aktif Su Kuyusu',
                    'description' => 'Temiz suya ulaşan insan sayısı 1 milyonu aştı.',
                ],
                [
                    'icon'        => 'ri:heart-add-line',
                    'value'       => '15.000+',
                    'title'       => 'Sponsorlu Yetim',
                    'description' => 'Eğitim, barınma ve gıda ihtiyaçlarını karşılıyoruz.',
                ],
                [
                    'key'         => 'ri:earth-line',
                    'value'       => '42',
                    'title'       => 'Hizmet Ülkesi',
                    'description' => 'İnsani yardımları 4 kıtada en zorlu bölgelere ulaştırıyoruz.',
                ],
                [
                    'icon'        => 'ri:hand-heart-line',
                    'value'       => '120K+',
                    'title'       => 'Mutlu Bağışçı',
                    'description' => 'Şeffaf ve güvenilir yardım faaliyetlerimize destek verenler.',
                ]
            ],
            'sub_fields' => [
                [
                    'key' => 'field_stats_icon',
                    'label' => 'İkon',
                    'name' => 'icon',
                    'type' => 'text',
                    'wrapper' => [
                        'class' => 'mbk-icon-picker',
                    ],
                ],
                [
                    'key' => 'field_stats_value',
                    'label' => 'Değer / Rakam',
                    'name' => 'value',
                    'type' => 'text',
                    'wrapper' => ['width' => '50%'],
                ],
                [
                    'key' => 'field_stats_sub_title',
                    'label' => 'İstatistik Başlığı',
                    'name' => 'title',
                    'type' => 'text',
                    'wrapper' => ['width' => '50%'],
                ],
                [
                    'key' => 'field_stats_description',
                    'label' => 'Kısa Açıklama',
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
                'value' => 'acf/peta-stats-grid',
            ],
        ],
    ],
]);
