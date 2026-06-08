<?php
/**
 * CRM Donation Status/Category Badge Component
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$text    = $args['text'] ?? '';
$variant = $args['variant'] ?? 'primary';

if ( empty( $text ) ) {
    return;
}

$classes = 'inline-flex items-center px-2.5 py-1 rounded-pill text-[11px] font-bold font-sans uppercase tracking-wider leading-none';

switch ( $variant ) {
    case 'secondary':
        $classes .= ' bg-secondary text-white';
        break;
    case 'accent':
        $classes .= ' bg-accent/10 text-accent border border-accent/20';
        break;
    case 'success':
        $classes .= ' bg-success/10 text-success border border-success/20';
        break;
    case 'warning':
        $classes .= ' bg-warning/10 text-warning border border-warning/20';
        break;
    case 'danger':
        $classes .= ' bg-danger/10 text-danger border border-danger/20';
        break;
    case 'primary':
    default:
        $classes .= ' bg-primary/10 text-primary border border-primary/20';
        break;
}
?>
<span class="<?php echo esc_attr( $classes ); ?>">
    <?php echo esc_html( $text ); ?>
</span>
