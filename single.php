<?php
/**
 * The template for displaying all single posts
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

while ( have_posts() ) :
    the_post();
    
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
            <!-- Standard Post Layout with Author/Date Meta -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
                <!-- Main Content Column -->
                <div class="lg:col-span-3">
                    <div class="flex items-center gap-4 text-xs text-text-muted mb-6 font-sans">
                        <span><i class="ri-calendar-line"></i> <?php echo get_the_date(); ?></span>
                        <span><i class="ri-user-line"></i> <?php echo get_the_author(); ?></span>
                        <?php if ( has_category() ) : ?>
                            <span><i class="ri-folder-open-line"></i> <?php the_category( ', ' ); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="prose prose-lg max-w-none font-sans text-text leading-relaxed">
                        <?php
                        the_content();

                        wp_link_pages( [
                            'before' => '<div class="page-links">' . esc_html__( 'Sayfalar:', 'dernek-tema' ),
                            'after'  => '</div>',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Sidebar Column -->
                <aside class="lg:col-span-1 flex flex-col gap-6">
                    <!-- Recent Posts Widget -->
                    <?php
                    ob_start();
                    ?>
                    <h3 class="font-heading font-bold text-lg text-secondary border-b border-border pb-3 mb-4">
                        <?php esc_html_e( 'Son Yazılar', 'dernek-tema' ); ?>
                    </h3>
                    <ul class="flex flex-col gap-4">
                        <?php
                        $recent = new WP_Query([
                            'post_type'      => 'post',
                            'posts_per_page' => 4,
                            'post__not_in'   => [ get_the_ID() ]
                        ]);
                        if ( $recent->have_posts() ) :
                            while ( $recent->have_posts() ) : $recent->the_post(); ?>
                                <li>
                                    <a href="<?php the_permalink(); ?>" class="text-sm font-semibold text-text hover:text-primary transition-colors line-clamp-2 leading-snug">
                                        <?php the_title(); ?>
                                    </a>
                                    <span class="text-xs text-text-muted mt-1 block"><?php echo get_the_date(); ?></span>
                                </li>
                            <?php endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<li class="text-xs text-text-muted">' . esc_html__( 'Başka yazı bulunmuyor.', 'dernek-tema' ) . '</li>';
                        endif;
                        ?>
                    </ul>
                    <?php
                    $card_content = ob_get_clean();
                    get_template_part( 'resources/components/card', null, [
                        'class'   => 'p-6 hover:shadow-md shadow-sm',
                        'content' => $card_content,
                    ] );
                    ?>
                </aside>
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
