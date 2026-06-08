<?php
/**
 * Card Component
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title     = $args['title'] ?? '';
$subtitle  = $args['subtitle'] ?? '';
$image_url = $args['image_url'] ?? '';
$content   = $args['content'] ?? '';
$footer    = $args['footer'] ?? '';
$url       = $args['url'] ?? '';
$class     = $args['class'] ?? '';

$base_classes = 'flex flex-col overflow-hidden bg-surface border border-border rounded-large shadow-md transition-all duration-200 hover:shadow-lg';

$classes = implode( ' ', array_filter( [
    $base_classes,
    $class
] ) );
?>

<div class="<?php echo esc_attr( $classes ); ?>">
    <?php if ( ! empty( $image_url ) ) : ?>
        <div class="relative w-full aspect-video bg-surface-alt overflow-hidden">
            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="object-cover w-full h-full" />
        </div>
    <?php endif; ?>

    <div class="flex-1 p-component-md flex flex-col gap-component-sm">
        <?php if ( ! empty( $title ) || ! empty( $subtitle ) ) : ?>
            <div class="flex flex-col gap-component-xs">
                <?php if ( ! empty( $subtitle ) ) : ?>
                    <span class="text-xs font-semibold tracking-wide text-primary uppercase font-sans">
                        <?php echo esc_html( $subtitle ); ?>
                    </span>
                <?php endif; ?>

                <?php if ( ! empty( $title ) ) : ?>
                    <?php if ( ! empty( $url ) ) : ?>
                        <a href="<?php echo esc_url( $url ); ?>" class="hover:text-primary transition-colors duration-200">
                            <h3 class="text-xl font-bold text-text font-heading">
                                <?php echo esc_html( $title ); ?>
                            </h3>
                        </a>
                    <?php else : ?>
                        <h3 class="text-xl font-bold text-text font-heading">
                            <?php echo esc_html( $title ); ?>
                        </h3>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ( ! empty( $content ) ) : ?>
            <div class="text-sm text-text-muted font-sans flex-1">
                <?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
        <?php endif; ?>

        <?php if ( ! empty( $footer ) ) : ?>
            <div class="pt-component-sm border-t border-border flex items-center justify-between gap-component-sm">
                <?php echo $footer; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
        <?php endif; ?>
    </div>
</div>
