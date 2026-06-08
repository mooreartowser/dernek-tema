<?php
/**
 * The template for displaying all single Project CPT posts
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

while ( have_posts() ) :
    the_post();
    
    $p_id = get_the_ID();
    $collected = get_field( 'collected_amount', $p_id ) ?: 45000;
    $target = get_field( 'target_amount', $p_id ) ?: 60000;
    $percentage = min( 100, round( ( $collected / $target ) * 100 ) );

    // Page Hero
    get_template_part( 'resources/components/page-hero', null, [
        'title'       => get_the_title(),
        'description' => __( 'Projeye bağışta bulunarak veya paylaşarak destek olabilirsiniz.', 'dernek-tema' )
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
                        <img src="<?php echo esc_url( get_the_post_thumbnail_url( $p_id, 'full' ) ); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover" />
                    </div>
                <?php endif; ?>

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

            <!-- Right Column: Sidebar Donation & Transfer Widgets (30%) -->
            <aside class="lg:col-span-1 flex flex-col gap-8">
                
                <!-- Progress Card Widget -->
                <?php
                ob_start();
                ?>
                <h3 class="font-heading font-bold text-lg text-secondary border-b border-border pb-3">
                    <?php esc_html_e( 'Bağış Durumu', 'dernek-tema' ); ?>
                </h3>
                
                <div class="flex flex-col gap-component-xs">
                    <div class="flex justify-between text-sm font-semibold font-sans">
                        <span class="text-primary text-base"><?php echo number_format($collected, 0, ',', '.'); ?> TL</span>
                        <span class="text-text-muted">Hedef: <?php echo number_format($target, 0, ',', '.'); ?> TL</span>
                    </div>
                    <div class="w-full bg-surface-alt rounded-pill h-2.5 overflow-hidden border border-border">
                        <div class="bg-primary h-full rounded-pill transition-all duration-300" style="width: <?php echo esc_attr( $percentage ); ?>%"></div>
                    </div>
                    <div class="flex justify-between items-center text-xs font-sans mt-component-xs">
                        <span class="text-text-muted">%<?php echo esc_html( $percentage ); ?> Tamamlandı</span>
                    </div>
                </div>

                <!-- Donation Buttons -->
                <div class="flex flex-col gap-3">
                    <?php
                    $donate_url = get_field( 'header_donate_cta_url', 'option' ) ?: '/online-bagis';
                    get_template_part( 'resources/components/button', null, [
                        'variant' => 'primary',
                        'size' => 'large',
                        'text' => __( 'Online Bağış Yap', 'dernek-tema' ),
                        'url' => esc_url( add_query_arg( 'project_id', $p_id, $donate_url ) ),
                        'class' => 'w-full text-center'
                    ] );
                    ?>
                </div>
                <?php
                $card_content = ob_get_clean();
                get_template_part( 'resources/components/card', null, [
                    'class'   => 'bg-white p-6 shadow-sm hover:shadow-md flex flex-col gap-5',
                    'content' => $card_content,
                ] );
                ?>

                <!-- Bank Transfer/IBAN Widget -->
                <?php 
                $bank_accounts = get_field( 'bank_accounts', 'option' );
                if ( is_array( $bank_accounts ) && ! empty( $bank_accounts ) ) : ?>
                    <?php
                    ob_start();
                    ?>
                    <h3 class="font-heading font-bold text-lg text-secondary border-b border-border pb-3 flex items-center gap-2">
                        <i class="ri-bank-card-line text-primary"></i>
                        <?php esc_html_e( 'Banka Hesap Numaraları', 'dernek-tema' ); ?>
                    </h3>
                    
                    <p class="text-xs text-text-muted font-sans leading-normal">
                        <?php esc_html_e( 'Havale/EFT yaparken açıklama kısmına proje adını yazmayı unutmayınız.', 'dernek-tema' ); ?>
                    </p>

                    <div class="flex flex-col gap-4 mt-2">
                        <?php foreach ( $bank_accounts as $bank ) : ?>
                            <div class="border-b border-border/60 pb-3 last:border-b-0 last:pb-0">
                                <span class="font-sans font-bold text-sm text-text block"><?php echo esc_html( $bank['bank_name'] ); ?></span>
                                <span class="text-xs text-text-muted block mt-0.5"><?php echo esc_html( $bank['account_holder'] ); ?></span>
                                
                                <?php if ( is_array( $bank['accounts'] ) ) : ?>
                                    <div class="flex flex-col gap-2 mt-2">
                                        <?php foreach ( $bank['accounts'] as $acc ) : ?>
                                            <div class="bg-white p-2.5 rounded border border-border text-xs font-mono flex flex-col gap-1">
                                                <div class="flex justify-between font-sans font-semibold text-text">
                                                    <span><?php echo esc_html( $acc['title'] ); ?></span>
                                                </div>
                                                <div class="flex justify-between items-center gap-1">
                                                    <span class="break-all text-[11px]"><?php echo esc_html( $acc['iban_number'] ); ?></span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php
                    $card_content = ob_get_clean();
                    get_template_part( 'resources/components/card', null, [
                        'class'   => 'bg-surface-alt p-6 shadow-sm hover:shadow-md flex flex-col gap-4',
                        'content' => $card_content,
                    ] );
                    ?>
                <?php endif; ?>

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
