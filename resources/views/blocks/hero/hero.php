<?php
/**
 * Hero Block Template
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get block values
$eyebrow            = get_field( 'eyebrow' ) ?: 'ACİL YARDIM ÇAĞRISI';
$title              = get_field( 'title' ) ?: 'Savaş Mağduru Ailelere Umut Olun';
$description        = get_field( 'description' ) ?: 'Zorlu kış şartlarında hayatta kalma mücadelesi veren binlerce aileye gıda, barınak ve tıbbi malzeme ulaştırmak için ekiplerimiz sahada.';
$cta_text           = get_field( 'cta_text' ) ?: 'Hemen Bağış Yap';
$cta_url            = get_field( 'cta_url' ) ?: '#';
$secondary_cta_text = get_field( 'secondary_cta_text' ) ?: '';
$secondary_cta_url  = get_field( 'secondary_cta_url' ) ?: '';
$bg_image           = get_field( 'bg_image' ) ?: get_template_directory_uri() . '/assets/demo/demo_relief.jpg';
$mobile_image       = get_field( 'mobile_image' ) ?: $bg_image;
$overlay_toggle     = get_field( 'overlay_toggle' );

$has_overlay = ( 1 === (int) $overlay_toggle || true === $overlay_toggle );
?>

<div class="relative w-full min-h-[500px] md:min-h-[600px] flex items-center bg-surface-alt overflow-hidden">
    <!-- Background Images -->
    <picture class="absolute inset-0 w-full h-full object-cover">
        <source media="(max-w: 767px)" srcset="<?php echo esc_url( $mobile_image ); ?>">
        <img src="<?php echo esc_url( $bg_image ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="absolute inset-0 w-full h-full object-cover" />
    </picture>

    <!-- Dark Overlay -->
    <?php if ( $has_overlay ) : ?>
        <div class="absolute inset-0 bg-black/50 transition-all duration-200"></div>
    <?php endif; ?>

    <!-- Content Wrapper using Container Component structure -->
    <div class="relative w-full z-10 py-section-md">
        <?php
        ob_start();
        ?>
        <div class="max-w-xl flex flex-col gap-component-md text-white">
            <?php if ( ! empty( $eyebrow ) ) : ?>
                <div>
                    <?php
                    get_template_part( 'resources/components/badge', null, [
                        'class' => 'bg-accent text-white uppercase border-0',
                        'text'  => $eyebrow,
                    ] );
                    ?>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $title ) ) : ?>
                <h1 class="text-4xl md:text-5xl font-extrabold font-heading tracking-tight leading-tight">
                    <?php echo esc_html( $title ); ?>
                </h1>
            <?php endif; ?>

            <?php if ( ! empty( $description ) ) : ?>
                <p class="text-base md:text-lg text-white/90 font-sans leading-relaxed">
                    <?php echo esc_html( $description ); ?>
                </p>
            <?php endif; ?>

            <div class="flex flex-wrap gap-component-sm mt-component-xs">
                <?php
                if ( ! empty( $cta_text ) && ! empty( $cta_url ) ) {
                    get_template_part( 'resources/components/button', null, [
                        'variant' => 'primary',
                        'size' => 'large',
                        'text' => $cta_text,
                        'url' => $cta_url,
                        'class' => 'bg-accent hover:opacity-90 border-0' // Using accent theme color override
                    ] );
                }

                if ( ! empty( $secondary_cta_text ) && ! empty( $secondary_cta_url ) ) {
                    get_template_part( 'resources/components/button', null, [
                        'variant' => 'outline',
                        'size' => 'large',
                        'text' => $secondary_cta_text,
                        'url' => $secondary_cta_url,
                        'class' => 'text-white border-white hover:bg-white/10 hover:text-white'
                    ] );
                }
                ?>
            </div>
        </div>
        <?php
        $container_content = ob_get_clean();
        get_template_part( 'resources/components/container', null, [
            'content' => $container_content,
        ] );
        ?>
    </div>
</div>
