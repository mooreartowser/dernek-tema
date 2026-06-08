<?php
/**
 * Featured Donations Template
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title       = get_field( 'title' ) ?: 'Hızlı Bağış Kategorileri';
$description = get_field( 'description' ) ?: 'İyilik yapmak istediğiniz alanı seçerek bağışınızı hemen ulaştırabilirsiniz.';
$source_type = get_field( 'source_type' ) ?: 'manual';
$crm_cats    = get_field( 'crm_categories' ) ?: [];

$cards = DonationProvider::getItems( $source_type, [
    'cards'          => get_field( 'cards' ) ?: [],
    'crm_categories' => $crm_cats,
] );
?>

<?php
/**
 * Featured Donations Template
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title       = get_field( 'title' ) ?: 'Hızlı Bağış Kategorileri';
$description = get_field( 'description' ) ?: 'İyilik yapmak istediğiniz alanı seçerek bağışınızı hemen ulaştırabilirsiniz.';
$source_type = get_field( 'source_type' ) ?: 'manual';
$crm_cats    = get_field( 'crm_categories' ) ?: [];

$cards = DonationProvider::getItems( $source_type, [
    'cards'          => get_field( 'cards' ) ?: [],
    'crm_categories' => $crm_cats,
] );

ob_start();
?>

<!-- Header -->
<div class="flex flex-col gap-component-xs md:text-center max-w-2xl md:mx-auto">
    <?php if ( ! empty( $title ) ) : ?>
        <h2 class="text-3xl font-bold text-text font-heading">
            <?php echo esc_html( $title ); ?>
        </h2>
    <?php endif; ?>

    <?php if ( ! empty( $description ) ) : ?>
        <p class="text-base text-text-muted font-sans leading-relaxed">
            <?php echo esc_html( $description ); ?>
        </p>
    <?php endif; ?>
</div>

<!-- Cards Grid -->
<?php if ( ! empty( $cards ) ) : ?>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-component-lg">
        <?php foreach ( $cards as $card ) : 
            get_template_part( 'resources/components/crm/donation-card', null, [
                'title'          => $card['title'],
                'description'    => $card['description'],
                'image_url'      => $card['image'] ?? $card['image_url'] ?? '',
                'badge_text'     => ! empty( $card['is_intent'] ) ? __( 'İsim Beyanlı', 'dernek-tema' ) : __( 'Bağış Kampanyası', 'dernek-tema' ),
                'price'          => $card['price'] ?? null,
                'donation_url'   => $card['url'] ?? $card['donation_url'] ?? '#',
                'product_code'   => $card['code'] ?? '',
                'is_variable'    => empty( $card['price'] ) || $card['price'] <= 0,
            ] );
        endforeach; ?>
    </div>
<?php endif; ?>

<?php
$container_content = ob_get_clean();

ob_start();
get_template_part( 'resources/components/container', null, [
    'class'   => 'flex flex-col gap-component-lg',
    'content' => $container_content,
] );
$section_content = ob_get_clean();

get_template_part( 'resources/components/section', null, [
    'spacing'    => 'md',
    'background' => 'alt',
    'content'    => $section_content,
] );

