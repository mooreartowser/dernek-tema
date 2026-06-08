<?php
/**
 * Template Name: Donation Catalog
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

// Fetch the catalog collection from CRM
$requested_category = isset( $_GET['kategori'] ) ? sanitize_key( $_GET['kategori'] ) : '';
$requested_product  = isset( $_GET['urun'] ) ? sanitize_text_field( $_GET['urun'] ) : '';

$catalog_browser = \kadim_crm_bridge()->catalog_browser();
$catalog = $catalog_browser->build_theme_donation_catalog_collection([
    'requested_category' => $requested_category,
    'requested_product'  => $requested_product,
], home_url( '/bagislar/' ));

// Fetch the current WordPress cart snapshot to show a "Go to Cart" banner if items exist
$cart_snapshot = apply_filters( 'peta_cart_snapshot', null, [
    'redirect_url' => home_url( '/bagislar/' )
] );

// Render Page Hero
get_template_part( 'resources/components/page-hero', null, [
    'title'       => __( 'Online Bağış', 'dernek-tema' ),
    'description' => __( 'İhtiyaç sahiplerine ulaştırmak istediğiniz bağış fonunu ve tutarını seçerek destek olabilirsiniz.', 'dernek-tema' )
] );
?>

<?php
ob_start();
?>
<main id="main" class="site-main">
    <?php
    ob_start();
    ?>
    
    <!-- Sticky Cart Notification Banner -->
    <?php if ( ! empty( $cart_snapshot['items'] ) ) : ?>
        <div class="mb-8 p-4 bg-primary/10 border border-primary/20 rounded-large flex flex-col sm:flex-row justify-between items-center gap-4 animate-fade-in">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-pill bg-primary/20 flex items-center justify-center text-primary">
                    <i class="ri-shopping-basket-2-line text-lg"></i>
                </div>
                <div>
                    <h4 class="font-sans font-bold text-sm text-secondary">
                        <?php printf( __( 'Sepetinizde %d adet bağış bulunuyor.', 'dernek-tema' ), $cart_snapshot['lineCount'] ); ?>
                    </h4>
                    <p class="font-sans text-xs text-text-muted mt-0.5">
                        <?php printf( __( 'Toplam Tutar: %s TL', 'dernek-tema' ), number_format( $cart_snapshot['totalAmount'], 0, ',', '.' ) ); ?>
                    </p>
                </div>
            </div>
            <?php get_template_part( 'resources/components/button', null, [
                'variant' => 'primary',
                'size'    => 'small',
                'text'    => __( 'Ödeme Adımına Geç →', 'dernek-tema' ),
                'url'     => home_url( '/odeme/' )
            ] ); ?>
        </div>
    <?php endif; ?>

    <!-- Catalog Availability State -->
    <?php if ( isset( $catalog['status']['state'] ) && $catalog['status']['state'] === 'unavailable' ) : ?>
        <?php
        ob_start();
        ?>
        <div class="w-16 h-16 bg-danger/10 text-danger rounded-pill flex items-center justify-center mx-auto mb-4">
            <i class="ri-error-warning-line text-3xl"></i>
        </div>
        <h3 class="font-heading font-bold text-lg text-secondary mb-2">
            <?php esc_html_e( 'Bağlantı Hatası', 'dernek-tema' ); ?>
        </h3>
        <p class="font-sans text-sm text-text-muted mb-6">
            <?php echo esc_html( $catalog['status']['message'] ); ?>
        </p>
        <?php get_template_part( 'resources/components/button', null, [
            'variant' => 'outline',
            'size'    => 'medium',
            'text'    => __( 'Yeniden Dene', 'dernek-tema' ),
            'url'     => home_url( '/bagislar/' )
        ] ); ?>
        <?php
        $card_content = ob_get_clean();
        get_template_part( 'resources/components/card', null, [
            'class'   => 'text-center py-12 bg-white p-8 max-w-lg mx-auto shadow-sm',
            'content' => $card_content,
        ] );
        ?>
    <?php else : ?>

        <!-- Root Categories Tabs -->
        <?php if ( ! empty( $catalog['filters'] ) ) : ?>
            <div class="flex flex-wrap items-center justify-center gap-3 mb-8 border-b border-border/40 pb-6 font-sans">
                <?php foreach ( $catalog['filters'] as $filter ) : 
                    $is_active = ( $catalog['active_parent_category'] === $filter['code'] );
                    $active_classes = $is_active 
                        ? 'bg-primary text-white shadow-sm ring-2 ring-primary/20' 
                        : 'bg-white text-text border border-border hover:bg-surface-alt hover:text-primary';
                    ?>
                    <a href="<?php echo esc_url( add_query_arg( 'kategori', $filter['code'], home_url( '/bagislar/' ) ) ); ?>" 
                       class="px-5 py-2.5 rounded-pill text-sm font-bold transition-all duration-200 <?php echo $active_classes; ?>">
                        <?php echo esc_html( $filter['label'] ); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Subcategories Filters (Horizontal pills) -->
        <?php if ( ! empty( $catalog['subcategory_filters'] ) ) : ?>
            <div class="flex flex-wrap items-center justify-center gap-2 mb-10 font-sans">
                <!-- "Tümü" subcategory filter -->
                <?php 
                $is_all_active = ( $catalog['active_category'] === $catalog['active_parent_category'] );
                $all_classes = $is_all_active 
                    ? 'bg-secondary text-white' 
                    : 'bg-surface-alt/60 text-text-muted hover:bg-surface-alt hover:text-secondary';
                ?>
                <a href="<?php echo esc_url( add_query_arg( 'kategori', $catalog['active_parent_category'], home_url( '/bagislar/' ) ) ); ?>" 
                   class="px-4 py-1.5 rounded-pill text-xs font-bold transition-all duration-200 <?php echo $all_classes; ?>">
                    <?php esc_html_e( 'Tümü', 'dernek-tema' ); ?>
                </a>

                <?php foreach ( $catalog['subcategory_filters'] as $sub_filter ) : 
                    $is_sub_active = ( $catalog['active_category'] === $sub_filter['code'] );
                    $sub_classes = $is_sub_active 
                        ? 'bg-secondary text-white' 
                        : 'bg-surface-alt/60 text-text-muted hover:bg-surface-alt hover:text-secondary';
                    ?>
                    <a href="<?php echo esc_url( add_query_arg( 'kategori', $sub_filter['code'], home_url( '/bagislar/' ) ) ); ?>" 
                       class="px-4 py-1.5 rounded-pill text-xs font-bold transition-all duration-200 <?php echo $sub_classes; ?>">
                        <?php echo esc_html( $sub_filter['label'] ); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Catalog Grid -->
        <?php if ( ! empty( $catalog['card_groups'] ) ) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-component-lg">
                <?php foreach ( $catalog['card_groups'] as $card_group ) : 
                    $has_multiple_variants = count( $card_group['variants'] ) > 1;
                    $selected_variant      = $card_group['variants'][ $card_group['selected_variant_index'] ?? 0 ];
                    $is_variable           = ( $selected_variant['amount'] <= 0 );
                    ?>
                    <?php
                    // Render the self-contained composite card
                    get_template_part( 'resources/components/crm/donation-card', null, [
                        'title'                  => $card_group['title'],
                        'description'            => $card_group['description'] ?: sprintf( __( '%s alanında bağış yaparak ihtiyaç sahiplerine destek olabilirsiniz.', 'dernek-tema' ), $card_group['title'] ),
                        'image_url'              => $card_group['image_url'] ?: get_template_directory_uri() . '/assets/placeholder.jpg',
                        'badge_text'             => $card_group['tag'],
                        'price'                  => $has_multiple_variants ? null : ( $is_variable ? null : $selected_variant['amount'] ),
                        'donation_url'           => '#',
                        'product_code'           => $has_multiple_variants ? '' : $selected_variant['product_code'],
                        'variants'               => $card_group['variants'],
                        'selected_variant_index' => $card_group['selected_variant_index'] ?? 0,
                        'is_variable'            => $has_multiple_variants ? null : $is_variable,
                    ] );
                    ?>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="text-center py-12">
                <p class="text-text-muted text-base font-sans">
                    <?php esc_html_e( 'Bu kategoride aktif bağış fonu bulunmamaktadır.', 'dernek-tema' ); ?>
                </p>
            </div>
        <?php endif; ?>

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

get_footer();
