<?php
/**
 * Container Component
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$width   = $args['width'] ?? 'default';
$class   = $args['class'] ?? '';
$content = $args['content'] ?? '';

$base_classes = 'w-full mx-auto px-container-px';

$width_classes = [
    'narrow'  => 'max-w-container-narrow',
    'default' => 'max-w-container-default',
    'wide'    => 'max-w-container-wide',
    'full'    => 'max-w-container-full',
];

$classes = implode( ' ', array_filter( [
    $base_classes,
    $width_classes[$width] ?? $width_classes['default'],
    $class
] ) );
?>

<div class="<?php echo esc_attr( $classes ); ?>">
    <?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>
