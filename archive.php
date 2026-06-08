<?php
/**
 * The template for displaying archive pages
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

get_template_part( 'resources/components/page-hero', null, [
    'title'       => get_the_archive_title(),
    'description' => get_the_archive_description()
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
                
                $post_image = get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ?: get_template_directory_uri() . '/assets/demo/demo_relief.jpg';
                $post_title = get_the_title();
                $post_url = get_permalink();
                $post_excerpt = get_the_excerpt();

                // Footer component
                ob_start();
                ?>
                <div class="flex justify-between items-center text-xs font-sans mt-component-xs w-full">
                    <span class="text-text-muted"><?php echo get_the_date(); ?></span>
                    <?php
                    get_template_part( 'resources/components/button', null, [
                        'variant' => 'primary',
                        'size' => 'small',
                        'text' => 'Devamını Oku',
                        'url' => $post_url
                    ] );
                    ?>
                </div>
                <?php
                $footer_content = ob_get_clean();

                get_template_part( 'resources/components/card', null, [
                    'title' => $post_title,
                    'subtitle' => get_the_author(),
                    'image_url' => $post_image,
                    'content' => '<p>' . esc_html( $post_excerpt ) . '</p>',
                    'footer' => $footer_content,
                    'url' => $post_url
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
            <p class="text-text-muted text-base"><?php esc_html_e( 'Bu arşivde henüz içerik bulunmuyor.', 'dernek-tema' ); ?></p>
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
