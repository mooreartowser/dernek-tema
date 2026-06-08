<?php
/**
 * The template for displaying Activity CPT Archive pages
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

get_template_part( 'resources/components/page-hero', null, [
    'title'       => __( 'Faaliyetlerimiz', 'dernek-tema' ),
    'description' => __( 'Dünyanın dört bir yanındaki insani kriz bölgelerinde ve ihtiyaç sahipleri için yürüttüğümüz en son faaliyetlerimiz.', 'dernek-tema' )
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
                
                $a_id = get_the_ID();
                $a_title = get_the_title();
                $a_url = get_permalink();
                $a_image = get_the_post_thumbnail_url( $a_id, 'medium' ) ?: get_template_directory_uri() . '/assets/demo/demo_relief.jpg';
                $a_excerpt = get_the_excerpt() ?: __( 'Faaliyet detayları ve çalışma raporları çok yakında eklenecektir.', 'dernek-tema' );
                
                // Output card footer with date and read more button
                ob_start();
                ?>
                <div class="flex justify-between items-center text-xs font-sans mt-component-xs w-full">
                    <span class="text-text-muted flex items-center gap-1">
                        <i class="ri-calendar-line text-primary"></i>
                        <?php echo get_the_date(); ?>
                    </span>
                    <?php
                    get_template_part( 'resources/components/button', null, [
                        'variant' => 'primary',
                        'size' => 'small',
                        'text' => 'Faaliyeti İncele',
                        'url' => $a_url
                    ] );
                    ?>
                </div>
                <?php
                $card_footer = ob_get_clean();

                get_template_part( 'resources/components/card', null, [
                    'title' => $a_title,
                    'subtitle' => __( 'Saha Raporu', 'dernek-tema' ),
                    'image_url' => $a_image,
                    'content' => '<p>' . esc_html( $a_excerpt ) . '</p>',
                    'footer' => $card_footer,
                    'url' => $a_url
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
            <p class="text-text-muted text-base"><?php esc_html_e( 'Henüz faaliyet kaydı bulunmuyor.', 'dernek-tema' ); ?></p>
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
