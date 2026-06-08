<?php
/**
 * Centralized Quantity Selector Component
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$name         = $args['name'] ?? 'quantity';
$val          = $args['value'] ?? 1;
$min          = $args['min'] ?? 1;
$step         = $args['step'] ?? 1;
$id           = $args['id'] ?? 'qty_' . uniqid();
$class        = $args['class'] ?? '';
$button_class = $args['button_class'] ?? '';
$line_key     = $args['line_key'] ?? '';
$is_ajax      = ! empty( $line_key );
$classes = implode( ' ', array_filter( [
    'qty-selector',
    $class
] ) );

$btn_classes = implode( ' ', array_filter( [
    'qty-selector-btn',
    $button_class
] ) );
?>

<div class="<?php echo esc_attr( $classes ); ?>" data-quantity-selector>
    <button type="button" 
            class="<?php echo esc_attr( $btn_classes ); ?>" 
            data-action="decrease"
            <?php if ( $is_ajax ) : ?>
                data-line-key="<?php echo esc_attr( $line_key ); ?>" 
            <?php endif; ?>>
        <i class="ri-minus-line text-xs"></i>
    </button>
    
    <?php if ( $is_ajax ) : ?>
        <span class="qty-selector-text" id="qty-text-<?php echo esc_attr( $line_key ); ?>">
            <?php echo esc_html( $val ); ?>
        </span>
    <?php else : ?>
        <input type="number" 
               name="<?php echo esc_attr( $name ); ?>" 
               id="<?php echo esc_attr( $id ); ?>" 
               value="<?php echo esc_attr( $val ); ?>" 
               min="<?php echo esc_attr( $min ); ?>" 
               step="<?php echo esc_attr( $step ); ?>" 
               readonly 
               class="qty-selector-input" />
    <?php endif; ?>
    
    <button type="button" 
            class="<?php echo esc_attr( $btn_classes ); ?>" 
            data-action="increase"
            <?php if ( $is_ajax ) : ?>
                data-line-key="<?php echo esc_attr( $line_key ); ?>" 
            <?php endif; ?>>
        <i class="ri-add-line text-xs"></i>
    </button>
</div>
