<?php
/**
 * Badge Component
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$variant = $args['variant'] ?? 'primary';
$text    = $args['text'] ?? '';
$class   = $args['class'] ?? '';

$base_classes = 'inline-flex items-center px-component-xs py-0.5 text-xs font-semibold rounded-pill font-sans';

$variant_classes = [
    'primary'   => 'bg-primary/10 text-primary',
    'secondary' => 'bg-secondary/10 text-secondary',
    'success'   => 'bg-success/10 text-success',
    'warning'   => 'bg-warning/10 text-warning',
    'danger'    => 'bg-danger/10 text-danger',
    'neutral'   => 'bg-surface-alt text-text-muted border border-border',
];

$classes = implode( ' ', array_filter( [
    $base_classes,
    $variant_classes[$variant] ?? $variant_classes['primary'],
    $class
] ) );
?>

<span class="<?php echo esc_attr( $classes ); ?>">
    <?php echo esc_html( $text ); ?>
</span>
