<?php
/**
 * The template for displaying all single Activity CPT posts
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

while ( have_posts() ) :
    the_post();
    
    $a_id = get_the_ID();

    // Page Hero
    get_template_part( 'resources/components/page-hero', null, [
        'title'       => get_the_title(),
        'description' => sprintf( __( 'Faaliyet Raporu - Yayın Tarihi: %s', 'dernek-tema' ), get_the_date() )
    ] );
    ?>
    <?php
    ob_start();
    ?>
    <main id="main" class="site-main">
        <?php
        ob_start();
        ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Left Column: Main Post Content (70%) -->
            <div class="lg:col-span-2 flex flex-col gap-6">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="w-full h-[320px] md:h-[450px] overflow-hidden rounded-large shadow-sm border border-border">
                        <img src="<?php echo esc_url( get_the_post_thumbnail_url( $a_id, 'full' ) ); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover" />
                    </div>
                <?php endif; ?>

                <div class="flex items-center gap-4 text-xs text-text-muted mt-2 font-sans border-b border-border pb-4">
                    <span><i class="ri-calendar-line text-primary"></i> <?php echo get_the_date(); ?></span>
                    <span><i class="ri-user-line text-primary"></i> <?php echo get_the_author(); ?></span>
                </div>

                <div class="prose prose-lg max-w-none font-sans text-text leading-relaxed mt-4">
                    <?php
                    the_content();

                    wp_link_pages( [
                        'before' => '<div class="page-links">' . esc_html__( 'Sayfalar:', 'dernek-tema' ),
                        'after'  => '</div>',
                    ] );
                    ?>
                </div>
            </div>

            <!-- Right Column: Sidebar (30%) -->
            <aside class="lg:col-span-1 flex flex-col gap-8">
                
                <!-- Share Card Widget -->
                <?php
                ob_start();
                ?>
                <h3 class="font-heading font-bold text-lg text-secondary border-b border-border pb-3">
                    <?php esc_html_e( 'Paylaş ve Destek Ol', 'dernek-tema' ); ?>
                </h3>
                <p class="text-xs text-text-muted font-sans leading-normal">
                    <?php esc_html_e( 'Faaliyetlerimizi sosyal medyada paylaşarak daha fazla insana ulaşmasını sağlayabilirsiniz.', 'dernek-tema' ); ?>
                </p>
                
                <div class="flex items-center gap-3 mt-2">
                    <?php
                    $share_url = urlencode( get_permalink() );
                    $share_title = urlencode( get_the_title() );
                    ?>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full border border-border hover:bg-primary hover:text-white hover:border-primary text-text-muted flex items-center justify-center transition-all duration-200">
                        <i class="ri-facebook-fill text-lg"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full border border-border hover:bg-primary hover:text-white hover:border-primary text-text-muted flex items-center justify-center transition-all duration-200">
                        <i class="ri-twitter-x-fill text-lg"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text=<?php echo $share_title . '%20' . $share_url; ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full border border-border hover:bg-emerald-500 hover:text-white hover:border-emerald-500 text-text-muted flex items-center justify-center transition-all duration-200">
                        <i class="ri-whatsapp-line text-lg"></i>
                    </a>
                </div>
                <?php
                $card_content = ob_get_clean();
                get_template_part( 'resources/components/card', null, [
                    'class'   => 'bg-white p-6 shadow-sm hover:shadow-md flex flex-col gap-4',
                    'content' => $card_content,
                ] );
                ?>

                <!-- Recent Activities Widget -->
                <?php
                ob_start();
                ?>
                <h3 class="font-heading font-bold text-lg text-secondary border-b border-border pb-3">
                    <?php esc_html_e( 'Diğer Faaliyetler', 'dernek-tema' ); ?>
                </h3>
                <ul class="flex flex-col gap-4">
                    <?php
                    $recent_acts = new WP_Query([
                        'post_type'      => 'activity',
                        'posts_per_page' => 4,
                        'post__not_in'   => [ get_the_ID() ]
                    ]);
                    if ( $recent_acts->have_posts() ) :
                        while ( $recent_acts->have_posts() ) : $recent_acts->the_post(); ?>
                            <li class="flex flex-col gap-1 border-b border-border/40 pb-3 last:border-b-0 last:pb-0">
                                <a href="<?php the_permalink(); ?>" class="text-sm font-semibold text-text hover:text-primary transition-colors line-clamp-2 leading-snug">
                                    <?php the_title(); ?>
                                </a>
                                <span class="text-xs text-text-muted mt-1 flex items-center gap-1">
                                    <i class="ri-calendar-line"></i>
                                    <?php echo get_the_date(); ?>
                                </span>
                            </li>
                        <?php endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<li class="text-xs text-text-muted">' . esc_html__( 'Başka faaliyet bulunmuyor.', 'dernek-tema' ) . '</li>';
                    endif;
                    ?>
                </ul>
                <?php
                $card_content = ob_get_clean();
                get_template_part( 'resources/components/card', null, [
                    'class'   => 'bg-surface-alt p-6 shadow-sm hover:shadow-md flex flex-col gap-4',
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
