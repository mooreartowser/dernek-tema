<?php
/**
 * Starter Kit Demo Seeder
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Helper to upload a local theme image to the WP Media Library.
 * Checks if the image is already uploaded by title to prevent duplicates.
 */
function dernek_get_or_create_attachment( $filename, $title ) {
    $theme_dir = get_template_directory();
    $file_path = $theme_dir . '/assets/demo/' . $filename;

    if ( ! file_exists( $file_path ) ) {
        return 0;
    }

    global $wpdb;
    $attachment_id = $wpdb->get_var( $wpdb->prepare(
        "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type = 'attachment'",
        $title
    ) );

    if ( $attachment_id ) {
        return (int) $attachment_id;
    }

    $upload_dir = wp_upload_dir();
    $file_data  = file_get_contents( $file_path );
    $new_file   = $upload_dir['path'] . '/' . $filename;

    file_put_contents( $new_file, $file_data );

    $wp_filetype = wp_check_filetype( $filename, null );
    $attachment = [
        'post_mime_type' => $wp_filetype['type'],
        'post_title'     => sanitize_file_name( $title ),
        'post_content'   => '',
        'post_status'    => 'inherit'
    ];

    $attach_id = wp_insert_attachment( $attachment, $new_file );

    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    $attach_data = wp_generate_attachment_metadata( $attach_id, $new_file );
    wp_update_attachment_metadata( $attach_id, $attach_data );

    return (int) $attach_id;
}

/**
 * Helper to serialize ACF Gutenberg blocks in comment format.
 */
function dernek_serialize_acf_block( $block_name, $data ) {
    $block_data = [
        'name'  => $block_name,
        'data'  => $data,
        'align' => '',
        'mode'  => 'preview'
    ];
    return "<!-- wp:{$block_name} " . json_encode( $block_data, JSON_UNESCAPED_UNICODE ) . " /-->\n";
}

/**
 * Seed starter pages, custom post types, and option settings.
 */
function dernek_seed_starter_kit() {
    if ( get_option( 'dernek_starter_seeded_v6' ) ) {
        return;
    }

    // 1. Upload/Sync All 17 Demo Images + 2 Logos
    $logo_id      = dernek_get_or_create_attachment( 'logo.png', '7 Kita Logo Light' );
    $logo_dark_id = dernek_get_or_create_attachment( 'logo_dark.png', '7 Kita Logo Dark' );

    $hero1_id     = dernek_get_or_create_attachment( 'hero_1.png', 'Demo Hero Su Kuyusu' );
    $hero2_id     = dernek_get_or_create_attachment( 'hero_2.png', 'Demo Hero Egitim' );
    $hero3_id     = dernek_get_or_create_attachment( 'hero_3.png', 'Demo Hero Acil Gida' );

    $project1_id  = dernek_get_or_create_attachment( 'project_1.png', 'Demo Proje Su Kuyusu' );
    $project2_id  = dernek_get_or_create_attachment( 'project_2.png', 'Demo Proje Yetim' );
    $project3_id  = dernek_get_or_create_attachment( 'project_3.png', 'Demo Proje Acil' );
    $project4_id  = dernek_get_or_create_attachment( 'project_4.png', 'Demo Proje Egitim' );

    $activity1_id = dernek_get_or_create_attachment( 'activity_1.png', 'Demo Faaliyet Uganda' );
    $activity2_id = dernek_get_or_create_attachment( 'activity_2.png', 'Demo Faaliyet Gazze' );
    $activity3_id = dernek_get_or_create_attachment( 'activity_3.png', 'Demo Faaliyet Kurban' );
    $activity4_id = dernek_get_or_create_attachment( 'activity_4.png', 'Demo Faaliyet Yetim' );

    $gallery1_id  = dernek_get_or_create_attachment( 'gallery_1.png', 'Demo Galeri Katarakt' );
    $gallery2_id  = dernek_get_or_create_attachment( 'gallery_2.png', 'Demo Galeri Sondaj' );
    $gallery3_id  = dernek_get_or_create_attachment( 'gallery_3.png', 'Demo Galeri Okul Cantasi' );
    $gallery4_id  = dernek_get_or_create_attachment( 'gallery_4.png', 'Demo Galeri Kislik Battaniye' );
    $gallery5_id  = dernek_get_or_create_attachment( 'gallery_5.png', 'Demo Galeri Gunes Enerjisi' );
    $gallery6_id  = dernek_get_or_create_attachment( 'gallery_6.png', 'Demo Galeri Tarim' );

    // URLs for Page content embeddings
    $hero1_url     = $hero1_id ? wp_get_attachment_url( $hero1_id ) : get_template_directory_uri() . '/assets/demo/hero_1.png';
    $hero2_url     = $hero2_id ? wp_get_attachment_url( $hero2_id ) : get_template_directory_uri() . '/assets/demo/hero_2.png';
    $hero3_url     = $hero3_id ? wp_get_attachment_url( $hero3_id ) : get_template_directory_uri() . '/assets/demo/hero_3.png';

    $project1_url  = $project1_id ? wp_get_attachment_url( $project1_id ) : get_template_directory_uri() . '/assets/demo/project_1.png';
    $project2_url  = $project2_id ? wp_get_attachment_url( $project2_id ) : get_template_directory_uri() . '/assets/demo/project_2.png';
    $project3_url  = $project3_id ? wp_get_attachment_url( $project3_id ) : get_template_directory_uri() . '/assets/demo/project_3.png';
    $project4_url  = $project4_id ? wp_get_attachment_url( $project4_id ) : get_template_directory_uri() . '/assets/demo/project_4.png';

    $activity1_url = $activity1_id ? wp_get_attachment_url( $activity1_id ) : get_template_directory_uri() . '/assets/demo/activity_1.png';
    $activity2_url = $activity2_id ? wp_get_attachment_url( $activity2_id ) : get_template_directory_uri() . '/assets/demo/activity_2.png';
    $activity3_url = $activity3_id ? wp_get_attachment_url( $activity3_id ) : get_template_directory_uri() . '/assets/demo/activity_3.png';
    $activity4_url = $activity4_id ? wp_get_attachment_url( $activity4_id ) : get_template_directory_uri() . '/assets/demo/activity_4.png';

    $gallery1_url  = $gallery1_id ? wp_get_attachment_url( $gallery1_id ) : get_template_directory_uri() . '/assets/demo/gallery_1.png';
    $gallery2_url  = $gallery2_id ? wp_get_attachment_url( $gallery2_id ) : get_template_directory_uri() . '/assets/demo/gallery_2.png';
    $gallery3_url  = $gallery3_id ? wp_get_attachment_url( $gallery3_id ) : get_template_directory_uri() . '/assets/demo/gallery_3.png';
    $gallery4_url  = $gallery4_id ? wp_get_attachment_url( $gallery4_id ) : get_template_directory_uri() . '/assets/demo/gallery_4.png';
    $gallery5_url  = $gallery5_id ? wp_get_attachment_url( $gallery5_id ) : get_template_directory_uri() . '/assets/demo/gallery_5.png';
    $gallery6_url  = $gallery6_id ? wp_get_attachment_url( $gallery6_id ) : get_template_directory_uri() . '/assets/demo/gallery_6.png';

    // 2. Build 6 Pages Content Map using Structured ACF blocks serialization
    $home_blocks = '';
    $home_blocks .= dernek_serialize_acf_block( 'acf/peta-stats-grid', [
        'section_title' => 'Rakamlarla 7 Kıta Derneği',
        'stats' => [
            [ 'icon' => 'ri-global-line', 'value' => '24+', 'title' => 'Ülke', 'description' => 'Destek ulaştırdığımız ülke sayısı' ],
            [ 'icon' => 'ri-heart-line', 'value' => '1.2M+', 'title' => 'Faydalanıcı', 'description' => 'Ulaştığımız ihtiyaç sahibi sayısı' ],
            [ 'icon' => 'ri-drop-line', 'value' => '350+', 'title' => 'Su Kuyusu', 'description' => 'Açtığımız temiz su kaynağı sayısı' ],
            [ 'icon' => 'ri-book-open-line', 'value' => '15+', 'title' => 'Eğitim Merkezi', 'description' => 'Hizmete giren yetimhane ve okul' ]
        ]
    ] );
    $home_blocks .= dernek_serialize_acf_block( 'acf/peta-rich-image-content', [
        'eyebrow' => 'BİZ KİMİZ?',
        'title' => 'Yaraları Birlikte Sarıyoruz',
        'description' => '7 Kıta Derneği, din, dil, ırk ayrımı gözetmeksizin dünyanın her yerinde yardıma muhtaç insanların yanında olmayı ilke edinmiş uluslararası bir insani yardım kuruluşudur.',
        'layout_direction' => 'left',
        'features' => [
            [ 'icon' => 'ri-shield-check-line', 'title' => 'Şeffaf ve Güvenilir', 'description' => 'Tüm bağışlarınızın takibini yapıyor, şeffaf süreçlerle raporluyoruz.' ],
            [ 'icon' => 'ri-flashlight-line', 'title' => 'Hızlı ve Etkin Arama Kurtarma', 'description' => 'Afet anında en hızlı şekilde organize olarak sahaya ulaşıyoruz.' ]
        ]
    ] );
    $home_blocks .= dernek_serialize_acf_block( 'acf/peta-featured-projects', [
        'title' => 'Öne Çıkan Yardım Projeleri',
        'description' => 'Desteklerinizle devam eden ve yetimlerden su kuyularına kadar uzanan kalıcı yardım projelerimizi inceleyin.'
    ] );
    $home_blocks .= dernek_serialize_acf_block( 'acf/peta-featured-donations', [
        'title' => 'Hızlı Bağış Kategorileri',
        'description' => 'Dilediğiniz miktarda bağışla katkıda bulunabileceğiniz aktif yardım fonlarımız.',
        'source_type' => 'crm',
        'crm_categories' => [ 'KURBAN', 'YETIM', 'SU_KUYUSU', 'ACIL_YARDIM' ]
    ] );
    $home_blocks .= dernek_serialize_acf_block( 'acf/peta-gallery', [
        'section_title' => 'Sahadan Görseller',
        'gallery_images' => [ $gallery1_url, $gallery2_url, $gallery3_url, $gallery4_url, $gallery5_url, $gallery6_url ],
        'video_urls' => [
            [ 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'title' => 'Tanıtım Filmi' ]
        ]
    ] );
    $home_blocks .= dernek_serialize_acf_block( 'acf/peta-faq', [
        'section_title' => 'Sıkça Sorulan Sorular',
        'faqs' => [
            [ 'question' => 'Bağışlarım yerine ulaşıyor mu?', 'answer' => 'Evet, yaptığınız tüm bağışlar operasyon ekibimiz ve yerel partnerlerimiz eşliğinde ihtiyaç sahiplerine elden teslim edilmekte ve tarafınıza fotoğraf/video olarak raporlanmaktadır.' ],
            [ 'question' => 'Zekatımı derneğinize verebilir miyim?', 'answer' => 'Evet, 7 Kıta Derneği zekat ve sadaka fonlarını ayrı hesaplarda tutarak fıkhi kurallara ve bağışçı şartlarına tam uyumla ihtiyaç sahiplerine ulaştırır.' ]
        ]
    ] );
    $home_blocks .= dernek_serialize_acf_block( 'acf/peta-cta-section', [
        'title' => 'Gelin, İyiliği Birlikte Büyütelim',
        'description' => 'Küçük bir bağış, uzaklardaki bir yetimin tebessümü veya temiz bir su kuyusundan içilen ilk yudum olabilir. Hemen bugün destek olun.',
        'cta_text' => 'Bağış Yap',
        'cta_url' => '/bagislar/',
        'stats_value' => '250.000+',
        'stats_label' => 'Desteklenmiş Yetim ve Çocuk'
    ] );

    $about_blocks = '';
    $about_blocks .= dernek_serialize_acf_block( 'acf/peta-content-section', [
        'eyebrow' => 'KURUMSAL',
        'title' => 'Geleceğe Umutla Bakmak İçin Yola Çıktık',
        'content' => "7 Kıta Derneği, insani yardım alanında yılların birikimine sahip bir ekip tarafından kurulmuştur. Temel vizyonumuz, yoksulluk sınırının altındaki bölgelerde sürdürülebilir kalkınmayı sağlamak ve yerel halkın kendi kendine yetebileceği kalıcı projeler geliştirmektir.\n\nBugün Asya, Afrika ve Ortadoğu başta olmak üzere onlarca ülkede aktif çalışmalar yürütmekteyiz. İnşa ettiğimiz yetimhaneler, okullar, su kuyuları ve tarım projeleri ile kalıcı çözümler üretiyoruz.",
        'image_position' => 'right',
        'image_url' => $hero3_url
    ] );
    $about_blocks .= dernek_serialize_acf_block( 'acf/peta-timeline', [
        'section_title' => 'Kilometre Taşlarımız',
        'timeline_items' => [
            [ 'year' => '2023', 'title' => 'Derneğimizin Kuruluşu', 'description' => 'Gönüllülerimizle birlikte 7 Kıta Derneği kuruldu ve ilk yardım konvoyları yola çıktı.', 'image' => $gallery2_url ],
            [ 'year' => '2024', 'title' => '100+ Su Kuyusu ve Eğitim Entegrasyonu', 'description' => 'Afrika genelinde temiz suya erişim kampanyası başlatıldı ve ilk büyük yetimhane kompleksi hizmete girdi.', 'image' => $gallery3_url ],
            [ 'year' => '2025', 'title' => 'Afet Koordinasyon Merkezi Kuruluşu', 'description' => 'Mobil aşevi ve acil müdahale ekipleri ile Türkiye ve çevre ülkelerde afet yönetim sistemine entegre olundu.', 'image' => $gallery4_url ]
        ]
    ] );
    $about_blocks .= dernek_serialize_acf_block( 'acf/peta-stats-grid', [
        'section_title' => 'Yardım İstatistiklerimiz',
        'stats' => [
            [ 'icon' => 'ri-global-line', 'value' => '24+', 'title' => 'Ülke', 'description' => 'Destek ulaştırdığımız ülke sayısı' ],
            [ 'icon' => 'ri-heart-line', 'value' => '1.2M+', 'title' => 'Faydalanıcı', 'description' => 'Ulaştığımız ihtiyaç sahibi sayısı' ],
            [ 'icon' => 'ri-drop-line', 'value' => '350+', 'title' => 'Su Kuyusu', 'description' => 'Açtığımız temiz su kaynağı sayısı' ],
            [ 'icon' => 'ri-book-open-line', 'value' => '15+', 'title' => 'Eğitim Merkezi', 'description' => 'Hizmete giren yetimhane ve okul' ]
        ]
    ] );
    $about_blocks .= dernek_serialize_acf_block( 'acf/peta-cta-section', [
        'title' => 'Siz de Hamilik Yapabilirsiniz',
        'description' => 'Yetim çocuklarımızın eğitim ve temel yaşam masraflarını karşılayarak geleceklerine katkıda bulunabilirsiniz.',
        'cta_text' => 'Bize Katılın',
        'cta_url' => '/iletisim',
        'stats_value' => '15+',
        'stats_label' => 'Yatılı Eğitim Tesisi'
    ] );

    $project_blocks = '';
    $project_blocks .= dernek_serialize_acf_block( 'acf/peta-content-section', [
        'eyebrow' => 'PROJELERİMİZ',
        'title' => 'Kalıcı Çözümler Üreten Yardımlar',
        'content' => 'Sadece günlük acil yardımlarla yetinmiyoruz; bölgelerin kaderini değiştirecek, sürdürülebilir kalkınmayı destekleyecek eğitim, kalkındırma ve altyapı projelerine odaklanıyoruz. Okullar, su kuyuları, meslek edindirme kursları ile kalıcı eserler bırakıyoruz.',
        'image_position' => 'left',
        'image_url' => $project1_url
    ] );
    $project_blocks .= dernek_serialize_acf_block( 'acf/peta-featured-projects', [
        'title' => 'Aktif Projelerimiz',
        'description' => 'Desteklerinizle yükselen projelerimize omuz verebilir, dilediğiniz tutarda katkıda bulunabilirsiniz.'
    ] );

    $activity_blocks = '';
    $activity_blocks .= dernek_serialize_acf_block( 'acf/peta-content-section', [
        'eyebrow' => 'FAALİYETLERİMİZ',
        'title' => 'Durmaksızın Sahadayız',
        'content' => 'Ekiplerimiz, zorlu coğrafi koşullara ve çatışma bölgelerine rağmen yardımlarınızı en güvenli ve hızlı şekilde ulaştırmak için çalışıyor. İnsani krizlerin yaşandığı her noktada hayat kurtarmaya, acıları dindirmeye devam ediyoruz.',
        'image_position' => 'right',
        'image_url' => $hero3_url
    ] );

    // 10 Detailed SSS Block
    $faq_blocks = '';
    $faq_blocks .= dernek_serialize_acf_block( 'acf/peta-faq', [
        'section_title' => 'Sıkça Sorulan Sorular',
        'faqs' => [
            [
                'question' => 'Zekat bağışımı istediğim bir projeye yönlendirebilir miyim?',
                'answer'   => 'Evet, zekat bağışlarınızı yaparken dilediğiniz özel projeyi (Örn: Yetim, Su Kuyusu vb.) seçebilirsiniz. Bağışınız tamamen o projenin zekat şartlarına uygun kalemlerinde harcanır.'
            ],
            [
                'question' => 'Yaptığım bağışların takibini nasıl yapabilirim?',
                'answer'   => 'Tüm bağışlarınız sisteme kaydedildiğinde size SMS ve e-posta ile bilgi gönderilir. Ayrıca su kuyusu gibi kalıcı projeler tamamlandığında fotoğraf ve video raporları tarafınıza iletilir.'
            ],
            [
                'question' => 'Bağışlarımdan vergi indirimi alabilir miyim?',
                'answer'   => 'Evet, derneğimiz kamu yararına çalışan dernekler statüsünde olduğundan, yaptığınız bağış makbuzları ile gelir vergisi beyannamenizde matrahtan indirim alabilirsiniz.'
            ],
            [
                'question' => 'Zekat ve sadaka bağışları ayrı havuzlarda mı tutuluyor?',
                'answer'   => 'Kesinlikle. Fıkhi hassasiyetler gereği zekat bağışları ayrı fonlarda toplanır ve sadece zekat verilebilecek kişilere/ihtiyaçlara harcanır. Sadaka ve genel bağışlar ise kendi havuzlarında yönetilir.'
            ],
            [
                'question' => 'Yetim sponsorluk bedeli ne kadardır ve neleri kapsar?',
                'answer'   => 'Aylık yetim sponsorluk bedeli 500 TL\'dir. Bu miktar bir yetim çocuğumuzun aylık eğitim, gıda, barınma ve temel sağlık giderlerini karşılamak amacıyla kullanılmaktadır.'
            ],
            [
                'question' => 'Su kuyusu açtırmak istiyorum, süreç nasıl işliyor?',
                'answer'   => 'Su kuyusu talebiniz alındıktan sonra ekiplerimiz en çok ihtiyaç duyulan bölgeleri tespit eder. Kuyu açıldıktan sonra tabelanız asılır, video ve koordinat bilgileri sizinle paylaşılır. Süreç ortalama 3-6 ay sürmektedir.'
            ],
            [
                'question' => 'Bağış yaparken kredi kartı güvenliği nasıl sağlanıyor?',
                'answer'   => 'Web sitemizdeki tüm kredi kartı bağış işlemleri 256-bit SSL şifreleme ve banka onaylı 3D Secure güvenli ödeme geçidi üzerinden güvenle gerçekleştirilmektedir.'
            ],
            [
                'question' => 'Derneğinizin idari giderleri bağışlardan mı karşılanıyor?',
                'answer'   => 'İdari ve operasyonel giderlerimiz genel bağış havuzumuzdaki idari hisselerden veya kurum içi sponsorluklar ve ticari işletme gelirlerinden fıkhi sınırlar dahilinde karşılanır. Proje bağışlarınız doğrudan sahaya aktarılır.'
            ],
            [
                'question' => 'Yurt dışı kurban organizasyonlarınız nasıl yapılıyor?',
                'answer'   => 'Kurbanlarınız veteriner kontrolünde, İslami usullere uygun olarak kesilir. Kesim anında isminizin okunduğu video kaydı alınarak cep telefonunuza SMS ile gönderilir ve etler paylar halinde dağıtılır.'
            ],
            [
                'question' => 'Gönüllü olarak çalışmalarınıza nasıl katılabilirim?',
                'answer'   => 'İletişim sayfamızdaki gönüllülük formunu doldurarak veya merkez ofisimizle irtibata geçerek saha çalışmalarımıza, yardım dağıtımlarına ve dernek etkinliklerimize gönüllü olarak destek verebilirsiniz.'
            ]
        ]
    ] );

    // Rich İletişim Page Content
    $contact_blocks = '';
    $contact_blocks .= dernek_serialize_acf_block( 'acf/peta-content-section', [
        'eyebrow' => 'İLETİŞİM',
        'title' => 'Bizimle İletişime Geçin',
        'content' => 'Sorularınız, iş birlikleri veya bağış kanallarımız hakkında detaylı bilgi almak için merkez ofisimizle irtibata geçebilirsiniz. Gönüllülük ve destek süreçleri hakkında ekibimiz size yardımcı olmaktan memnuniyet duyacaktır.',
        'image_position' => 'left',
        'image_url' => $hero2_url
    ] );
    $contact_blocks .= "<!-- wp:columns {\"className\":\"gap-8 mt-8\"} -->\n";
    $contact_blocks .= "<div class=\"wp-block-columns gap-8 mt-8\">\n";
    $contact_blocks .= "  <!-- wp:column {\"width\":\"40%\"} -->\n";
    $contact_blocks .= "  <div class=\"wp-block-column\" style=\"flex-basis:40%\">\n";
    $contact_blocks .= "    <!-- wp:heading {\"level\":3,\"className\":\"font-heading font-bold text-2xl text-secondary border-b border-border pb-3 mb-6\"} -->\n";
    $contact_blocks .= "    <h3 class=\"font-heading font-bold text-2xl text-secondary border-b border-border pb-3 mb-6\">İletişim Bilgileri</h3>\n";
    $contact_blocks .= "    <!-- /wp:heading -->\n";
    $contact_blocks .= "    <!-- wp:paragraph {\"className\":\"text-sm text-text-muted mb-4\"} -->\n";
    $contact_blocks .= "    <p class=\"text-sm text-text-muted mb-4\">Her türlü soru, öneri veya iş birliği talepleriniz için bize ulaşabilirsiniz.</p>\n";
    $contact_blocks .= "    <!-- /wp:paragraph -->\n";
    $contact_blocks .= "    <!-- wp:html -->\n";
    $contact_blocks .= "    <div class=\"flex flex-col gap-4 font-sans text-sm text-text\">\n";
    $contact_blocks .= "        <div class=\"flex gap-3 items-start\">\n";
    $contact_blocks .= "            <i class=\"ri-map-pin-2-fill text-primary text-xl mt-0.5\"></i>\n";
    $contact_blocks .= "            <div>\n";
    $contact_blocks .= "                <strong class=\"block text-secondary\">Genel Merkez:</strong>\n";
    $contact_blocks .= "                <span>Merkez Mah. İstiklal Cad. No: 77 Kat: 7, Fatih / İstanbul</span>\n";
    $contact_blocks .= "            </div>\n";
    $contact_blocks .= "        </div>\n";
    $contact_blocks .= "        <div class=\"flex gap-3 items-center\">\n";
    $contact_blocks .= "            <i class=\"ri-phone-fill text-primary text-xl\"></i>\n";
    $contact_blocks .= "            <div>\n";
    $contact_blocks .= "                <strong class=\"block text-secondary\">Telefon:</strong>\n";
    $contact_blocks .= "                <a href=\"tel:+902127777777\" class=\"hover:text-primary transition-colors\">+90 212 777 77 77</a>\n";
    $contact_blocks .= "            </div>\n";
    $contact_blocks .= "        </div>\n";
    $contact_blocks .= "        <div class=\"flex gap-3 items-center\">\n";
    $contact_blocks .= "            <i class=\"ri-whatsapp-fill text-emerald-500 text-xl\"></i>\n";
    $contact_blocks .= "            <div>\n";
    $contact_blocks .= "                <strong class=\"block text-secondary\">WhatsApp:</strong>\n";
    $contact_blocks .= "                <a href=\"https://wa.me/905327777777\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"hover:text-emerald-500 transition-colors font-semibold text-emerald-600\">+90 532 777 77 77</a>\n";
    $contact_blocks .= "            </div>\n";
    $contact_blocks .= "        </div>\n";
    $contact_blocks .= "        <div class=\"flex gap-3 items-center\">\n";
    $contact_blocks .= "            <i class=\"ri-mail-fill text-primary text-xl\"></i>\n";
    $contact_blocks .= "            <div>\n";
    $contact_blocks .= "                <strong class=\"block text-secondary\">E-Posta:</strong>\n";
    $contact_blocks .= "                <a href=\"mailto:bilgi@7kitadernegi.org\" class=\"hover:text-primary transition-colors\">bilgi@7kitadernegi.org</a>\n";
    $contact_blocks .= "            </div>\n";
    $contact_blocks .= "        </div>\n";
    $contact_blocks .= "    </div>\n";
    $contact_blocks .= "    <!-- /wp:html -->\n";
    $contact_blocks .= "  </div>\n";
    $contact_blocks .= "  <!-- /wp:column -->\n";
    $contact_blocks .= "  <!-- wp:column {\"width\":\"60%\"} -->\n";
    $contact_blocks .= "  <div class=\"wp-block-column\" style=\"flex-basis:60%\">\n";
    $contact_blocks .= "    <!-- wp:html -->\n";
    $contact_blocks .= "    <div class=\"w-full h-[350px] rounded-large overflow-hidden border border-border shadow-sm\">\n";
    $contact_blocks .= "        <iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3010.2372793617343!2d28.9730594!3d41.0152914!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14cab985a1a1f0b5%3A0xc3c5b8b9f1d0a5e8!2sFatih%2F%C4%B0stanbul!5e0!3m2!1str!2str!4v1717520000000!5m2!1str!2str\" width=\"100%\" height=\"100%\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>\n";
    $contact_blocks .= "    </div>\n";
    $contact_blocks .= "    <!-- /wp:html -->\n";
    $contact_blocks .= "  </div>\n";
    $contact_blocks .= "  <!-- /wp:column -->\n";
    $contact_blocks .= "</div>\n";
    $contact_blocks .= "<!-- /wp:columns -->\n";

    $pages = [
        'anasayfa' => [
            'title'   => 'Anasayfa',
            'content' => $home_blocks,
        ],
        'hakkimizda' => [
            'title'   => 'Hakkımızda',
            'content' => $about_blocks,
        ],
        'projeler' => [
            'title'   => 'Projeler',
            'content' => $project_blocks,
        ],
        'faaliyetler' => [
            'title'   => 'Faaliyetler',
            'content' => $activity_blocks,
        ],
        'iletisim' => [
            'title'   => 'İletişim',
            'content' => $contact_blocks,
        ],
        'sss' => [
            'title'   => 'Sıkça Sorulan Sorular',
            'content' => $faq_blocks,
        ],
        'bagislar' => [
            'title'   => 'Bağışlar',
            'content' => '',
            'template'=> 'template-donation-catalog.php',
        ],
        'odeme' => [
            'title'   => 'Ödeme',
            'content' => '',
        ],
        'tesekkur' => [
            'title'   => 'Teşekkür Ederiz',
            'content' => '',
        ]
    ];

    $front_page_id = 0;

    foreach ( $pages as $slug => $page_info ) {
        $existing = get_page_by_path( $slug );
        $post_id = 0;
        if ( ! $existing ) {
            $post_id = wp_insert_post([
                'post_title'   => $page_info['title'],
                'post_name'    => $slug,
                'post_content' => $page_info['content'],
                'post_status'  => 'publish',
                'post_type'    => 'page',
            ]);
            
            if ( $slug === 'anasayfa' && $post_id && ! is_wp_error( $post_id ) ) {
                $front_page_id = $post_id;
            }
        } else {
            // Update page content to ensure blocks match the new spec
            wp_update_post([
                'ID'           => $existing->ID,
                'post_content' => $page_info['content'],
            ]);
            $post_id = $existing->ID;
            if ( $slug === 'anasayfa' ) {
                $front_page_id = $existing->ID;
            }
        }

        if ( $post_id && ! is_wp_error( $post_id ) && ! empty( $page_info['template'] ) ) {
            update_post_meta( $post_id, '_wp_page_template', $page_info['template'] );
        }
    }

    if ( $front_page_id ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page_id );
    }

    // 3. Seed 4 Projects CPT with galleries and target/collected metrics
    $demo_projects = [
        [
            'title'     => 'Su Kuyusu Projesi',
            'slug'      => 'su-kuyusu-projesi',
            'image_id'  => $project1_id,
            'collected' => 90000,
            'target'    => 150000,
            'desc'      => 'Afrika ve Asya’da çorak topraklarda temiz suya hasret topluluklar için kalıcı derin sondaj su kuyuları açıyoruz.',
            'gallery'   => [ $gallery1_url, $gallery2_url, $gallery3_url ]
        ],
        [
            'title'     => 'Yetim Destek Programı',
            'slug'      => 'yetim-destek-programi',
            'image_id'  => $project2_id,
            'collected' => 40000,
            'target'    => 60000,
            'desc'      => 'Savaş ve doğal afet bölgelerindeki yetimlerimizin eğitim, sıcak yemek ve giyim ihtiyaçlarını karşılayarak geleceklerini koruyoruz.',
            'gallery'   => [ $gallery4_url, $gallery5_url, $gallery6_url ]
        ],
        [
            'title'     => 'Acil Yardım Fonu',
            'slug'      => 'acil-yardim-fonu',
            'image_id'  => $project3_id,
            'collected' => 110000,
            'target'    => 200000,
            'desc'      => 'Doğal afetler, insani krizler ve çatışma bölgelerindeki ailelere en hızlı şekilde çadır, battaniye ve gıda kolileri ulaştırıyoruz.',
            'gallery'   => [ $gallery1_url, $gallery3_url, $gallery4_url ]
        ],
        [
            'title'     => 'Eğitim Destek Programı',
            'slug'      => 'egitim-destek-programi',
            'image_id'  => $project4_id,
            'collected' => 150000,
            'target'    => 300000,
            'desc'      => 'Yoksul coğrafyalarda kırtasiye paketleri dağıtıyor, burs imkanı sağlıyor ve hasar görmüş okul sınıflarını yeniliyoruz.',
            'gallery'   => [ $gallery2_url, $gallery5_url, $gallery6_url ]
        ]
    ];

    foreach ( $demo_projects as $p ) {
        $existing = get_page_by_path( $p['slug'], OBJECT, 'project' );
        
        $p_content = "<!-- wp:paragraph -->\n<p>{$p['desc']} Bu kalıcı insani yardım çalışması bağışçılarımızın zekat ve sadaka destekleriyle yürütülmektedir. Proje kapsamında sahadan gelen en son görseller aşağıda listelenmiştir.</p>\n<!-- /wp:paragraph -->\n";
        $p_content .= dernek_serialize_acf_block( 'acf/peta-gallery', [
            'section_title'  => 'Proje Sahasından Görseller',
            'gallery_images' => $p['gallery']
        ] );

        $post_data = [
            'post_title'   => $p['title'],
            'post_name'    => $p['slug'],
            'post_content' => $p_content,
            'post_status'  => 'publish',
            'post_type'    => 'project',
        ];

        if ( ! $existing ) {
            $post_id = wp_insert_post( $post_data );
        } else {
            $post_data['ID'] = $existing->ID;
            $post_id = wp_update_post( $post_data );
        }

        if ( $post_id && ! is_wp_error( $post_id ) ) {
            if ( $p['image_id'] ) {
                set_post_thumbnail( $post_id, $p['image_id'] );
            }
            update_field( 'collected_amount', $p['collected'], $post_id );
            update_field( 'target_amount', $p['target'], $post_id );
        }
    }

    // 4. Seed 4 Activities CPT with detailed contents and galleries
    $demo_activities = [
        [
            'title'    => 'Uganda Saha Ziyareti ve Yardım Dağıtımı',
            'slug'     => 'uganda-saha-ziyareti',
            'image_id' => $activity1_id,
            'desc'     => 'Ekiplerimiz Uganda kırsalındaki 10 köyde gerçekleştirdiği saha taramaları sonrasında gıda kolisi dağıtımlarını tamamladı. Ziyaretimiz sırasında bölge halkıyla birebir görüşülerek yeni su kuyusu ihtiyaçları yerinde tespit edildi.',
            'gallery'  => [ $gallery1_url, $gallery2_url ]
        ],
        [
            'title'    => 'Gazze Acil Yardım Operasyonu Tamamlandı',
            'slug'     => 'gazze-yardim-operasyonu',
            'image_id' => $activity2_id,
            'desc'     => 'Ağır insani krizle mücadele eden Gazze şeridinde, yerel ekiplerimiz aracılığıyla 1.000 aileye sıcak yemek ve hijyen paketleri ulaştırıldı. Zorlu lojistik koşullara rağmen yardımlarınızı sahaya ulaştırmaya devam ediyoruz.',
            'gallery'  => [ $gallery3_url, $gallery4_url ]
        ],
        [
            'title'    => 'Uluslararası Kurban Organizasyonu Tamamlandı',
            'slug'     => 'kurban-organizasyonu',
            'image_id' => $activity3_id,
            'desc'     => 'Vekaletini aldığımız kurbanların kesimleri İslami usullere göre veteriner kontrolünde tamamlanarak, hisse sahiplerinin isimlerinin okunduğu videolar SMS ile gönderildi. Kurban etleri Asya ve Afrika’daki muhtaç ailelere elden ulaştırıldı.',
            'gallery'  => [ $gallery5_url, $gallery6_url ]
        ],
        [
            'title'    => 'İstanbul’da Geleneksel Yetim Buluşması Şenliği',
            'slug'     => 'yetim-bulusmasi',
            'image_id' => $activity4_id,
            'desc'     => 'Derneğimizin hamilik üstlendiği yetim çocuklarımızla birlikte eğlenceli yarışmalar, çocuk oyunları ve hediyeleşme etkinliklerinin yer aldığı Geleneksel Yetim Şenliği düzenlendi. Çocuklarımızın mutluluğu yüzlerinden okundu.',
            'gallery'  => [ $gallery1_url, $gallery3_url ]
        ]
    ];

    foreach ( $demo_activities as $a ) {
        $existing = get_page_by_path( $a['slug'], OBJECT, 'activity' );

        $a_content = "<!-- wp:paragraph -->\n<p>{$a['desc']} Çalışmalarımızın detaylı saha raporu ve fotoğrafları aşağıda yer almaktadır.</p>\n<!-- /wp:paragraph -->\n";
        $a_content .= dernek_serialize_acf_block( 'acf/peta-gallery', [
            'section_title'  => 'Faaliyet Albümü',
            'gallery_images' => $a['gallery']
        ] );

        $post_data = [
            'post_title'   => $a['title'],
            'post_name'    => $a['slug'],
            'post_content' => $a_content,
            'post_status'  => 'publish',
            'post_type'    => 'activity',
        ];

        if ( ! $existing ) {
            $post_id = wp_insert_post( $post_data );
        } else {
            $post_data['ID'] = $existing->ID;
            $post_id = wp_update_post( $post_data );
        }

        if ( $post_id && ! is_wp_error( $post_id ) ) {
            if ( $a['image_id'] ) {
                set_post_thumbnail( $post_id, $a['image_id'] );
            }
        }
    }

    // 5. Seed Option Settings (Real Media ID References & Default Configurations)
    if ( function_exists( 'update_field' ) ) {
        update_field( 'company_name', '7 Kıta Derneği', 'option' );
        update_field( 'company_short_description', '7 Kıta insani yardım kuruluşu olarak mazlumlara destek oluyoruz.', 'option' );
        update_field( 'footer_description', '7 Kıta Uluslararası İnsani Yardım Derneği, din, dil, ırk gözetmeksizin dünyanın her yerine insani yardım ulaştırmayı hedefler.', 'option' );
        update_field( 'footer_copyright', '© {year} 7 Kıta Derneği. Tüm Hakları Saklıdır.', 'option' );
        update_field( 'contact_phone', '+90 212 777 77 77', 'option' );
        update_field( 'contact_whatsapp', '+90 532 777 77 77', 'option' );
        update_field( 'contact_email', 'bilgi@7kitadernegi.org', 'option' );
        update_field( 'contact_address', 'Merkez Mah. İstiklal Cad. No: 77 Kat: 7, Fatih / İstanbul', 'option' );
        update_field( 'header_cta_title', 'İletişim', 'option' );
        update_field( 'header_cta_url', '/iletisim', 'option' );
        update_field( 'header_donate_cta_title', 'Hemen Bağış Yap', 'option' );
        update_field( 'header_donate_cta_url', '/bagislar/', 'option' );

        // Seed default options site logos
        if ( $logo_id ) {
            update_field( 'site_logo', $logo_id, 'option' );
        }
        if ( $logo_dark_id ) {
            update_field( 'site_logo_dark', $logo_dark_id, 'option' );
            update_field( 'footer_logo', $logo_dark_id, 'option' );
        }
        
        // Seed default fallback page hero images
        if ( $hero1_id ) {
            update_field( 'default_page_hero', $hero1_id, 'option' );
            update_field( 'default_project_hero', $hero1_id, 'option' );
        }
        if ( $hero3_id ) {
            update_field( 'default_activity_hero', $hero3_id, 'option' );
        }
        if ( $hero2_id ) {
            update_field( 'default_404_hero', $hero2_id, 'option' );
        }

        // Seed home slides repeater referencing attachment IDs
        $home_slides_data = [
            [
                'slide_title' => 'Su Kuyuları ile Çorak Topraklara Can Oluyoruz',
                'slide_description' => 'Temiz suya erişimi olmayan yüz binlerce insan için yeni su kuyuları açıyor, sürdürülebilir kalkınmayı destekliyoruz.',
                'slide_cta' => 'Online Bağış Yap',
                'slide_cta_url' => '/bagislar/',
                'slide_desktop_image' => $hero1_id,
            ],
            [
                'slide_title' => 'Geleceği Kalıcı Eğitim Külliyeleriyle İnşa Ediyoruz',
                'slide_description' => 'Afrika ve Asya kırsalında okul ve yetimhane kompleksleri inşa ederek yetim çocuklarımızın eğitimini üstleniyoruz.',
                'slide_cta' => 'Projeleri İncele',
                'slide_cta_url' => '/projeler',
                'slide_desktop_image' => $hero2_id,
            ],
            [
                'slide_title' => 'Afet ve Savaş Bölgelerinde Hızlı Acil İnsani Yardım',
                'slide_description' => 'Kriz anlarında hızlı organize olarak sıcak yemek, çadır, battaniye ve gıda kolilerini ihtiyaç sahiplerine ulaştırıyoruz.',
                'slide_cta' => 'Acil Destek Ol',
                'slide_cta_url' => '/bagislar/',
                'slide_desktop_image' => $hero3_id,
            ]
        ];
        update_field( 'home_slides', $home_slides_data, 'option' );

        // Seed social links repeater
        $social_links_data = [
            [ 'platform' => 'facebook', 'url' => 'https://facebook.com/7kitadernegi' ],
            [ 'platform' => 'instagram', 'url' => 'https://instagram.com/7kitadernegi' ],
            [ 'platform' => 'x', 'url' => 'https://x.com/7kitadernegi' ],
            [ 'platform' => 'youtube', 'url' => 'https://youtube.com/7kitadernegi' ],
            [ 'platform' => 'linkedin', 'url' => 'https://linkedin.com/company/7kitadernegi' ],
        ];
        update_field( 'social_links', $social_links_data, 'option' );

        // Seed featured donations fallback manual card set
        $donations_fallback_cards = [
            [
                'image'       => $project2_url,
                'title'       => 'Yetim Sponsorluğu',
                'description' => 'Bir yetim çocuğumuzun aylık eğitim, sıcak yemek ve giyim masraflarını karşılayın.',
                'url'         => '/bagislar/',
                'price'       => 500,
            ],
            [
                'image'       => $project1_url,
                'title'       => 'Hisseli Su Kuyusu',
                'description' => 'Su sıkıntısı çeken Afrika kırsalında bir hisse bağışı ile su kuyusuna katkıda bulunun.',
                'url'         => '/bagislar/',
                'price'       => 1500,
            ],
            [
                'image'       => $project3_url,
                'title'       => 'Acil Gıda Paketi',
                'description' => 'Savaş ve kriz bölgelerindeki ailelere temel yaşam malzemeleri ulaştırın.',
                'url'         => '/bagislar/',
                'price'       => 750,
            ]
        ];
        update_field( 'featured_donations_fallback', $donations_fallback_cards, 'option' );
    }

    // Set seeded status and flush rewrite rules
    update_option( 'dernek_starter_seeded_v6', 1 );
    flush_rewrite_rules( false );
}

add_action( 'after_switch_theme', 'dernek_seed_starter_kit' );
add_action( 'admin_init', 'dernek_seed_starter_kit' );
