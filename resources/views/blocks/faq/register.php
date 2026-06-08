<?php
/**
 * Register FAQ Block
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register Block
acf_register_block_type([
    'name'              => 'peta-faq',
    'title'             => __( 'Peta FAQ', 'dernek-tema' ),
    'description'       => __( 'Sıkça Sorulan Sorular (Akordeon Yapısı)', 'dernek-tema' ),
    'render_template'   => 'resources/views/blocks/faq/faq.php',
    'category'          => 'dernek-blocks',
    'icon'              => 'editor-help',
    'keywords'          => ['faq', 'sss', 'questions', 'accordion'],
    'supports'          => [
        'align' => false,
        'mode'  => false,
        'jsx'   => true,
    ],
]);

// Register Fields
acf_add_local_field_group([
    'key' => 'group_peta_faq',
    'title' => 'Peta FAQ Fields',
    'fields' => [
        [
            'key' => 'field_faq_title',
            'label' => 'Bölüm Başlığı',
            'name' => 'section_title',
            'type' => 'text',
            'default_value' => 'Sıkça Sorulan Sorular',
        ],
        [
            'key' => 'field_faq_repeater',
            'label' => 'Sorular ve Cevaplar',
            'name' => 'faqs',
            'type' => 'repeater',
            'layout' => 'row',
            'button_label' => 'Soru Ekle',
            'default_value' => [
                [
                    'question' => 'Yaptığım bağışlar nereye ulaşıyor?',
                    'answer'   => 'Bağışlarınız, seçtiğiniz kampanya veya proje doğrultusunda doğrudan sahada tespit edilen gerçek ihtiyaç sahiplerine ulaştırılır.',
                ],
                [
                    'question' => 'Bağış sonrası bilgilendirme yapılıyor mu?',
                    'answer'   => 'Evet, bağışınız tamamlandığında SMS ve e-posta ile onay gönderilir. Ayrıca projelerimiz tamamlandığında video ve fotoğraflı raporlar üye panelinizde yayınlanır.',
                ],
                [
                    'question' => 'Zekat bağışı kabul ediyor musunuz?',
                    'answer'   => 'Evet, zekat fonumuz tamamen fıkhi kurallara uygun olarak yönetilir ve yalnızca zekat alabilecek durumdaki kişilere nakdi veya ayni olarak ulaştırılır.',
                ],
                [
                    'question' => 'Bağış makbuzu alabilir miyim?',
                    'answer'   => 'Evet, yaptığınız tüm bağışların makbuzları sistem tarafından otomatik üretilerek üye panelinize yüklenir. İsterseniz adresinize posta yoluyla da gönderilebilir.',
                ]
            ],
            'sub_fields' => [
                [
                    'key' => 'field_faq_question',
                    'label' => 'Soru',
                    'name' => 'question',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_faq_answer',
                    'label' => 'Cevap',
                    'name' => 'answer',
                    'type' => 'textarea',
                    'rows' => 3,
                ],
            ]
        ]
    ],
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/peta-faq',
            ],
        ],
    ],
]);
