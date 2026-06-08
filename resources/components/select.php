<?php
/**
 * Select Component
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$name        = $args['name'] ?? '';
$id          = $args['id'] ?? $name;
$options     = $args['options'] ?? [];
$selected    = $args['selected'] ?? '';
$label       = $args['label'] ?? '';
$required    = ! empty( $args['required'] ) ? 'required' : '';
$disabled    = ! empty( $args['disabled'] ) ? 'disabled' : '';
$error       = $args['error'] ?? '';
$class       = $args['class'] ?? '';
$input_class = $args['input_class'] ?? '';
$attributes  = $args['attributes'] ?? '';

$input_classes = 'w-full px-component-sm py-component-sm border rounded-medium text-text bg-surface-alt font-sans transition-all duration-200 focus:outline-none focus:bg-surface focus:ring-2 focus:ring-primary focus:border-transparent appearance-none ' . $input_class;

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

    <div class="relative w-full">
        <select 
            name="<?php echo esc_attr( $name ); ?>" 
            id="<?php echo esc_attr( $id ); ?>" 
            class="<?php echo esc_attr( $input_classes ); ?>" 
            <?php echo $required; ?> 
            <?php echo $disabled; ?>
            <?php echo $attributes; ?>
        >
            <?php foreach ( $options as $val => $option_data ) : 
                $lbl = $option_data;
                $data_attrs = '';
                if ( is_array( $option_data ) ) {
                    $lbl = $option_data['label'] ?? '';
                    if ( isset( $option_data['attributes'] ) && is_array( $option_data['attributes'] ) ) {
                        foreach ( $option_data['attributes'] as $attr_k => $attr_v ) {
                            $data_attrs .= ' ' . esc_attr( $attr_k ) . '="' . esc_attr( $attr_v ) . '"';
                        }
                    }
                }
                ?>
                <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $selected, $val ); ?><?php echo $data_attrs; ?>>
                    <?php echo esc_html( $lbl ); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-component-sm text-text-muted">
            <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
            </svg>
        </div>
    </div>

    <?php if ( ! empty( $error ) ) : ?>
        <span class="text-xs text-danger font-sans"><?php echo esc_html( $error ); ?></span>
    <?php endif; ?>
</div>
