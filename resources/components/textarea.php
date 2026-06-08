<?php
/**
 * Textarea Component
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$name        = $args['name'] ?? '';
$id          = $args['id'] ?? $name;
$value       = $args['value'] ?? '';
$placeholder = $args['placeholder'] ?? '';
$label       = $args['label'] ?? '';
$rows        = $args['rows'] ?? 4;
$required    = ! empty( $args['required'] ) ? 'required' : '';
$disabled    = ! empty( $args['disabled'] ) ? 'disabled' : '';
$error       = $args['error'] ?? '';
$class       = $args['class'] ?? '';
$input_class = $args['input_class'] ?? '';
$attributes  = $args['attributes'] ?? '';

$input_classes = 'w-full px-component-sm py-component-sm border rounded-medium text-text bg-surface-alt font-sans placeholder-text-muted transition-all duration-200 focus:outline-none focus:bg-surface focus:ring-2 focus:ring-primary focus:border-transparent resize-y ' . $input_class;

if ( $error ) {
    $input_classes .= ' border-danger focus:ring-danger';
} else {
    $input_classes .= ' border-border';
}

if ( $disabled ) {
    $input_classes .= ' opacity-50 cursor-not-allowed bg-surface-alt';
}
?>

<div class="w-full flex flex-col gap-component-xs <?php echo esc_attr( $class ); ?>">
    <?php if ( ! empty( $label ) ) : ?>
        <label for="<?php echo esc_attr( $id ); ?>" class="text-sm font-medium text-text font-sans">
            <?php echo esc_html( $label ); ?>
            <?php if ( $required ) : ?>
                <span class="text-danger">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>

    <textarea 
        name="<?php echo esc_attr( $name ); ?>" 
        id="<?php echo esc_attr( $id ); ?>" 
        rows="<?php echo esc_attr( $rows ); ?>" 
        placeholder="<?php echo esc_attr( $placeholder ); ?>" 
        class="<?php echo esc_attr( $input_classes ); ?>" 
        <?php echo $required; ?> 
        <?php echo $disabled; ?>
        <?php echo $attributes; ?>
    ><?php echo esc_textarea( $value ); ?></textarea>

    <?php if ( ! empty( $error ) ) : ?>
        <span class="text-xs text-danger font-sans"><?php echo esc_html( $error ); ?></span>
    <?php endif; ?>
</div>
