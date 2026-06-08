<?php
/**
 * CRM Donation Progress Component
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$collected  = isset( $args['collected_amount'] ) ? (float) $args['collected_amount'] : 0;
$target     = isset( $args['target_amount'] ) ? (float) $args['target_amount'] : 0;
$percentage = isset( $args['percentage'] ) ? (int) $args['percentage'] : 0;

if ( $target <= 0 ) {
    return; // Progress bar is only visible when a positive target is defined
}
?>

<div class="w-full flex flex-col gap-2 font-sans text-xs">
    <div class="flex justify-between font-bold leading-none">
        <span class="text-primary"><?php echo number_format( $collected, 0, ',', '.' ); ?> TL</span>
        <span class="text-text-muted">Hedef: <?php echo number_format( $target, 0, ',', '.' ); ?> TL</span>
    </div>
    <div class="w-full bg-surface-alt rounded-pill h-2 overflow-hidden border border-border">
        <div class="bg-primary h-full rounded-pill transition-all duration-500" style="width: <?php echo esc_attr( $percentage ); ?>%"></div>
    </div>
    <div class="flex justify-between items-center text-[10px] text-text-muted uppercase font-bold tracking-wider leading-none">
        <span>%<?php echo esc_html( $percentage ); ?> Tamamlandı</span>
    </div>
</div>
