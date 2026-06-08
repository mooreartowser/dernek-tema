<?php
/**
 * Featured Projects Block Template
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title             = get_field( 'title' ) ?: 'Öne Çıkan Yardım Projeleri';
$description       = get_field( 'description' ) ?: 'Sizlerin destekleriyle hayata geçirdiğimiz bazı yardım projelerimiz.';
$selected_projects = get_field( 'selected_projects' );

$projects = [];

if ( ! empty( $selected_projects ) ) {
    $projects = $selected_projects;
} else {
    // Fallback: Query database
    $query = new WP_Query([
        'post_type'      => 'project',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
    ]);
    
    if ( $query->have_posts() ) {
        $projects = $query->posts;
    }
}
?>

<?php
/**
 * Featured Projects Block Template
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title             = get_field( 'title' ) ?: 'Öne Çıkan Yardım Projeleri';
$description       = get_field( 'description' ) ?: 'Sizlerin destekleriyle hayata geçirdiğimiz bazı yardım projelerimiz.';
$selected_projects = get_field( 'selected_projects' );

$projects = [];

if ( ! empty( $selected_projects ) ) {
    $projects = $selected_projects;
} else {
    // Fallback: Query database
    $query = new WP_Query([
        'post_type'      => 'project',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
    ]);
    
    if ( $query->have_posts() ) {
        $projects = $query->posts;
    }
}

ob_start();
?>

<!-- Header -->
<div class="flex flex-col gap-component-xs md:text-center max-w-2xl md:mx-auto">
    <?php if ( ! empty( $title ) ) : ?>
        <h2 class="text-3xl font-bold text-text font-heading">
            <?php echo esc_html( $title ); ?>
        </h2>
    <?php endif; ?>

    <?php if ( ! empty( $description ) ) : ?>
        <p class="text-base text-text-muted font-sans leading-relaxed">
            <?php echo esc_html( $description ); ?>
        </p>
    <?php endif; ?>
</div>

<!-- Projects Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-component-lg">
    <?php if ( ! empty( $projects ) ) : ?>
        <?php foreach ( $projects as $post_obj ) : 
            // Setup postdata
            $p_id = $post_obj->ID;
            $p_title = get_the_title( $p_id );
            $p_url = get_permalink( $p_id );
            $p_image = get_the_post_thumbnail_url( $p_id, 'medium' ) ?: get_template_directory_uri() . '/assets/demo/demo_waterwell.jpg';
            $p_excerpt = get_the_excerpt( $p_id ) ?: 'Bu proje hakkında detaylı açıklamalar ve raporlar çok yakında eklenecektir.';
            
            // ACF CRM code or mock progress
            $collected = get_field( 'collected_amount', $p_id ) ?: 45000;
            $target = get_field( 'target_amount', $p_id ) ?: 60000;
            $percentage = min( 100, round( ( $collected / $target ) * 100 ) );
            
            // Format output
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
                        'text' => 'Bağış Yap',
                        'url' => $p_url
                    ] );
                    ?>
                </div>
            </div>
            <?php
            $card_footer = ob_get_clean();

            get_template_part( 'resources/components/card', null, [
                'title' => $p_title,
                'subtitle' => 'Yardım Projesi',
                'image_url' => $p_image,
                'content' => '<p>' . esc_html( $p_excerpt ) . '</p>',
                'footer' => $card_footer,
                'url' => $p_url
            ] );
        endforeach; ?>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <!-- Demo Mock Data if CPT does not have posts yet -->
        <?php
        // Mock project 1
        ob_start();
        ?>
        <div class="w-full flex flex-col gap-component-xs mt-component-xs">
            <div class="flex justify-between text-xs font-semibold font-sans">
                <span class="text-primary">30.000 TL</span>
                <span class="text-text-muted">Hedef: 50.000 TL</span>
            </div>
            <div class="w-full bg-surface-alt rounded-pill h-2 overflow-hidden border border-border">
                <div class="bg-primary h-full rounded-pill" style="width: 60%"></div>
            </div>
            <div class="flex justify-between items-center text-xs font-sans mt-component-xs">
                <span class="text-text-muted">%60 Tamamlandı</span>
                <?php
                get_template_part( 'resources/components/button', null, [
                    'variant' => 'primary',
                    'size' => 'small',
                    'text' => 'Bağış Yap',
                    'url' => '#'
                ] );
                ?>
            </div>
        </div>
        <?php
        $mock_footer1 = ob_get_clean();

        get_template_part( 'resources/components/card', null, [
            'title' => 'Afrika Çad Su Kuyusu Projesi',
            'subtitle' => 'Su Kuyusu',
            'image_url' => get_template_directory_uri() . '/assets/demo/demo_waterwell.jpg',
            'content' => '<p>Afrika Çad bölgesinde temiz suya erişemeyen kardeşlerimiz için açacağımız su kuyusu ile binlerce insanın hayatına can oluyoruz.</p>',
            'footer' => $mock_footer1,
            'url' => '#'
        ] );

        // Mock project 2
        ob_start();
        ?>
        <div class="w-full flex flex-col gap-component-xs mt-component-xs">
            <div class="flex justify-between text-xs font-semibold font-sans">
                <span class="text-primary">75.000 TL</span>
                <span class="text-text-muted">Hedef: 100.000 TL</span>
            </div>
            <div class="w-full bg-surface-alt rounded-pill h-2 overflow-hidden border border-border">
                <div class="bg-primary h-full rounded-pill" style="width: 75%"></div>
            </div>
            <div class="flex justify-between items-center text-xs font-sans mt-component-xs">
                <span class="text-text-muted">%75 Tamamlandı</span>
                <?php
                get_template_part( 'resources/components/button', null, [
                    'variant' => 'primary',
                    'size' => 'small',
                    'text' => 'Bağış Yap',
                    'url' => '#'
                ] );
                ?>
            </div>
        </div>
        <?php
        $mock_footer2 = ob_get_clean();

        get_template_part( 'resources/components/card', null, [
            'title' => 'Suriye İdlib Çadır Kent Gıda Yardımı',
            'subtitle' => 'Acil Yardım',
            'image_url' => get_template_directory_uri() . '/assets/demo/demo_relief.jpg',
            'content' => '<p>Suriye İdlib mülteci kamplarında çetin kış şartlarında mücadele veren ailelere gıda kolisi dağıtımları gerçekleştiriyoruz.</p>',
            'footer' => $mock_footer2,
            'url' => '#'
        ] );

        // Mock project 3
        ob_start();
        ?>
        <div class="w-full flex flex-col gap-component-xs mt-component-xs">
            <div class="flex justify-between text-xs font-semibold font-sans">
                <span class="text-primary">12.000 TL</span>
                <span class="text-text-muted">Hedef: 15.000 TL</span>
            </div>
            <div class="w-full bg-surface-alt rounded-pill h-2 overflow-hidden border border-border">
                <div class="bg-primary h-full rounded-pill" style="width: 80%"></div>
            </div>
            <div class="flex justify-between items-center text-xs font-sans mt-component-xs">
                <span class="text-text-muted">%80 Tamamlandı</span>
                <?php
                get_template_part( 'resources/components/button', null, [
                    'variant' => 'primary',
                    'size' => 'small',
                    'text' => 'Bağış Yap',
                    'url' => '#'
                ] );
                ?>
            </div>
        </div>
        <?php
        $mock_footer3 = ob_get_clean();

        get_template_part( 'resources/components/card', null, [
            'title' => '100 Yetim Çocuğa Eğitim Kırtasiye Desteği',
            'subtitle' => 'Eğitim',
            'image_url' => get_template_directory_uri() . '/assets/demo/demo_orphan.jpg',
            'content' => '<p>Yoksul ailelerin çocuklarına yeni eğitim döneminde okul kırtasiye seti ve okul çantası desteği sağlıyoruz.</p>',
            'footer' => $mock_footer3,
            'url' => '#'
        ] );
        ?>
    <?php endif; ?>
</div>

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

