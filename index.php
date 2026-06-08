<?php
/**
 * Main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @package DernekTema
 */

// If header layout is configured in layouts/header.php, WP get_header() will load it or fall back
get_header();
?>

<?php
ob_start();
?>
<main id="main" class="site-main">
    <?php
    ob_start();
    ?>
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            if ( locate_template( 'template-parts/content-' . get_post_type() . '.php' ) ) {
                get_template_part( 'template-parts/content', get_post_type() );
            } else {
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'prose prose-lg max-w-none font-sans text-text leading-relaxed' ); ?>>
                    <?php the_content(); ?>
                </article>
                <?php
            }
        endwhile;
    else :
        if ( locate_template( 'template-parts/content-none.php' ) ) {
            get_template_part( 'template-parts/content', 'none' );
        } else {
            echo '<p class="text-text-muted">' . esc_html__( 'Henüz içerik eklenmemiş.', 'dernek-tema' ) . '</p>';
        }
    endif;
    ?>
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
