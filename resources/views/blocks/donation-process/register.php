<?php
/**
 * Register Donation Process Block
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register Block
acf_register_block_type([
    'name'              => 'peta-donation-process',
    'title'             => __( 'Peta Donation Process', 'dernek-tema' ),
    'description'       => __( 'Bağış toplama ve ulaştırma adımları', 'dernek-tema' ),
    'render_template'   => 'resources/views/blocks/donation-process/donation-process.php',
    'category'          => 'dernek-blocks',
    'icon'              => 'random',
    'keywords'          => ['process', 'steps', 'donation', 'workflow'],
    'supports'          => [
        'align' => false,
        'mode'  => false,
        'jsx'   => true,
    ],
]);

// Register Fields
acf_add_local_field_group([
    'key' => 'group_peta_donation_process',
    'title' => 'Peta Donation Process Fields',
    'fields' => [
        [
            'key' => 'field_process_title',
            'label' => 'Bölüm Başlığı',
            'name' => 'section_title',
            'type' => 'text',
            'default_value' => 'Yardımlarınız İhtiyaç Sahiplerine Nasıl Ulaşıyor?',
        ],
        [
            'key' => 'field_process_repeater',
            'label' => 'Süreç Adımları',
            'name' => 'steps',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Adım Ekle',
            'default_value' => [
                [
                    'icon'        => 'ri:bank-card-line',
                    'title'       => 'Bağışın Alınması',
                    'description' => 'Kredi kartı, EFT veya SMS yöntemiyle bağışınız güvenli şekilde sistemimize aktarılır.',
                ],
                [
                    'icon'        => 'ri:survey-line',
                    'title'       => 'İhtiyaç Tespiti',
                    'description' => 'Sahadaki uzman ekiplerimiz en acil yardım gereken bölgeleri ve aileleri raporlar.',
                ],
                [
                    'icon'        => 'ri:truck-line',
                    'title'       => 'Lojistik & Dağıtım',
                    'description' => 'Satın alınan malzemeler paketlenerek yerel koordinatörlerimiz eşliğinde dağıtılır.',
                ],
                [
                    'icon'        => 'ri:folder-shared-line',
                    'title'       => 'Raporlama & Bilgi',
                    'description' => 'Dağıtıma ait fotoğraf, video ve teslimat makbuzu üye panelinize yüklenir.',
                ]
            ],
            'sub_fields' => [
                [
                    'key' => 'field_process_step_icon',
                    'label' => 'İkon',
                    'name' => 'icon',
                    'type' => 'text',
                    'wrapper' => [
                        'class' => 'mbk-icon-picker',
                    ],
                ],
                [
                    'key' => 'field_process_step_title',
                    'label' => 'Adım Başlığı',
                    'name' => 'title',
                    'type' => 'text',
                    'wrapper' => ['width' => '70%'],
                ],
                [
                    'key' => 'field_process_step_desc',
                    'label' => 'Adım Açıklaması',
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
                'value' => 'acf/peta-donation-process',
            ],
        ],
    ],
]);
