<?php
/**
 * CRM Donation Price Component
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$price    = isset( $args['price'] ) ? (float) $args['price'] : null;
$currency = $args['currency'] ?? 'TL';
?>

<div class="flex items-baseline gap-1.5 font-heading text-secondary leading-none">
    <?php if ( empty( $price ) ) : ?>
        <span class="text-primary font-bold text-xs uppercase font-sans tracking-wider py-1 px-2.5 bg-primary/5 rounded border border-primary/10">
            <?php esc_html_e( 'Serbest Tutar', 'dernek-tema' ); ?>
        </span>
    <?php else : ?>
        <span class="text-2xl font-black text-primary tracking-tight"><?php echo number_format( $price, 0, ',', '.' ); ?></span>
        <span class="text-[11px] font-bold text-text-muted uppercase font-sans"><?php echo esc_html( $currency ); ?></span>
    <?php endif; ?>
</div>
