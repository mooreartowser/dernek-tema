<?php
/**
 * Stats Grid Template
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$section_title = get_field( 'section_title' ) ?: 'Rakamlarla İyilik Yolculuğumuz';
$stats         = get_field( 'stats' ) ?: [];

ob_start();
?>

<?php if ( ! empty( $section_title ) ) : ?>
    <div class="text-center">
        <h2 class="text-3xl font-bold text-text font-heading">
            <?php echo esc_html( $section_title ); ?>
        </h2>
    </div>
<?php endif; ?>

<?php if ( ! empty( $stats ) ) : ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-component-md">
        <?php foreach ( $stats as $stat ) : 
            $icon_markup = '';
            if ( ! empty( $stat['icon'] ) && function_exists( 'mbk_aip_get_icon_markup' ) ) {
                $icon_markup = mbk_aip_get_icon_markup( $stat['icon'], [
                    'class' => 'text-primary h-8 w-8 shrink-0'
                ] );
            }
            
            ob_start();
            ?>
            <?php if ( $icon_markup ) : ?>
                <div class="p-component-sm bg-primary/10 rounded-pill text-primary flex items-center justify-center self-center w-fit mx-auto mb-component-xs">
                    <?php echo $icon_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
            <?php endif; ?>

            <div class="flex flex-col gap-component-xs text-center">
                <span class="text-3xl font-extrabold text-primary font-heading tracking-tight leading-none">
                    <?php echo esc_html( $stat['value'] ); ?>
                </span>
                <h4 class="text-base font-bold text-text font-sans">
                    <?php echo esc_html( $stat['title'] ); ?>
                </h4>
                <p class="text-xs text-text-muted font-sans leading-relaxed">
                    <?php echo esc_html( $stat['description'] ); ?>
                </p>
            </div>
            <?php
            $card_content = ob_get_clean();
            get_template_part( 'resources/components/card', null, [
                'class'   => 'flex flex-col gap-component-sm text-center items-center shadow-sm hover:shadow-md transition-shadow duration-200 border border-border rounded-large bg-surface',
                'content' => $card_content,
            ] );
            ?>
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
    'background' => 'alt',
    'content'    => $section_content,
] );

