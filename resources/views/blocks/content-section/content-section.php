<?php
/**
 * Content Section Template
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title    = get_field( 'title' ) ?: 'Hizmet Alanlarımız ve Amacımız';
$content  = get_field( 'content' ) ?: '';
$cta_text = get_field( 'cta_text' ) ?: '';
$cta_url  = get_field( 'cta_url' ) ?: '';
$image    = get_field( 'image' ) ?: get_template_directory_uri() . '/assets/demo/demo_orphan.jpg';
?>

<?php
/**
 * Content Section Template
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title    = get_field( 'title' ) ?: 'Hizmet Alanlarımız ve Amacımız';
$content  = get_field( 'content' ) ?: '';
$cta_text = get_field( 'cta_text' ) ?: '';
$cta_url  = get_field( 'cta_url' ) ?: '';
$image    = get_field( 'image' ) ?: get_template_directory_uri() . '/assets/demo/demo_orphan.jpg';

ob_start();
?>

<?php if ( $image ) : ?>
    <?php
    ob_start();
    ?>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-section-sm items-center">
        <!-- Text Area -->
        <div class="lg:col-span-7 flex flex-col gap-component-md">
            <?php if ( ! empty( $title ) ) : ?>
                <h2 class="text-3xl font-bold text-text font-heading leading-tight">
                    <?php echo esc_html( $title ); ?>
                </h2>
            <?php endif; ?>

            <?php if ( ! empty( $content ) ) : ?>
                <div class="prose max-w-none text-base text-text-muted font-sans leading-relaxed">
                    <?php echo wp_kses_post( $content ); ?>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $cta_text ) && ! empty( $cta_url ) ) : ?>
                <div class="mt-component-xs">
                    <?php
                    get_template_part( 'resources/components/button', null, [
                        'variant' => 'primary',
                        'size' => 'medium',
                        'text' => $cta_text,
                        'url' => $cta_url
                    ] );
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Image Area -->
        <div class="lg:col-span-5">
            <div class="aspect-video lg:aspect-square rounded-large overflow-hidden shadow-sm border border-border bg-surface-alt">
                <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="w-full h-full object-cover" />
            </div>
        </div>
    </div>
    <?php
    $container_content = ob_get_clean();
    get_template_part( 'resources/components/container', null, [
        'width'   => 'default',
        'content' => $container_content,
    ] );
    ?>
<?php else : ?>
    <?php
    ob_start();
    ?>
    <?php if ( ! empty( $title ) ) : ?>
        <h2 class="text-3xl font-bold text-text font-heading text-center leading-tight">
            <?php echo esc_html( $title ); ?>
        </h2>
    <?php endif; ?>

    <?php if ( ! empty( $content ) ) : ?>
        <div class="prose max-w-none text-base text-text-muted font-sans leading-relaxed">
            <?php echo wp_kses_post( $content ); ?>
        </div>
    <?php endif; ?>

    <?php if ( ! empty( $cta_text ) && ! empty( $cta_url ) ) : ?>
        <div class="text-center mt-component-xs">
            <?php
            get_template_part( 'resources/components/button', null, [
                'variant' => 'primary',
                'size' => 'medium',
                'text' => $cta_text,
                'url' => $cta_url
            ] );
            ?>
        </div>
    <?php endif; ?>
    <?php
    $container_content = ob_get_clean();
    get_template_part( 'resources/components/container', null, [
        'width'   => 'narrow',
        'class'   => 'flex flex-col gap-component-md',
        'content' => $container_content,
    ] );
    ?>
<?php endif; ?>

<?php
$section_content = ob_get_clean();

get_template_part( 'resources/components/section', null, [
    'spacing'    => 'md',
    'background' => 'default',
    'content'    => $section_content,
] );

