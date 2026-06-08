<?php
/**
 * Template Name: Elements Showcase (Style Guide)
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Style Guide & Core Component Library Showcase</title>
    <?php wp_head(); ?>
</head>
<body class="bg-background text-text font-sans antialiased min-h-screen">

<div class="border-b border-border bg-surface py-component-lg mb-section-sm">
    <div class="max-w-container-default mx-auto px-container-px flex flex-col gap-component-xs">
        <span class="text-xs font-semibold text-primary uppercase tracking-wide">Dernek Framework</span>
        <h1 class="text-4xl font-extrabold font-heading tracking-tight">Core Component Library v1</h1>
        <p class="text-sm text-text-muted">Arayüz geliştirmede kullanılan tüm temel UI bileşenlerinin, renklerin ve tipografi standartlarının canlı önizleme ve test rehberi.</p>
    </div>
</div>

<main class="max-w-container-default mx-auto px-container-px pb-section-lg flex flex-col gap-section-md">

    <!-- 1. TYPOGRAPHY SHOWCASE -->
    <section class="flex flex-col gap-component-lg">
        <div class="border-b border-border pb-component-xs">
            <h2 class="text-2xl font-bold font-heading">1. Tipografi & Font Ölçeği (Typography)</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-component-lg">
            <!-- Font families -->
            <div class="flex flex-col gap-component-sm bg-surface p-component-md border border-border rounded-medium shadow-sm">
                <h3 class="text-lg font-bold font-heading border-b border-border pb-component-xs">Yazı Tipleri (Font Families)</h3>
                <div>
                    <span class="text-xs text-text-muted">Sans Font (--font-sans): Inter</span>
                    <p class="font-sans text-lg mt-component-xs">İyilik ve sevgi her kalbe ulaşana dek yorulmadan çalışmaya devam ediyoruz. (Body & Paragraph)</p>
                </div>
                <div class="mt-component-sm">
                    <span class="text-xs text-text-muted">Heading Font (--font-heading): Outfit</span>
                    <p class="font-heading text-2xl font-bold mt-component-xs">Geleceği Birlikte İnşa Ediyoruz (Headings & Titles)</p>
                </div>
            </div>
            <!-- Font sizes -->
            <div class="flex flex-col gap-component-sm bg-surface p-component-md border border-border rounded-medium shadow-sm">
                <h3 class="text-lg font-bold font-heading border-b border-border pb-component-xs">Yazı Boyutları (Font Sizes)</h3>
                <div class="flex flex-col gap-component-sm">
                    <div class="flex items-center justify-between"><span class="text-5xl font-bold font-heading">text-5xl</span><span class="text-xs text-text-muted">48px</span></div>
                    <div class="flex items-center justify-between"><span class="text-4xl font-bold font-heading">text-4xl</span><span class="text-xs text-text-muted">36px</span></div>
                    <div class="flex items-center justify-between"><span class="text-3xl font-bold font-heading">text-3xl</span><span class="text-xs text-text-muted">30px</span></div>
                    <div class="flex items-center justify-between"><span class="text-2xl font-bold font-heading">text-2xl</span><span class="text-xs text-text-muted">24px</span></div>
                    <div class="flex items-center justify-between"><span class="text-xl font-medium">text-xl</span><span class="text-xs text-text-muted">20px</span></div>
                    <div class="flex items-center justify-between"><span class="text-lg">text-lg</span><span class="text-xs text-text-muted">18px</span></div>
                    <div class="flex items-center justify-between"><span class="text-base">text-base (Default)</span><span class="text-xs text-text-muted">16px</span></div>
                    <div class="flex items-center justify-between"><span class="text-sm">text-sm</span><span class="text-xs text-text-muted">14px</span></div>
                    <div class="flex items-center justify-between"><span class="text-xs">text-xs</span><span class="text-xs text-text-muted">12px</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. BUTTONS SHOWCASE -->
    <section class="flex flex-col gap-component-lg">
        <div class="border-b border-border pb-component-xs">
            <h2 class="text-2xl font-bold font-heading">2. Butonlar (Buttons)</h2>
        </div>
        <div class="bg-surface p-component-md border border-border rounded-medium shadow-sm flex flex-col gap-component-md">
            <!-- Variants -->
            <div>
                <h3 class="text-sm font-semibold text-text-muted mb-component-sm">Buton Varyasyonları (Variants)</h3>
                <div class="flex flex-wrap gap-component-sm items-center">
                    <?php
                    get_template_part( 'resources/components/button', null, [ 'variant' => 'primary', 'text' => 'Primary Button' ] );
                    get_template_part( 'resources/components/button', null, [ 'variant' => 'secondary', 'text' => 'Secondary Button' ] );
                    get_template_part( 'resources/components/button', null, [ 'variant' => 'outline', 'text' => 'Outline Button' ] );
                    get_template_part( 'resources/components/button', null, [ 'variant' => 'danger', 'text' => 'Danger Button' ] );
                    get_template_part( 'resources/components/button', null, [ 'variant' => 'text', 'text' => 'Text Link Button' ] );
                    ?>
                </div>
            </div>
            <!-- Sizes -->
            <div class="border-t border-border pt-component-md">
                <h3 class="text-sm font-semibold text-text-muted mb-component-sm">Buton Boyutları (Sizes)</h3>
                <div class="flex flex-wrap gap-component-sm items-center">
                    <?php
                    get_template_part( 'resources/components/button', null, [ 'variant' => 'primary', 'size' => 'small', 'text' => 'Small Button' ] );
                    get_template_part( 'resources/components/button', null, [ 'variant' => 'primary', 'size' => 'medium', 'text' => 'Medium Button' ] );
                    get_template_part( 'resources/components/button', null, [ 'variant' => 'primary', 'size' => 'large', 'text' => 'Large Button' ] );
                    ?>
                </div>
            </div>
            <!-- Interactive States -->
            <div class="border-t border-border pt-component-md">
                <h3 class="text-sm font-semibold text-text-muted mb-component-sm">Buton Durumları (States)</h3>
                <div class="flex flex-wrap gap-component-sm items-center">
                    <?php
                    get_template_part( 'resources/components/button', null, [ 'variant' => 'primary', 'text' => 'Disabled Button', 'disabled' => true ] );
                    get_template_part( 'resources/components/button', null, [ 'variant' => 'outline', 'text' => 'Disabled Outline', 'disabled' => true ] );
                    get_template_part( 'resources/components/button', null, [ 'variant' => 'primary', 'text' => 'Link As Button (Anchor)', 'url' => '#' ] );
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. FORM ELEMENTS -->
    <section class="flex flex-col gap-component-lg">
        <div class="border-b border-border pb-component-xs">
            <h2 class="text-2xl font-bold font-heading">3. Form Elemanları (Form Elements)</h2>
        </div>
        <div class="bg-surface p-component-md border border-border rounded-medium shadow-sm grid grid-cols-1 md:grid-cols-2 gap-component-lg">
            <!-- Text Inputs -->
            <div class="flex flex-col gap-component-md">
                <h3 class="text-lg font-bold font-heading border-b border-border pb-component-xs">Giriş Alanları</h3>
                <?php
                get_template_part( 'resources/components/input', null, [
                    'name' => 'fullname',
                    'label' => 'Adınız Soyadınız',
                    'placeholder' => 'Örn: Ahmet Yılmaz',
                    'required' => true
                ] );

                get_template_part( 'resources/components/input', null, [
                    'name' => 'email',
                    'type' => 'email',
                    'label' => 'E-posta Adresi',
                    'placeholder' => 'ahmet@example.com',
                    'error' => 'Geçerli bir e-posta adresi giriniz.'
                ] );

                get_template_part( 'resources/components/input', null, [
                    'name' => 'phone_disabled',
                    'label' => 'Telefon Numarası (Pasif)',
                    'value' => '+90 (555) 111 22 33',
                    'disabled' => true
                ] );
                ?>
            </div>

            <!-- Textarea, Select, Radios, Checkbox -->
            <div class="flex flex-col gap-component-md">
                <h3 class="text-lg font-bold font-heading border-b border-border pb-component-xs">Seçim & Alanlar</h3>
                <?php
                get_template_part( 'resources/components/select', null, [
                    'name' => 'donation_category',
                    'label' => 'Bağış Kategorisi',
                    'options' => [
                        'genel' => 'Genel Bağış',
                        'yetim' => 'Yetim Sponsorluğu',
                        'kuyu' => 'Su Kuyusu',
                        'gida' => 'Gıda Yardımı'
                    ],
                    'selected' => 'yetim'
                ] );

                get_template_part( 'resources/components/textarea', null, [
                    'name' => 'message',
                    'label' => 'Mesajınız',
                    'placeholder' => 'Bizlere iletmek istediğiniz notu yazınız...',
                    'rows' => 3
                ] );
                ?>
                <!-- Checkboxes & Radios group -->
                <div class="flex flex-col gap-component-xs mt-component-xs">
                    <span class="text-sm font-medium text-text font-sans">Seçenekler</span>
                    <div class="flex flex-col gap-component-xs">
                        <?php
                        get_template_part( 'resources/components/checkbox', null, [
                            'name' => 'kvkk',
                            'label' => 'KVKK Açık Rıza Metnini okudum ve onaylıyorum.',
                            'required' => true
                        ] );

                        get_template_part( 'resources/components/checkbox', null, [
                            'name' => 'bulten',
                            'label' => 'E-posta ve SMS bültenlerine abone olmak istiyorum.',
                            'checked' => true
                        ] );
                        ?>
                    </div>
                </div>

                <div class="flex flex-col gap-component-xs mt-component-xs">
                    <span class="text-sm font-medium text-text font-sans">Ödeme Yöntemi</span>
                    <div class="flex gap-component-md">
                        <?php
                        get_template_part( 'resources/components/radio', null, [
                            'name' => 'payment_method',
                            'id' => 'cc',
                            'value' => 'credit_card',
                            'label' => 'Kredi Kartı',
                            'checked' => true
                        ] );

                        get_template_part( 'resources/components/radio', null, [
                            'name' => 'payment_method',
                            'id' => 'eft',
                            'value' => 'eft',
                            'label' => 'EFT / Havale'
                        ] );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. BADGES SHOWCASE -->
    <section class="flex flex-col gap-component-lg">
        <div class="border-b border-border pb-component-xs">
            <h2 class="text-2xl font-bold font-heading">4. Durum Rozetleri (Badges)</h2>
        </div>
        <div class="bg-surface p-component-md border border-border rounded-medium shadow-sm flex flex-col gap-component-sm">
            <h3 class="text-sm font-semibold text-text-muted mb-component-xs">Rozet Varyasyonları</h3>
            <div class="flex flex-wrap gap-component-sm">
                <?php
                get_template_part( 'resources/components/badge', null, [ 'variant' => 'primary', 'text' => 'Primary Badge' ] );
                get_template_part( 'resources/components/badge', null, [ 'variant' => 'secondary', 'text' => 'Secondary' ] );
                get_template_part( 'resources/components/badge', null, [ 'variant' => 'success', 'text' => 'Success' ] );
                get_template_part( 'resources/components/badge', null, [ 'variant' => 'warning', 'text' => 'Warning' ] );
                get_template_part( 'resources/components/badge', null, [ 'variant' => 'danger', 'text' => 'Danger' ] );
                get_template_part( 'resources/components/badge', null, [ 'variant' => 'neutral', 'text' => 'Neutral/Bordered' ] );
                ?>
            </div>
        </div>
    </section>

    <!-- 5. CONTAINER, SECTION & CARD DEMO -->
    <section class="flex flex-col gap-component-lg">
        <div class="border-b border-border pb-component-xs">
            <h2 class="text-2xl font-bold font-heading">5. Bölümler, Kapsayıcılar & Kart Yapısı (Section, Container & Cards)</h2>
        </div>
        
        <!-- Render a Container Component with Cards inside -->
        <?php
        // Prepare card 1
        ob_start();
        get_template_part( 'resources/components/badge', null, [ 'variant' => 'secondary', 'text' => 'Aktif Proje' ] );
        $badge1 = ob_get_clean();
        
        ob_start();
        get_template_part( 'resources/components/button', null, [ 'variant' => 'primary', 'size' => 'small', 'text' => 'Bağış Yap' ] );
        $footer1 = ob_get_clean();

        // Prepare card 2
        ob_start();
        get_template_part( 'resources/components/badge', null, [ 'variant' => 'success', 'text' => 'Tamamlandı' ] );
        $badge2 = ob_get_clean();

        ob_start();
        get_template_part( 'resources/components/button', null, [ 'variant' => 'outline', 'size' => 'small', 'text' => 'Detayları İncele' ] );
        $footer2 = ob_get_clean();

        // Prepare Card Grid HTML
        $cards_html = '
        <div class="grid grid-cols-1 md:grid-cols-2 gap-component-lg">
        ';
        
        // Add card 1 content
        ob_start();
        get_template_part( 'resources/components/card', null, [
            'title' => 'Afrika Temiz Su Kuyusu Projesi',
            'subtitle' => 'Su Kuyuları',
            'image_url' => get_template_directory_uri() . '/assets/demo/demo_waterwell.jpg',
            'content' => '<p>Temiz suya erişimi olmayan kardeşlerimiz için sürdürülebilir su kuyuları açıyor, binlerce insanın hayatına dokunuyoruz. Hissedar olarak destek olabilirsiniz.</p>',
            'footer' => $badge1 . $footer1
        ] );
        $cards_html .= ob_get_clean();

        // Add card 2 content
        ob_start();
        get_template_part( 'resources/components/card', null, [
            'title' => 'Ramazan Kumanyası Dağıtımları',
            'subtitle' => 'Acil Gıda',
            'image_url' => get_template_directory_uri() . '/assets/demo/demo_education.jpg',
            'content' => '<p>Mübarek Ramazan ayında ihtiyaç sahibi ailelerin sofralarına bereket taşıyoruz. Dağıtımlarımız tamamlanmış olup raporlar üye paneline yüklenmiştir.</p>',
            'footer' => $badge2 . $footer2
        ] );
        $cards_html .= ob_get_clean();

        $cards_html .= '</div>';

        // Render Section & Container wrapping Cards
        ob_start();
        get_template_part( 'resources/components/container', null, [
            'width' => 'default',
            'content' => $cards_html
        ] );
        $container_html = ob_get_clean();

        get_template_part( 'resources/components/section', null, [
            'background' => 'alt',
            'spacing' => 'sm',
            'class' => 'rounded-large border border-border p-component-md',
            'content' => $container_html
        ] );
        ?>
    </section>

    <!-- 6. DERNEKUI BLOCKS SHOWCASE -->
    <section class="flex flex-col gap-component-lg">
        <div class="border-b border-border pb-component-xs">
            <h2 class="text-2xl font-bold font-heading">6. DernekUI Blocks v1 (Gutenberg Blocks Showcase)</h2>
        </div>
        
        <div class="flex flex-col gap-section-md">
            <!-- Hero Block -->
            <div class="border border-border rounded-large overflow-hidden">
                <span class="block bg-surface p-component-sm text-xs font-semibold text-text-muted border-b border-border">Block 1: Hero</span>
                <?php get_template_part( 'resources/views/blocks/hero/hero' ); ?>
            </div>

            <!-- Rich Image Content Block -->
            <div class="border border-border rounded-large overflow-hidden">
                <span class="block bg-surface p-component-sm text-xs font-semibold text-text-muted border-b border-border">Block 2: Rich Image Content</span>
                <?php get_template_part( 'resources/views/blocks/rich-image-content/rich-image-content' ); ?>
            </div>

            <!-- CTA Section Block -->
            <div class="border border-border rounded-large overflow-hidden">
                <span class="block bg-surface p-component-sm text-xs font-semibold text-text-muted border-b border-border">Block 3: CTA Section</span>
                <?php get_template_part( 'resources/views/blocks/cta-section/cta-section' ); ?>
            </div>

            <!-- Stats Grid Block -->
            <div class="border border-border rounded-large overflow-hidden">
                <span class="block bg-surface p-component-sm text-xs font-semibold text-text-muted border-b border-border">Block 4: Stats Grid</span>
                <?php get_template_part( 'resources/views/blocks/stats-grid/stats-grid' ); ?>
            </div>

            <!-- FAQ Block -->
            <div class="border border-border rounded-large overflow-hidden">
                <span class="block bg-surface p-component-sm text-xs font-semibold text-text-muted border-b border-border">Block 5: FAQ</span>
                <?php get_template_part( 'resources/views/blocks/faq/faq' ); ?>
            </div>

            <!-- Timeline Block -->
            <div class="border border-border rounded-large overflow-hidden">
                <span class="block bg-surface p-component-sm text-xs font-semibold text-text-muted border-b border-border">Block 6: Timeline</span>
                <?php get_template_part( 'resources/views/blocks/timeline/timeline' ); ?>
            </div>

            <!-- Gallery Block -->
            <div class="border border-border rounded-large overflow-hidden">
                <span class="block bg-surface p-component-sm text-xs font-semibold text-text-muted border-b border-border">Block 7: Gallery</span>
                <?php get_template_part( 'resources/views/blocks/gallery/gallery' ); ?>
            </div>

            <!-- Content Section Block -->
            <div class="border border-border rounded-large overflow-hidden">
                <span class="block bg-surface p-component-sm text-xs font-semibold text-text-muted border-b border-border">Block 8: Content Section</span>
                <?php get_template_part( 'resources/views/blocks/content-section/content-section' ); ?>
            </div>

            <!-- Featured Projects Block -->
            <div class="border border-border rounded-large overflow-hidden">
                <span class="block bg-surface p-component-sm text-xs font-semibold text-text-muted border-b border-border">Block 9: Featured Projects</span>
                <?php get_template_part( 'resources/views/blocks/featured-projects/featured-projects' ); ?>
            </div>

            <!-- Featured Donations Block -->
            <div class="border border-border rounded-large overflow-hidden">
                <span class="block bg-surface p-component-sm text-xs font-semibold text-text-muted border-b border-border">Block 10: Featured Donations</span>
                <?php get_template_part( 'resources/views/blocks/featured-donations/featured-donations' ); ?>
            </div>

            <!-- Donation Process Block -->
            <div class="border border-border rounded-large overflow-hidden">
                <span class="block bg-surface p-component-sm text-xs font-semibold text-text-muted border-b border-border">Block 11: Donation Process</span>
                <?php get_template_part( 'resources/views/blocks/donation-process/donation-process' ); ?>
            </div>
        </div>
    </section>

</main>

<footer class="border-t border-border bg-surface-alt py-component-lg text-center text-xs text-text-muted">
    <div class="max-w-container-default mx-auto px-container-px">
        © 2026 Dernek Framework. Design Token System v1 Standartlarına Göre Derlenmiştir.
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
