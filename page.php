<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

while ( have_posts() ) :
    the_post();
    
    // Output global Page Hero component
    get_template_part( 'resources/components/page-hero', null, [
        'title'       => get_the_title(),
        'description' => get_the_excerpt()
    ] );
    ?>

    <?php
    ob_start();
    ?>
    <main id="main" class="site-main">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php
            ob_start();
            ?>
            <div class="prose prose-lg max-w-none font-sans text-text leading-relaxed">
                <?php
                the_content();

                wp_link_pages( [
                    'before' => '<div class="page-links">' . esc_html__( 'Sayfalar:', 'dernek-tema' ),
                    'after'  => '</div>',
                ] );
                ?>
            </div>
            <?php
            $container_content = ob_get_clean();
            get_template_part( 'resources/components/container', null, [
                'content' => $container_content,
            ] );
            ?>
        </article>
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
endwhile;

get_footer();
