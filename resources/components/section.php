<?php
/**
 * Section Component
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$id         = $args['id'] ?? '';
$class      = $args['class'] ?? '';
$spacing    = $args['spacing'] ?? 'md'; // sm, md, lg, none
$background = $args['background'] ?? 'default'; // default, white, alt
$content    = $args['content'] ?? '';

$base_classes = 'w-full';

$spacing_classes = [
    'sm'   => 'py-section-sm',
    'md'   => 'py-section-md',
    'lg'   => 'py-section-lg',
    'none' => '',
];

$bg_classes = [
    'default' => 'bg-background',
    'white'   => 'bg-surface',
    'alt'     => 'bg-surface-alt',
];

$classes = implode( ' ', array_filter( [
    $base_classes,
    $spacing_classes[$spacing] ?? $spacing_classes['md'],
    $bg_classes[$background] ?? $bg_classes['default'],
    $class
] ) );

$id_attr = ! empty( $id ) ? 'id="' . esc_attr( $id ) . '"' : '';
?>

<section <?php echo $id_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="<?php echo esc_attr( $classes ); ?>">
    <?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</section>
