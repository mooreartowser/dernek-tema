<?php
/**
 * Radio Component
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$name     = $args['name'] ?? '';
$id       = $args['id'] ?? '';
$value    = $args['value'] ?? '';
$checked  = ! empty( $args['checked'] ) ? 'checked' : '';
$label    = $args['label'] ?? '';
$required = ! empty( $args['required'] ) ? 'required' : '';
$disabled = ! empty( $args['disabled'] ) ? 'disabled' : '';
$class    = $args['class'] ?? '';

$radio_classes = 'h-4 w-4 border-border text-primary focus:ring-primary bg-surface-alt transition-all duration-200';

if ( $disabled ) {
    $radio_classes .= ' opacity-50 cursor-not-allowed';
} else {
    $radio_classes .= ' cursor-pointer';
}
?>

<div class="flex items-start gap-component-xs <?php echo esc_attr( $class ); ?>">
    <div class="flex h-5 items-center">
        <input 
            type="radio" 
            name="<?php echo esc_attr( $name ); ?>" 
            id="<?php echo esc_attr( $id ); ?>" 
            value="<?php echo esc_attr( $value ); ?>" 
            class="<?php echo esc_attr( $radio_classes ); ?>" 
            <?php echo $checked; ?> 
            <?php echo $required; ?> 
            <?php echo $disabled; ?>
        />
    </div>
    <?php if ( ! empty( $label ) ) : ?>
        <div class="text-sm leading-5">
            <label for="<?php echo esc_attr( $id ); ?>" class="font-medium text-text font-sans <?php echo $disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'; ?>">
                <?php echo esc_html( $label ); ?>
                <?php if ( $required ) : ?>
                    <span class="text-danger">*</span>
                <?php endif; ?>
            </label>
        </div>
    <?php endif; ?>
</div>
