<?php
/**
 * The template for displaying Project CPT Archive pages
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

get_template_part( 'resources/components/page-hero', null, [
    'title'       => __( 'Yardım Projelerimiz', 'dernek-tema' ),
    'description' => __( 'Sizlerin destekleriyle devam eden, yetimlerden su kuyularına kadar uzanan kalıcı yardım projelerimizi inceleyin.', 'dernek-tema' )
] );
?>

<?php
ob_start();
?>
<main id="main" class="site-main">
    <?php
    ob_start();
    ?>

    <?php if ( have_posts() ) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-component-lg">
            <?php
            while ( have_posts() ) :
                the_post();
                
                $p_id = get_the_ID();
                $p_title = get_the_title();
                $p_url = get_permalink();
                $p_image = get_the_post_thumbnail_url( $p_id, 'medium' ) ?: get_template_directory_uri() . '/assets/demo/demo_waterwell.jpg';
                $p_excerpt = get_the_excerpt() ?: __( 'Bu proje hakkında detaylı açıklamalar ve raporlar çok yakında eklenecektir.', 'dernek-tema' );
                
                // ACF CRM metadata progress fields
                $collected = get_field( 'collected_amount', $p_id ) ?: 45000;
                $target = get_field( 'target_amount', $p_id ) ?: 60000;
                $percentage = min( 100, round( ( $collected / $target ) * 100 ) );
                
                // Output card footer with progress bar and donation button
                ob_start();
                ?>
                <div class="w-full flex flex-col gap-component-xs mt-component-xs">
                    <div class="flex justify-between text-xs font-semibold font-sans">
                        <span class="text-primary"><?php echo number_format($collected, 0, ',', '.'); ?> TL</span>
                        <span class="text-text-muted">Hedef: <?php echo number_format($target, 0, ',', '.'); ?> TL</span>
                    </div>
                    <div class="w-full bg-surface-alt rounded-pill h-2 overflow-hidden border border-border">
                        <div class="bg-primary h-full rounded-pill transition-all duration-300" style="width: <?php echo esc_attr( $percentage ); ?>%"></div>
                    </div>
                    <div class="flex justify-between items-center text-xs font-sans mt-component-xs">
                        <span class="text-text-muted">%<?php echo esc_html( $percentage ); ?> Tamamlandı</span>
                        <?php
                        get_template_part( 'resources/components/button', null, [
                            'variant' => 'primary',
                            'size' => 'small',
                            'text' => 'Detaylar & Bağış',
                            'url' => $p_url
                        ] );
                        ?>
                    </div>
                </div>
                <?php
                $card_footer = ob_get_clean();

                get_template_part( 'resources/components/card', null, [
                    'title' => $p_title,
                    'subtitle' => __( 'Aktif Proje', 'dernek-tema' ),
                    'image_url' => $p_image,
                    'content' => '<p>' . esc_html( $p_excerpt ) . '</p>',
                    'footer' => $card_footer,
                    'url' => $p_url
                ] );
            endwhile;
            ?>
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center font-sans">
            <?php
            the_posts_pagination( [
                'mid_size'  => 2,
                'prev_text' => '<i class="ri-arrow-left-s-line text-lg"></i>',
                'next_text' => '<i class="ri-arrow-right-s-line text-lg"></i>',
                'class'     => 'pagination-nav'
            ] );
            ?>
        </div>

    <?php else : ?>
        <div class="text-center py-12">
            <p class="text-text-muted text-base"><?php esc_html_e( 'Aktif yardım projesi bulunmuyor.', 'dernek-tema' ); ?></p>
        </div>
    <?php endif; ?>

    <?php
    $container_content = ob_get_clean();
    get_template_part( 'resources/components/container', null, [
        'content' => $container_content,
    ] );
    ?>
</main>
<?php
$section_content = ob_get_clean();
get_template_part( 'resources/components/section', null, [
    'id'      => 'primary',
    'class'   => 'content-area flex-1',
    'spacing' => 'md',
    'content' => $section_content,
] );
?>

<?php
get_footer();
