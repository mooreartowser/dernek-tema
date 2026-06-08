<?php
/**
 * Timeline Template
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$section_title  = get_field( 'section_title' ) ?: 'Tarihçemiz & Kilometre Taşları';
$timeline_items = get_field( 'timeline_items' ) ?: [];
?>

<?php
ob_start();
?>
<?php if ( ! empty( $section_title ) ) : ?>
    <div class="text-center">
        <h2 class="text-3xl font-bold text-text font-heading">
            <?php echo esc_html( $section_title ); ?>
        </h2>
    </div>
<?php endif; ?>

<?php if ( ! empty( $timeline_items ) ) : ?>
    <div class="relative flex flex-col gap-component-lg md:gap-0">
        <!-- Center Line for Desktop -->
        <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 w-[2px] bg-border h-full"></div>

        <?php foreach ( $timeline_items as $index => $item ) : 
            $is_even = ( 0 === $index % 2 );
            ?>
            <!-- Timeline Item -->
            <div class="flex flex-col md:flex-row items-center md:my-component-md w-full relative">
                <?php if ( $is_even ) : ?>
                    <!-- Left Content -->
                    <div class="w-full md:w-1/2 md:pr-component-lg flex justify-end">
                        <?php
                        ob_start();
                        ?>
                        <span class="text-xl font-extrabold text-primary font-heading leading-none"><?php echo esc_html( $item['year'] ); ?></span>
                        <h4 class="text-lg font-bold text-text font-sans"><?php echo esc_html( $item['title'] ); ?></h4>
                        <p class="text-sm text-text-muted font-sans leading-relaxed"><?php echo esc_html( $item['description'] ); ?></p>
                        <?php if ( ! empty( $item['image'] ) ) : ?>
                            <div class="mt-component-xs rounded-medium overflow-hidden aspect-video bg-surface-alt">
                                <img src="<?php echo esc_url( $item['image'] ); ?>" alt="" class="w-full h-full object-cover" />
                            </div>
                        <?php endif; ?>
                        <?php
                        $card_content = ob_get_clean();
                        get_template_part( 'resources/components/card', null, [
                            'class'   => 'max-w-md p-component-md flex flex-col gap-component-xs w-full bg-surface shadow-sm hover:shadow-md border border-border',
                            'content' => $card_content,
                        ] );
                        ?>
                    </div>
                    <!-- Central Dot -->
                    <div class="hidden md:flex absolute left-1/2 transform -translate-x-1/2 items-center justify-center">
                        <div class="w-4 h-4 bg-primary border-4 border-background rounded-full z-10 shadow-sm"></div>
                    </div>
                    <!-- Right Spacing placeholder -->
                    <div class="hidden md:block w-1/2"></div>
                <?php else : ?>
                    <!-- Left Spacing placeholder -->
                    <div class="hidden md:block w-1/2"></div>
                    <!-- Central Dot -->
                    <div class="hidden md:flex absolute left-1/2 transform -translate-x-1/2 items-center justify-center">
                        <div class="w-4 h-4 bg-primary border-4 border-background rounded-full z-10 shadow-sm"></div>
                    </div>
                    <!-- Right Content -->
                    <div class="w-full md:w-1/2 md:pl-component-lg flex justify-start">
                        <?php
                        ob_start();
                        ?>
                        <span class="text-xl font-extrabold text-primary font-heading leading-none"><?php echo esc_html( $item['year'] ); ?></span>
                        <h4 class="text-lg font-bold text-text font-sans"><?php echo esc_html( $item['title'] ); ?></h4>
                        <p class="text-sm text-text-muted font-sans leading-relaxed"><?php echo esc_html( $item['description'] ); ?></p>
                        <?php if ( ! empty( $item['image'] ) ) : ?>
                            <div class="mt-component-xs rounded-medium overflow-hidden aspect-video bg-surface-alt">
                                <img src="<?php echo esc_url( $item['image'] ); ?>" alt="" class="w-full h-full object-cover" />
                            </div>
                        <?php endif; ?>
                        <?php
                        $card_content = ob_get_clean();
                        get_template_part( 'resources/components/card', null, [
                            'class'   => 'max-w-md p-component-md flex flex-col gap-component-xs w-full bg-surface shadow-sm hover:shadow-md border border-border',
                            'content' => $card_content,
                        ] );
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php foreach_end: // Wait, standard loop closing is endforeach; ?>
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
