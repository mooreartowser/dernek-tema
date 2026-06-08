<?php
/**
 * The template for displaying the Thank-you / Success Page (tesekkur)
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

// 1. Initialize and require Esas Redis connection
$order_id = isset( $_GET['order_id'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['order_id'] ) ) : '';
$payment_result = null;
$order_data     = null;

if ( $order_id !== '' ) {
    try {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/_esas/redis.php';
        
        // Retrieve payment result status (5 mins TTL)
        $result_json = EsasRedis::connection()->get( EsasRedis::key( 'payment:result:' . $order_id ) );
        if ( $result_json ) {
            $payment_result = json_decode( $result_json, true );
        }
        
        // Retrieve full order cache (24 hrs TTL)
        $order_json = EsasRedis::connection()->get( EsasRedis::key( 'payment:order:' . $order_id ) );
        if ( $order_json ) {
            $order_data = json_decode( $order_json, true );
        }
    } catch ( Throwable $e ) {
        error_log( '[page-tesekkur.php] Redis error: ' . $e->getMessage() );
    }
}

// Fallback if status result cache is missing but order cache is present (treat as success)
$is_success = false;
if ( $payment_result && isset( $payment_result['status'] ) && $payment_result['status'] === 'success' ) {
    $is_success = true;
} elseif ( $order_data ) {
    $is_success = true; // If we have order cached, the callback completed successfully
}

// Render Page Hero with dynamic title
get_template_part( 'resources/components/page-hero', null, [
    'title'       => $is_success ? __( 'Bağışınız Kabul Edildi', 'dernek-tema' ) : __( 'İşlem Başarısız', 'dernek-tema' ),
    'description' => $is_success 
        ? __( 'Destekleriniz için teşekkür ederiz. Bağış kaydınız başarıyla tamamlanmıştır.', 'dernek-tema' ) 
        : __( 'Bağış işleminiz tamamlanamadı. Lütfen bilgilerinizi kontrol edip tekrar deneyiniz.', 'dernek-tema' )
] );

ob_start();
?>
<main id="main" class="site-main">
    <?php
    ob_start();
    ?>
    <div class="max-w-2xl mx-auto font-sans">
        
        <?php if ( $is_success ) : 
            $donor_name  = $order_data['donorName'] ?? '';
            $donor_phone = $order_data['donorPhone'] ?? '';
            $total_amount = $order_data['amount'] ?? 0.0;
            $items        = $order_data['rows'] ?? [];
            
            ob_start();
            ?>
            <!-- Icon & Headline -->
            <div class="text-center">
                <div class="w-16 h-16 bg-primary/10 text-primary rounded-pill flex items-center justify-center mx-auto mb-4 animate-scale-in">
                    <i class="ri-checkbox-circle-fill text-4xl"></i>
                </div>
                <h3 class="font-heading font-bold text-xl md:text-2xl text-secondary mb-1">
                    <?php esc_html_e( 'Teşekkür Ederiz!', 'dernek-tema' ); ?>
                </h3>
                <p class="text-sm text-text-muted">
                    <?php printf( __( 'Bağış işleminiz başarıyla tamamlandı. Makbuzunuz KADIM CRM sisteminde oluşturulmuştur.', 'dernek-tema' ) ); ?>
                </p>
            </div>

            <!-- Receipt Summary Details -->
            <div class="bg-surface-alt/20 rounded-medium border border-border/40 p-5 flex flex-col gap-4 text-sm mt-2">
                <div class="flex justify-between border-b border-border/20 pb-2">
                    <span class="text-text-muted font-semibold"><?php esc_html_e( 'Sipariş No:', 'dernek-tema' ); ?></span>
                    <span class="font-bold text-secondary font-mono"><?php echo esc_html( $order_id ); ?></span>
                </div>
                <?php if ( $donor_name ) : ?>
                    <div class="flex justify-between border-b border-border/20 pb-2">
                        <span class="text-text-muted font-semibold"><?php esc_html_e( 'Bağışçı:', 'dernek-tema' ); ?></span>
                        <span class="font-bold text-secondary"><?php echo esc_html( $donor_name ); ?></span>
                    </div>
                <?php endif; ?>
                <?php if ( $donor_phone ) : ?>
                    <div class="flex justify-between border-b border-border/20 pb-2">
                        <span class="text-text-muted font-semibold"><?php esc_html_e( 'Telefon:', 'dernek-tema' ); ?></span>
                        <span class="font-bold text-secondary"><?php echo esc_html( $donor_phone ); ?></span>
                    </div>
                <?php endif; ?>
                <div class="flex justify-between border-b border-border/20 pb-2">
                    <span class="text-text-muted font-semibold"><?php esc_html_e( 'Tarih:', 'dernek-tema' ); ?></span>
                    <span class="font-bold text-secondary"><?php echo date('d.m.Y H:i'); ?></span>
                </div>
                <div class="flex justify-between items-center pt-1">
                    <span class="font-bold text-secondary text-base"><?php esc_html_e( 'Toplam Tutar:', 'dernek-tema' ); ?></span>
                    <span class="font-black text-xl text-primary"><?php echo number_format( $total_amount, 0, ',', '.' ); ?> TL</span>
                </div>
            </div>

            <!-- Items Table List -->
            <?php if ( ! empty( $items ) ) : ?>
                <div class="mt-4">
                    <h4 class="font-bold text-sm text-secondary mb-3 uppercase tracking-wider"><?php esc_html_e( 'Bağış Detayları', 'dernek-tema' ); ?></h4>
                    <div class="flex flex-col border border-border/60 rounded-medium divide-y divide-border/40 overflow-hidden">
                        <?php foreach ( $items as $row ) : 
                            $row_amt = $row['amount'] ?? 0.0;
                            $row_qty = $row['quantity'] ?? 1;
                            $product_label = $row['product']['name'] ?? $row['product']['id'] ?? '';
                            $person_name = $row['person']['name'] ?? '';
                            ?>
                            <div class="p-4 bg-white flex flex-col sm:flex-row justify-between sm:items-center gap-3">
                                <div>
                                    <h5 class="font-bold text-xs text-secondary mb-0.5"><?php echo esc_html( $product_label ); ?></h5>
                                    <div class="flex flex-wrap items-center gap-x-2 text-[10px] text-text-muted">
                                        <span><?php printf( __( 'Miktar: %d Adet', 'dernek-tema' ), $row_qty ); ?></span>
                                        <?php if ( $person_name ) : ?>
                                            <span>•</span>
                                            <span class="text-primary font-bold"><?php printf( __( 'Hissedar: %s', 'dernek-tema' ), esc_html( $person_name ) ); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <span class="font-bold text-xs text-secondary sm:text-right"><?php echo number_format( $row_amt, 0, ',', '.' ); ?> TL</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Success message and CTA -->
            <div class="border-t border-border/50 pt-6 text-center flex flex-col gap-4 mt-4">
                <p class="text-xs text-text-muted leading-relaxed max-w-md mx-auto">
                    <?php esc_html_e( 'Bağışınız sayesinde yardıma muhtaç bir cana umut oldunuz. Tarafınıza SMS/E-Posta yoluyla bilgilendirme ve fotoğraf/video raporları gönderilecektir.', 'dernek-tema' ); ?>
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <?php get_template_part( 'resources/components/button', null, [
                        'variant' => 'primary',
                        'size'    => 'medium',
                        'text'    => __( 'Kataloğa Dön', 'dernek-tema' ),
                        'url'     => home_url( '/bagislar/' )
                    ] ); ?>
                    <?php get_template_part( 'resources/components/button', null, [
                        'variant' => 'outline',
                        'size'    => 'medium',
                        'text'    => __( 'Ana Sayfaya Git', 'dernek-tema' ),
                        'url'     => home_url( '/' )
                    ] ); ?>
                </div>
            </div>
            <?php
            $card_content = ob_get_clean();
            get_template_part( 'resources/components/card', null, [
                'class'   => 'p-6 md:p-8 flex flex-col gap-6 bg-white',
                'content' => $card_content,
            ] );
            ?>

        <?php else : 
            ob_start();
            ?>
            <div class="w-16 h-16 bg-danger/10 text-danger rounded-pill flex items-center justify-center mx-auto mb-4 animate-scale-in">
                <i class="ri-close-circle-fill text-4xl"></i>
            </div>
            <h3 class="font-heading font-bold text-xl md:text-2xl text-secondary mb-1">
                <?php esc_html_e( 'Ödeme Tamamlanamadı', 'dernek-tema' ); ?>
            </h3>
            <p class="text-sm text-text-muted max-w-md mx-auto">
                <?php 
                if ( $payment_result && isset( $payment_result['message'] ) && $payment_result['message'] !== '' ) {
                    echo esc_html( $payment_result['message'] );
                } else {
                    esc_html_e( 'İşlem banka tarafından onaylanmadı veya süre aşımına uğradı. Lütfen kart limitinizi ve internet alışveriş yetkisini kontrol ediniz.', 'dernek-tema' );
                }
                ?>
            </p>

            <div class="border-t border-border/50 pt-6 flex flex-col sm:flex-row gap-3 justify-center mt-2">
                <?php get_template_part( 'resources/components/button', null, [
                        'variant' => 'primary',
                        'size'    => 'medium',
                        'text'    => __( 'Ödemeyi Tekrar Dene', 'dernek-tema' ),
                        'url'     => home_url( '/odeme/' )
                    ] ); ?>
                <?php get_template_part( 'resources/components/button', null, [
                        'variant' => 'outline',
                        'size'    => 'medium',
                        'text'    => __( 'Bağış Kataloğuna Git', 'dernek-tema' ),
                        'url'     => home_url( '/bagislar/' )
                    ] ); ?>
            </div>
            <?php
            $card_content = ob_get_clean();
            get_template_part( 'resources/components/card', null, [
                'class'   => 'p-6 md:p-8 flex flex-col gap-6 text-center bg-white',
                'content' => $card_content,
            ] );
            ?>

        <?php endif; ?>

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

get_footer();
