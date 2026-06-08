<?php
/**
 * Button Component
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$variant    = $args['variant'] ?? 'primary';
$size       = $args['size'] ?? 'medium';
$text       = $args['text'] ?? 'Button';
$url        = $args['url'] ?? '';
$type       = $args['type'] ?? 'button';
$class      = $args['class'] ?? '';
$attributes = $args['attributes'] ?? '';
$disabled   = ! empty( $args['disabled'] ) ? 'disabled' : '';

$escape     = $args['escape'] ?? true;

$size_classes = [
    'small'  => 'btn-sm',
    'medium' => 'btn-md',
    'large'  => 'btn-lg',
];

if ( 'text' === $variant ) {
    $size_classes = [
        'small'  => 'text-xs',
        'medium' => 'text-base',
        'large'  => 'text-lg',
    ];
}

$classes = implode( ' ', array_filter( [
    'btn',
    'btn-' . $variant,
    $size_classes[$size] ?? $size_classes['medium'],
    $disabled ? 'opacity-50 cursor-not-allowed' : '',
    $class
] ) );
?>

<?php if ( ! empty( $url ) ) : ?>
    <a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( $classes ); ?>" <?php echo $attributes; ?>>
        <?php echo $escape ? esc_html( $text ) : $text; ?>
    </a>
<?php else : ?>
    <button type="<?php echo esc_attr( $type ); ?>" class="<?php echo esc_attr( $classes ); ?>" <?php echo $disabled; ?> <?php echo $attributes; ?>>
        <?php echo $escape ? esc_html( $text ) : $text; ?>
    </button>
<?php endif; ?>
