<?php
/**
 * Rich Image Content Template
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow          = get_field( 'eyebrow' ) ?: 'KURUMSAL';
$title            = get_field( 'title' ) ?: '20 Yıllık Tecrübeyle İyiliğin Sesi Oluyoruz';
$description      = get_field( 'description' ) ?: 'Kurulduğumuz günden bu yana projeler geliştiriyoruz.';
$layout_direction = get_field( 'layout_direction' ) ?: 'left';
$image_1          = get_field( 'image_1' ) ?: get_template_directory_uri() . '/assets/demo/demo_relief.jpg';
$image_2          = get_field( 'image_2' ) ?: get_template_directory_uri() . '/assets/demo/demo_orphan.jpg';
$image_3          = get_field( 'image_3' ) ?: get_template_directory_uri() . '/assets/demo/demo_waterwell.jpg';
$image_4          = get_field( 'image_4' ) ?: get_template_directory_uri() . '/assets/demo/demo_education.jpg';
$features         = get_field( 'features' ) ?: [];

$grid_order_class = ( 'right' === $layout_direction ) ? 'md:order-2' : '';
$text_order_class = ( 'right' === $layout_direction ) ? 'md:order-1' : '';

ob_start();
?>
<div class="grid grid-cols-1 md:grid-cols-12 gap-section-sm items-center">
    
    <!-- Image Grid Column -->
    <div class="md:col-span-6 <?php echo esc_attr( $grid_order_class ); ?>">
        <div class="grid grid-cols-2 gap-component-sm">
            <?php if ( $image_1 ) : ?>
                <div class="aspect-square rounded-large overflow-hidden shadow-sm">
                    <img src="<?php echo esc_url( $image_1 ); ?>" alt="" class="w-full h-full object-cover" />
                </div>
            <?php endif; ?>
            <?php if ( $image_2 ) : ?>
                <div class="aspect-square rounded-large overflow-hidden shadow-sm mt-component-md">
                    <img src="<?php echo esc_url( $image_2 ); ?>" alt="" class="w-full h-full object-cover" />
                </div>
            <?php endif; ?>
            <?php if ( $image_3 ) : ?>
                <div class="aspect-square rounded-large overflow-hidden shadow-sm -mt-component-md">
                    <img src="<?php echo esc_url( $image_3 ); ?>" alt="" class="w-full h-full object-cover" />
                </div>
            <?php endif; ?>
            <?php if ( $image_4 ) : ?>
                <div class="aspect-square rounded-large overflow-hidden shadow-sm">
                    <img src="<?php echo esc_url( $image_4 ); ?>" alt="" class="w-full h-full object-cover" />
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Content Column -->
    <div class="md:col-span-6 flex flex-col gap-component-md <?php echo esc_attr( $text_order_class ); ?>">
        <div class="flex flex-col gap-component-xs">
            <?php if ( ! empty( $eyebrow ) ) : ?>
                <span class="text-xs font-semibold text-primary uppercase tracking-wide font-sans">
                    <?php echo esc_html( $eyebrow ); ?>
                </span>
            <?php endif; ?>
            <?php if ( ! empty( $title ) ) : ?>
                <h2 class="text-3xl font-bold text-text font-heading">
                    <?php echo esc_html( $title ); ?>
                </h2>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $description ) ) : ?>
            <p class="text-base text-text-muted font-sans leading-relaxed">
                <?php echo esc_html( $description ); ?>
            </p>
        <?php endif; ?>

        <!-- Features list -->
        <?php if ( ! empty( $features ) ) : ?>
            <div class="flex flex-col gap-component-md mt-component-xs">
                <?php foreach ( $features as $feat ) : 
                    $icon_markup = '';
                    if ( ! empty( $feat['icon'] ) && function_exists( 'mbk_aip_get_icon_markup' ) ) {
                        $icon_markup = mbk_aip_get_icon_markup( $feat['icon'], [
                            'class' => 'text-primary h-6 w-6 shrink-0'
                        ] );
                    }
                    ?>
                    <div class="flex items-start gap-component-sm">
                        <?php if ( $icon_markup ) : ?>
                            <div class="p-component-xs bg-primary/10 rounded-medium text-primary flex items-center justify-center shrink-0">
                                <?php echo $icon_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </div>
                        <?php endif; ?>
                        <div class="flex-1 flex flex-col gap-component-xs">
                            <h4 class="text-base font-bold text-text font-sans">
                                <?php echo esc_html( $feat['title'] ); ?>
                            </h4>
                            <p class="text-sm text-text-muted font-sans leading-relaxed">
                                <?php echo esc_html( $feat['description'] ); ?>
                            </p>
                            <?php if ( ! empty( $feat['cta_text'] ) && ! empty( $feat['cta_url'] ) ) : ?>
                                <div>
                                    <?php
                                    get_template_part( 'resources/components/button', null, [
                                        'variant' => 'text',
                                        'size' => 'small',
                                        'text' => $feat['cta_text'],
                                        'url' => $feat['cta_url']
                                    ] );
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</div>
<?php
$container_content = ob_get_clean();

ob_start();
get_template_part( 'resources/components/container', null, [
    'content' => $container_content,
] );
$section_content = ob_get_clean();

get_template_part( 'resources/components/section', null, [
    'spacing'    => 'md',
    'background' => 'default',
    'content'    => $section_content,
] );
?>
