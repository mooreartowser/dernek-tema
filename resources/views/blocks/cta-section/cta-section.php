<?php
/**
 * CTA Section Template
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title        = get_field( 'title' ) ?: 'Bir Yetimin Hayatını Değiştirmek Sizin Elinizde';
$description  = get_field( 'description' ) ?: 'Dünya genelinde milyonlarca yetim çocuk sıcak bir yuva bekliyor.';
$cta_text     = get_field( 'cta_text' ) ?: 'Yetim Sponsoru Ol';
$cta_url      = get_field( 'cta_url' ) ?: '#';
$bg_image     = get_field( 'bg_image' ) ?: get_template_directory_uri() . '/assets/demo/demo_relief.jpg';
$impact_cards = get_field( 'impact_cards' ) ?: [];
?>

<?php
/**
 * CTA Section Template
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title        = get_field( 'title' ) ?: 'Bir Yetimin Hayatını Değiştirmek Sizin Elinizde';
$description  = get_field( 'description' ) ?: 'Dünya genelinde milyonlarca yetim çocuk sıcak bir yuva bekliyor.';
$cta_text     = get_field( 'cta_text' ) ?: 'Yetim Sponsoru Ol';
$cta_url      = get_field( 'cta_url' ) ?: '#';
$bg_image     = get_field( 'bg_image' ) ?: get_template_directory_uri() . '/assets/demo/demo_relief.jpg';
$impact_cards = get_field( 'impact_cards' ) ?: [];

ob_start();
?>

<!-- Background Image -->
<?php if ( $bg_image ) : ?>
    <img src="<?php echo esc_url( $bg_image ); ?>" alt="" class="absolute inset-0 w-full h-full object-cover" />
    <div class="absolute inset-0 bg-primary-900/90 transition-all duration-200"></div>
<?php endif; ?>

<?php
$bg_content = ob_get_clean();

ob_start();
?>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-section-sm items-center">
    
    <!-- Left Info Area -->
    <div class="lg:col-span-7 flex flex-col gap-component-md">
        <?php if ( ! empty( $title ) ) : ?>
            <h2 class="text-3xl md:text-4xl font-extrabold font-heading tracking-tight leading-tight">
                <?php echo esc_html( $title ); ?>
            </h2>
        <?php endif; ?>

        <?php if ( ! empty( $description ) ) : ?>
            <p class="text-base md:text-lg text-white/80 font-sans leading-relaxed">
                <?php echo esc_html( $description ); ?>
            </p>
        <?php endif; ?>

        <div class="mt-component-xs">
            <?php
            if ( ! empty( $cta_text ) && ! empty( $cta_url ) ) {
                get_template_part( 'resources/components/button', null, [
                    'variant' => 'primary',
                    'size' => 'large',
                    'text' => $cta_text,
                    'url' => $cta_url,
                    'class' => 'bg-accent hover:opacity-90 border-0'
                ] );
            }
            ?>
        </div>
    </div>

    <!-- Right Impact Cards Area -->
    <div class="lg:col-span-5 flex flex-col gap-component-sm">
        <?php if ( ! empty( $impact_cards ) ) : ?>
            <?php foreach ( $impact_cards as $card ) : 
                ob_start();
                ?>
                <span class="text-2xl font-bold font-heading text-accent leading-none">
                    <?php echo esc_html( $card['title'] ); ?>
                </span>
                <p class="text-sm text-white/90 font-sans leading-relaxed">
                    <?php echo esc_html( $card['description'] ); ?>
                </p>
                <?php
                $card_content = ob_get_clean();
                get_template_part( 'resources/components/card', null, [
                    'class'   => 'p-component-md bg-white/10 backdrop-blur-md rounded-large border border-white/15 flex flex-col gap-component-xs shadow-sm bg-none hover:shadow-md text-white',
                    'content' => $card_content,
                ] );
                ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>
<?php
$container_content = ob_get_clean();

ob_start();
get_template_part( 'resources/components/container', null, [
    'content' => $container_content,
] );
$section_content = $bg_content . ob_get_clean();

get_template_part( 'resources/components/section', null, [
    'spacing'    => 'lg',
    'class'      => 'relative overflow-hidden bg-primary-900 text-white',
    'content'    => $section_content,
] );

