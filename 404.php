<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

// Renders Page Hero with 404 fallback background
get_template_part( 'resources/components/page-hero', null, [
    'title'       => __( 'Sayfa Bulunamadı', 'dernek-tema' ),
    'description' => __( 'Aradığınız sayfa silinmiş, ismi değiştirilmiş veya geçici olarak kullanılamıyor olabilir.', 'dernek-tema' )
] );
?>

<?php
ob_start();
?>
<main id="main" class="site-main">
    <?php
    ob_start();
    ?>
    
    <div class="max-w-md mx-auto text-center flex flex-col gap-6 items-center">
        <div class="text-primary text-7xl font-extrabold font-heading">404</div>
        
        <p class="text-text-muted text-base leading-relaxed">
            <?php esc_html_e( 'Lütfen arama kutusunu kullanarak arama yapın veya ana sayfaya geri dönün.', 'dernek-tema' ); ?>
        </p>

        <!-- Custom styled Search Form -->
        <form role="search" method="get" class="w-full flex items-end gap-2" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php
            get_template_part( 'resources/components/input', null, [
                'type'        => 'search',
                'name'        => 's',
                'value'       => get_search_query(),
                'placeholder' => _x( 'Arama yapın...', 'placeholder', 'dernek-tema' ),
                'class'       => 'flex-1',
            ] );
            ?>
            <?php
            get_template_part( 'resources/components/button', null, [
                'variant' => 'primary',
                'size'    => 'medium',
                'text'    => __( 'Ara', 'dernek-tema' ),
                'type'    => 'submit'
            ] );
            ?>
        </form>

        <div class="mt-4">
            <?php
            get_template_part( 'resources/components/button', null, [
                'variant' => 'outline',
                'size'    => 'large',
                'text'    => __( 'Ana Sayfaya Dön', 'dernek-tema' ),
                'url'     => home_url( '/' )
            ] );
            ?>
        </div>
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
get_footer();
