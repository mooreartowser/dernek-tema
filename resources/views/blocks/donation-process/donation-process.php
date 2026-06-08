<?php
/**
 * Donation Process Template
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$section_title = get_field( 'section_title' ) ?: 'Yardımlarınız İhtiyaç Sahiplerine Nasıl Ulaşıyor?';
$steps         = get_field( 'steps' ) ?: [];
?>

<?php
/**
 * Donation Process Template
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$section_title = get_field( 'section_title' ) ?: 'Yardımlarınız İhtiyaç Sahiplerine Nasıl Ulaşıyor?';
$steps         = get_field( 'steps' ) ?: [];

ob_start();
?>

<?php if ( ! empty( $section_title ) ) : ?>
    <div class="text-center">
        <h2 class="text-3xl font-bold text-text font-heading">
            <?php echo esc_html( $section_title ); ?>
        </h2>
    </div>
<?php endif; ?>

<?php if ( ! empty( $steps ) ) : ?>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-component-lg relative">
        <?php foreach ( $steps as $index => $step ) : 
            $icon_markup = '';
            if ( ! empty( $step['icon'] ) && function_exists( 'mbk_aip_get_icon_markup' ) ) {
                $icon_markup = mbk_aip_get_icon_markup( $step['icon'], [
                    'class' => 'text-primary h-8 w-8 shrink-0'
                ] );
            }
            ?>
            <div class="flex flex-col items-center text-center gap-component-sm relative group">
                
                <!-- Step Icon -->
                <div class="p-component-md bg-surface border border-border rounded-full text-primary flex items-center justify-center shadow-sm w-16 h-16 relative z-10 group-hover:border-primary transition-colors duration-200">
                    <!-- Step counter badge -->
                    <span class="absolute -top-1 -right-1 bg-accent text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                        <?php echo esc_html( $index + 1 ); ?>
                    </span>
                    <?php if ( $icon_markup ) : ?>
                        <?php echo $icon_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php endif; ?>
                </div>

                <!-- Step Info -->
                <div class="flex flex-col gap-component-xs mt-component-xs">
                    <h4 class="text-base font-bold text-text font-sans">
                        <?php echo esc_html( $step['title'] ); ?>
                    </h4>
                    <p class="text-xs text-text-muted font-sans leading-relaxed">
                        <?php echo esc_html( $step['description'] ); ?>
                    </p>
                </div>

                <!-- Dotted Connector Line (Only for desktop, between steps) -->
                <?php if ( $index < count($steps) - 1 ) : ?>
                    <div class="hidden md:block absolute left-[calc(50%+2.5rem)] top-8 w-[calc(100%-5rem)] h-[1px] border-t-2 border-dashed border-border z-0"></div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
$container_content = ob_get_clean();

ob_start();
get_template_part( 'resources/components/container', null, [
    'class'   => 'flex flex-col gap-component-lg',
    'content' => $container_content,
] );
$section_content = ob_get_clean();

get_template_part( 'resources/components/section', null, [
    'spacing'    => 'md',
    'background' => 'default',
    'content'    => $section_content,
] );

