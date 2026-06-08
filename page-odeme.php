<?php
/**
 * The template for displaying the Checkout Page (odeme)
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

// Fetch the cart snapshot from the WordPress Bridge
$cart_snapshot = apply_filters( 'peta_cart_snapshot', null, [
    'redirect_url' => home_url( '/odeme/' )
] );

// 1. If Cart is Empty, render a clean empty state
if ( empty( $cart_snapshot['items'] ) ) :
    ob_start();
    ?>
    <main id="main" class="site-main">
        <?php
        ob_start();
        
        ob_start();
        ?>
        <div class="w-16 h-16 bg-primary/10 text-primary rounded-pill flex items-center justify-center mx-auto mb-4">
            <i class="ri-shopping-cart-2-line text-3xl"></i>
        </div>
        <h3 class="font-heading font-bold text-xl text-secondary mb-2">
            <?php esc_html_e( 'Sepetiniz Boş', 'dernek-tema' ); ?>
        </h3>
        <p class="text-sm text-text-muted mb-6">
            <?php esc_html_e( 'Henüz herhangi bir bağış kalemi eklemediniz. Bağış kataloğumuzdan dilediğiniz yardım fonuna destek olabilirsiniz.', 'dernek-tema' ); ?>
        </p>
        <?php get_template_part( 'resources/components/button', null, [
            'variant' => 'primary',
            'size'    => 'medium',
            'text'    => __( 'Bağış Kataloğuna Git', 'dernek-tema' ),
            'url'     => home_url( '/bagislar/' )
        ] ); ?>
        <?php
        $card_content = ob_get_clean();
        get_template_part( 'resources/components/card', null, [
            'class'   => 'text-center py-16 bg-white max-w-lg mx-auto p-8 font-sans',
            'content' => $card_content,
        ] );
        
        $container_content = ob_get_clean();
        get_template_part( 'resources/components/container', null, [
            'content' => $container_content,
        ] );
        ?>
    </main>
    <?php
    $section_content = ob_get_clean();
    get_template_part( 'resources/components/section', null, [
        'class'   => 'content-area flex-1',
        'spacing' => 'md',
        'content' => $section_content,
    ] );
    get_footer();
    exit;
endif;

// 2. Perform Automatic Handoff if not ready
if ( ! isset( $_GET['checkout_ready'] ) ) :
    ob_start();
    ?>
    <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary mb-4"></div>
    <h3 class="font-bold text-lg text-secondary mb-1"><?php esc_html_e( 'Güvenli Ödeme Altyapısı Hazırlanıyor', 'dernek-tema' ); ?></h3>
    <p class="text-sm text-text-muted"><?php esc_html_e( 'Lütfen bekleyin, ödeme sunucuları ile bağlantı kuruluyor...', 'dernek-tema' ); ?></p>
    
    <form id="auto-handoff-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
        <input type="hidden" name="action" value="peta_prepare_checkout_handoff">
        <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce( 'peta_prepare_checkout_handoff' ); ?>">
        <input type="hidden" name="redirect_to" value="<?php echo esc_url( add_query_arg( 'checkout_ready', '1', home_url( '/odeme/' ) ) ); ?>">
    </form>
    <script>
        document.getElementById('auto-handoff-form').submit();
    </script>
    <?php
    $container_content = ob_get_clean();
    
    ob_start();
    get_template_part( 'resources/components/container', null, [
        'class'   => 'flex flex-col items-center justify-center font-sans',
        'content' => $container_content,
    ] );
    $section_content = ob_get_clean();
    get_template_part( 'resources/components/section', null, [
        'class'      => 'content-area flex-1',
        'spacing'    => 'lg',
        'background' => 'default',
        'content'    => $section_content,
    ] );
    get_footer();
    exit;
endif;

// Render Page Hero
get_template_part( 'resources/components/page-hero', null, [
    'title'       => __( 'Güvenli Ödeme', 'dernek-tema' ),
    'description' => __( 'Bağış sepetinizi ve bilgilerinizi kontrol ederek ödeme işlemini tamamlayabilirsiniz.', 'dernek-tema' )
] );
?>

<?php
ob_start();
?>
<main id="main" class="site-main">
    <?php
    ob_start();
    ?>
    
    <!-- AJAX Loading Overlay -->
    <div id="checkout-loading-overlay" class="fixed inset-0 z-50 bg-navy-dark/60 backdrop-blur-sm flex items-center justify-center hidden font-sans text-white">
        <?php
        ob_start();
        ?>
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-white mx-auto mb-4"></div>
        <h4 class="font-bold text-base mb-1" id="loading-status-title"><?php esc_html_e( 'Bilgiler Güncelleniyor', 'dernek-tema' ); ?></h4>
        <p class="text-xs text-white/80" id="loading-status-desc"><?php esc_html_e( 'Ödeme altyapısı ile güvenli oturum senkronize ediliyor...', 'dernek-tema' ); ?></p>
        <?php
        $loading_card_content = ob_get_clean();
        get_template_part( 'resources/components/card', null, [
            'class'   => 'text-center p-8 bg-white/10 border border-white/20 backdrop-blur-md max-w-sm bg-none text-white shadow-none',
            'content' => $loading_card_content,
        ] );
        ?>
    </div>

    <form id="checkout-form" class="w-full" action="/_esas/payment-captcha.php" method="POST" target="payment-iframe">
        <!-- Hidden inputs for Gateway Payment -->
        <input type="hidden" name="paymentEndpoint" value="/_esas/payment-start.php">
        <input type="hidden" name="utmSource" value="<?php echo esc_attr( $_GET['utm_source'] ?? '' ); ?>">
        <input type="hidden" name="utmMedium" value="<?php echo esc_attr( $_GET['utm_medium'] ?? '' ); ?>">
        <input type="hidden" name="utmCampaign" value="<?php echo esc_attr( $_GET['utm_campaign'] ?? '' ); ?>">

        <!-- Card list details for JS syncing -->
        <script id="checkout-lines-json" type="application/json">
            <?php echo wp_json_encode( $cart_snapshot['checkoutLines'] ); ?>
        </script>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Forms -->
            <div class="lg:col-span-8 flex flex-col gap-6 font-sans">
                
                <!-- STEP 1: Donor Info -->
                <?php
                ob_start();
                ?>
                <h3 class="font-heading font-bold text-lg text-secondary border-b border-border/40 pb-2 mb-2 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-pill bg-primary/10 text-primary flex items-center justify-center text-xs font-bold font-sans">1</span>
                    <?php esc_html_e( 'Bağışçı Bilgileri', 'dernek-tema' ); ?>
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-secondary uppercase mb-1.5"><?php esc_html_e( 'Ad Soyad', 'dernek-tema' ); ?> *</label>
                        <?php get_template_part( 'resources/components/input', null, [
                            'name'        => 'donor_name',
                            'id'          => 'donor_name',
                            'required'    => true,
                            'placeholder' => 'Örn: Ahmet Yılmaz',
                            'input_class' => 'block w-full rounded-medium border-border px-3.5 py-2 text-sm text-secondary focus:border-primary focus:ring-primary focus:outline-none bg-surface-alt/10',
                        ] ); ?>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-secondary uppercase mb-1.5"><?php esc_html_e( 'Telefon Numarası', 'dernek-tema' ); ?> *</label>
                        <?php get_template_part( 'resources/components/input', null, [
                            'type'        => 'tel',
                            'name'        => 'donor_phone',
                            'id'          => 'donor_phone',
                            'required'    => true,
                            'placeholder' => '+90 555 111 2233',
                            'input_class' => 'block w-full rounded-medium border-border px-3.5 py-2 text-sm text-secondary focus:border-primary focus:ring-primary focus:outline-none bg-surface-alt/10',
                        ] ); ?>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-secondary uppercase mb-1.5"><?php esc_html_e( 'E-Posta Adresi', 'dernek-tema' ); ?></label>
                    <?php get_template_part( 'resources/components/input', null, [
                        'type'        => 'email',
                        'name'        => 'donor_email',
                        'id'          => 'donor_email',
                        'placeholder' => 'Örn: ahmet@mail.com',
                        'input_class' => 'block w-full rounded-medium border-border px-3.5 py-2 text-sm text-secondary focus:border-primary focus:ring-primary focus:outline-none bg-surface-alt/10',
                    ] ); ?>
                </div>
                <div>
                    <label class="block text-xs font-bold text-secondary uppercase mb-1.5"><?php esc_html_e( 'Bağışçı Notu', 'dernek-tema' ); ?></label>
                    <?php get_template_part( 'resources/components/textarea', null, [
                        'name'        => 'donor_note',
                        'id'          => 'donor_note',
                        'rows'        => 2,
                        'placeholder' => 'Eklemek istediğiniz not...',
                        'input_class' => 'block w-full rounded-medium border-border px-3.5 py-2 text-sm text-secondary focus:border-primary focus:ring-primary focus:outline-none bg-surface-alt/10',
                    ] ); ?>
                </div>
                <?php
                $donor_card_content = ob_get_clean();
                get_template_part( 'resources/components/card', null, [
                    'class'   => 'bg-white border-t-4 border-t-primary p-6 flex flex-col gap-4 shadow-sm border border-border rounded-large',
                    'content' => $donor_card_content,
                ] );
                ?>

                <!-- STEP 2: Beneficiary Details (Hisse / Niyet Sahibi) -->
                <?php 
                $has_beneficiary_lines = false;
                foreach ( $cart_snapshot['checkoutLines'] as $line ) {
                    if ( ! empty( $line['allowPersonName'] ) || ! empty( $line['allowIntentPurposeSelection'] ) ) {
                        $has_beneficiary_lines = true;
                        break;
                    }
                }
                
                if ( $has_beneficiary_lines ) :
                    ob_start();
                    ?>
                    <h3 class="font-heading font-bold text-lg text-secondary border-b border-border/40 pb-2 mb-1 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-pill bg-primary/10 text-primary flex items-center justify-center text-xs font-bold font-sans">2</span>
                        <?php esc_html_e( 'Hisse / Kişi Bilgileri', 'dernek-tema' ); ?>
                    </h3>

                    <!-- Sync donor info to all shareholders checkbox -->
                    <div class="p-3.5 bg-surface-alt/20 border border-border/40 rounded-medium font-sans -mt-2">
                        <?php
                        get_template_part( 'resources/components/checkbox', null, [
                            'id'      => 'sync_donor_to_hisse',
                            'name'    => 'sync_donor_to_hisse',
                            'checked' => true,
                            'label'   => __( 'Hissedar bilgilerini bağışçı bilgileriyle otomatik eşle', 'dernek-tema' ),
                            'class'   => 'items-center text-xs font-bold text-secondary cursor-pointer select-none',
                        ] );
                        ?>
                    </div>
                    
                    <?php foreach ( $cart_snapshot['checkoutLines'] as $line ) : 
                        if ( empty( $line['allowPersonName'] ) && empty( $line['allowIntentPurposeSelection'] ) ) {
                            continue;
                        }
                        
                        // Fetch associated cart item to display details
                        $item = null;
                        foreach ( $cart_snapshot['items'] as $cart_item ) {
                            if ( $cart_item['lineKey'] === $line['lineKey'] ) {
                                $item = $cart_item;
                                break;
                            }
                        }
                        
                        $item_title = $item ? $item['title'] : $line['productCode'];
                        ?>
                        <div class="p-4 bg-surface-alt/20 rounded-medium border border-border/40 flex flex-col gap-4" data-line-key="<?php echo esc_attr( $line['lineKey'] ); ?>">
                            <div class="flex items-center justify-between border-b border-border/20 pb-2">
                                <span class="font-bold text-sm text-secondary"><?php echo esc_html( $item_title ); ?></span>
                                <span class="text-xs font-bold text-primary px-2.5 py-0.5 bg-primary/10 rounded-pill uppercase border border-primary/20">
                                    <?php printf( __( '%d Adet/Hisse', 'dernek-tema' ), $line['quantity'] ); ?>
                                </span>
                            </div>

                            <!-- Dropdown for Intent Purpose -->
                            <?php if ( ! empty( $line['allowIntentPurposeSelection'] ) && ! empty( $line['intentPurposes'] ) ) : ?>
                                <div class="w-full">
                                    <label class="block text-xs font-bold text-secondary uppercase mb-1.5"><?php esc_html_e( 'Bağış Niyeti / Amacı', 'dernek-tema' ); ?> *</label>
                                    <?php
                                    $intent_options = [
                                        '' => __( 'Niyet Seçiniz...', 'dernek-tema' )
                                    ];
                                    foreach ( $line['intentPurposes'] as $purpose ) {
                                        $intent_options[$purpose['id']] = $purpose['name'];
                                    }
                                    get_template_part( 'resources/components/select', null, [
                                        'options'     => $intent_options,
                                        'required'    => true,
                                        'input_class' => 'intent-purpose-select block w-full rounded-medium border-border px-3.5 py-2 text-sm text-secondary focus:border-primary focus:ring-primary focus:outline-none bg-white font-semibold',
                                    ] );
                                    ?>
                                </div>
                            <?php endif; ?>

                            <!-- Beneficiary Names matching Quantity -->
                            <?php if ( ! empty( $line['allowPersonName'] ) ) : ?>
                                <div class="flex flex-col gap-4">
                                    <label class="block text-xs font-bold text-secondary uppercase -mb-2"><?php esc_html_e( 'İsim Beyanlı Hissedarlar', 'dernek-tema' ); ?> *</label>
                                    
                                    <?php for ( $i = 0; $i < $line['quantity']; $i++ ) : ?>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 p-3 bg-white rounded-medium border border-border/20 beneficiary-row" data-index="<?php echo $i; ?>">
                                            <div>
                                                <label class="block text-[10px] font-bold text-text-muted uppercase mb-1">
                                                    <?php printf( __( '%d. Hissedar Ad Soyad', 'dernek-tema' ), $i + 1 ); ?>
                                                </label>
                                                <?php get_template_part( 'resources/components/input', null, [
                                                    'required'    => true,
                                                    'placeholder' => 'Örn: Mustafa Öztürk',
                                                    'input_class' => 'beneficiary-name-input block w-full rounded-medium border-border px-3 py-1.5 text-xs text-secondary focus:border-primary focus:ring-primary focus:outline-none bg-surface-alt/10',
                                                ] ); ?>
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold text-text-muted uppercase mb-1">
                                                    <?php printf( __( '%d. Hissedar Telefonu', 'dernek-tema' ), $i + 1 ); ?>
                                                </label>
                                                <?php get_template_part( 'resources/components/input', null, [
                                                    'type'        => 'tel',
                                                    'required'    => true,
                                                    'placeholder' => 'Örn: +90 555 222 3344',
                                                    'input_class' => 'beneficiary-phone-input block w-full rounded-medium border-border px-3 py-1.5 text-xs text-secondary focus:border-primary focus:ring-primary focus:outline-none bg-surface-alt/10',
                                                ] ); ?>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    <?php
                    $beneficiary_card_content = ob_get_clean();
                    get_template_part( 'resources/components/card', null, [
                        'class'   => 'bg-white border-t-4 border-t-primary p-6 flex flex-col gap-6 shadow-sm border border-border rounded-large',
                        'content' => $beneficiary_card_content,
                    ] );
                    ?>
                <?php endif; ?>
            </div>

            <!-- Right Column: Cart Summary & Payment Card details -->
            <div class="lg:col-span-4 flex flex-col gap-6 font-sans">
                
                <!-- Cart Summary Card -->
                <?php
                ob_start();
                ?>
                <h3 class="font-heading font-bold text-lg text-secondary border-b border-border/40 pb-2 mb-2">
                    <?php esc_html_e( 'Bağış Sepetiniz', 'dernek-tema' ); ?>
                </h3>
                
                <!-- Items list -->
                <div class="flex flex-col divide-y divide-border/40">
                    <?php foreach ( $cart_snapshot['items'] as $item ) : ?>
                        <div class="py-3 flex justify-between gap-4 items-center">
                            <div class="flex-1">
                                <h4 class="font-bold text-xs text-secondary mb-0.5"><?php echo esc_html( $item['title'] ); ?></h4>
                                <div class="flex flex-wrap items-center gap-2 mt-1">
                                    <!-- Dynamic Quantity Selector -->
                                    <?php get_template_part( 'resources/components/quantity-selector', null, [
                                        'value'        => $item['quantity'],
                                        'line_key'     => $item['lineKey'],
                                        'button_class' => 'checkout-qty-btn',
                                        'class'        => '-ml-0.5 scale-90 origin-left',
                                    ] ); ?>
                                    <span class="text-[10px] text-text-muted select-none">
                                        <?php echo esc_html( $item['unitLabel'] ); ?> &times; <?php echo number_format( $item['unitAmount'], 0, ',', '.' ); ?> TL
                                    </span>
                                </div>
                            </div>
                            <div class="text-right flex flex-col items-end gap-1.5 justify-center">
                                <span class="font-bold text-xs text-primary"><?php echo number_format( $item['lineTotal'], 0, ',', '.' ); ?> TL</span>
                                
                                <!-- Remove button (AJAX triggered, no nested forms) -->
                                <button type="button" class="checkout-item-remove text-[10px] text-danger hover:underline font-bold transition-all focus:outline-none cursor-pointer" data-line-key="<?php echo esc_attr( $item['lineKey'] ); ?>">
                                    <i class="ri-delete-bin-line"></i> <?php esc_html_e( 'Kaldır', 'dernek-tema' ); ?>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Summary footer -->
                <div class="border-t border-border/80 pt-4 flex flex-col gap-3">
                    <div class="flex justify-between items-center py-1">
                        <span class="font-black text-xs text-secondary uppercase tracking-wider"><?php esc_html_e( 'Toplam Tutar', 'dernek-tema' ); ?></span>
                        <span class="font-black text-2xl text-primary tracking-tight"><?php echo number_format( $cart_snapshot['totalAmount'], 0, ',', '.' ); ?> TL</span>
                    </div>
                </div>
                <?php
                $summary_card_content = ob_get_clean();
                get_template_part( 'resources/components/card', null, [
                    'class'   => 'bg-white border-t-4 border-t-primary p-6 flex flex-col gap-4 shadow-sm border border-border rounded-large',
                    'content' => $summary_card_content,
                ] );
                ?>

                <!-- STEP 3: Payment Card details Card -->
                <?php
                ob_start();
                ?>
                <h3 class="font-heading font-bold text-lg text-secondary border-b border-border/40 pb-2 mb-2 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-pill bg-primary/10 text-primary flex items-center justify-center text-xs font-bold font-sans">
                        <?php echo $has_beneficiary_lines ? '3' : '2'; ?>
                    </span>
                    <?php esc_html_e( 'Kart Bilgileri', 'dernek-tema' ); ?>
                </h3>
                <div>
                    <label class="block text-xs font-bold text-secondary uppercase mb-1.5"><?php esc_html_e( 'Kart Sahibi', 'dernek-tema' ); ?> *</label>
                    <?php get_template_part( 'resources/components/input', null, [
                        'name'        => 'card_holder',
                        'id'          => 'card_holder',
                        'required'    => true,
                        'placeholder' => 'Kart Üzerindeki İsim',
                        'input_class' => 'block w-full rounded-medium border-border px-3.5 py-2 text-sm text-secondary focus:border-primary focus:ring-primary focus:outline-none bg-surface-alt/10',
                    ] ); ?>
                </div>
                <div>
                    <label class="block text-xs font-bold text-secondary uppercase mb-1.5"><?php esc_html_e( 'Kart Numarası', 'dernek-tema' ); ?> *</label>
                    <div class="relative">
                        <?php get_template_part( 'resources/components/input', null, [
                            'name'        => 'card_number',
                            'id'          => 'card_number',
                            'required'    => true,
                            'placeholder' => '0000 0000 0000 0000',
                            'input_class' => 'block w-full rounded-medium border-border pl-3.5 pr-10 py-2 text-sm text-secondary focus:border-primary focus:ring-primary focus:outline-none bg-surface-alt/10 font-mono',
                        ] ); ?>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-text-muted">
                            <i class="ri-credit-card-line text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-2">
                    <div>
                        <label class="block text-xs font-bold text-secondary uppercase mb-1.5"><?php esc_html_e( 'Son Kullanma', 'dernek-tema' ); ?> *</label>
                        <?php get_template_part( 'resources/components/input', null, [
                            'name'        => 'card_expiry',
                            'id'          => 'card_expiry',
                            'required'    => true,
                            'placeholder' => 'AA/YY',
                            'input_class' => 'block w-full rounded-medium border-border px-3.5 py-2 text-sm text-secondary focus:border-primary focus:ring-primary focus:outline-none bg-surface-alt/10 font-mono',
                        ] ); ?>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-secondary uppercase mb-1.5"><?php esc_html_e( 'CVC / CVV', 'dernek-tema' ); ?> *</label>
                        <?php get_template_part( 'resources/components/input', null, [
                            'name'        => 'card_cvv',
                            'id'          => 'card_cvv',
                            'required'    => true,
                            'placeholder' => '123',
                            'input_class' => 'block w-full rounded-medium border-border px-3.5 py-2 text-sm text-secondary focus:border-primary focus:ring-primary focus:outline-none bg-surface-alt/10 font-mono',
                        ] ); ?>
                    </div>
                </div>

                <!-- Action Submit Button -->
                <?php
                get_template_part( 'resources/components/button', null, [
                    'type'       => 'button',
                    'variant'    => 'primary',
                    'class'      => 'w-full gap-2 justify-center flex items-center shadow-sm py-3.5 mt-2 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 cursor-pointer',
                    'text'       => '<i class="ri-lock-fill"></i> ' . esc_html__( 'Güvenli Bağış Yap', 'dernek-tema' ),
                    'attributes' => 'id="submit-checkout-btn"',
                    'escape'     => false,
                ] );
                ?>

                <div class="flex flex-col gap-3 items-center text-center text-[10px] text-text-muted mt-2 border-t border-border/40 pt-4">
                    <div class="flex items-center gap-1 text-primary font-bold">
                        <i class="ri-shield-check-fill text-xs"></i>
                        <?php esc_html_e( '256-bit SSL Güvenli Bağlantı', 'dernek-tema' ); ?>
                    </div>
                    <p><?php esc_html_e( 'Kart bilgileriniz hiçbir şekilde sunucularımızda saklanmaz. Banka altyapısı üzerinden 3D Secure güvencesiyle işlem yapılır.', 'dernek-tema' ); ?></p>
                    <div class="flex gap-3 justify-center text-lg text-secondary opacity-60 mt-1">
                        <i class="ri-visa-line"></i>
                        <i class="ri-mastercard-line"></i>
                        <i class="ri-secure-payment-line"></i>
                    </div>
                </div>
                <?php
                $payment_card_content = ob_get_clean();
                get_template_part( 'resources/components/card', null, [
                    'class'   => 'bg-white border-t-4 border-t-primary p-6 flex flex-col gap-4 shadow-sm border border-border rounded-large',
                    'content' => $payment_card_content,
                ] );
                ?>

            </div>
        </div>
    </form>
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

<!-- Modal Dialog with Iframe for Payment Flow (Cloudflare Turnstile & MPI Iframe) -->
<div id="payment-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-navy-dark/60 backdrop-blur-sm hidden font-sans">
    <?php
    ob_start();
    ?>
    <div class="px-6 py-4 border-b border-border flex justify-between items-center bg-surface-alt/10">
        <h3 id="payment-modal-title" class="font-heading font-bold text-base text-secondary flex items-center gap-2">
            <i class="ri-shield-keyhole-line text-primary"></i>
            <span id="modal-title-text"><?php esc_html_e( 'Güvenlik Doğrulaması', 'dernek-tema' ); ?></span>
        </h3>
        <button id="close-payment-modal" class="text-text-muted hover:text-primary transition-colors focus:outline-none">
            <i class="ri-close-line text-2xl"></i>
        </button>
    </div>
    <div class="flex-1 bg-white relative">
        <iframe name="payment-iframe" id="payment-iframe" class="w-full h-full border-0"></iframe>
    </div>
    <?php
    $modal_card_content = ob_get_clean();
    get_template_part( 'resources/components/card', null, [
        'class'   => 'bg-white rounded-large shadow-xl max-w-lg w-full overflow-hidden flex flex-col h-[500px]',
        'content' => $modal_card_content,
    ] );
    ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Spacing and mask triggers for Card details
    const cardNumberInput = document.getElementById('card_number');
    const cardExpiryInput = document.getElementById('card_expiry');
    const cardCvvInput    = document.getElementById('card_cvv');

    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function(e) {
            let val = e.target.value.replace(/\D/g, '');
            let masked = '';
            for (let i = 0; i < val.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    masked += ' ';
                }
                masked += val[i];
            }
            e.target.value = masked.substring(0, 19);
        });
    }

    if (cardExpiryInput) {
        cardExpiryInput.addEventListener('input', function(e) {
            let val = e.target.value.replace(/\D/g, '');
            if (val.length >= 2) {
                e.target.value = val.substring(0, 2) + '/' + val.substring(2, 4);
            } else {
                e.target.value = val;
            }
        });
    }

    if (cardCvvInput) {
        cardCvvInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4);
        });
    }

    // 2. Initialize intl-tel-input on Phone Fields with dynamic masking/validation
    const phoneItis = new Map();
    const donorPhoneInput = document.getElementById('donor_phone');
    const beneficiaryPhones = document.querySelectorAll('.beneficiary-phone-input');

    function initPhoneInput(input) {
        if (!input || phoneItis.has(input) || typeof window.intlTelInput === 'undefined') return;

        const iti = window.intlTelInput(input, {
            initialCountry: "tr",
            preferredCountries: ["tr", "us", "de", "gb"],
            nationalMode: false,
            autoPlaceholder: "aggressive",
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/utils.js"
        });

        phoneItis.set(input, iti);

        // Dynamic mask based on country placeholder format & automatically add country code
        input.addEventListener('input', function() {
            input.setCustomValidity(""); // Reset validity on type
            let cursor = input.selectionStart;
            let originalLen = input.value.length;
            let val = input.value;
            
            if (!val.startsWith('+')) {
                let digits = val.replace(/\D/g, '');
                val = digits ? '+' + digits : '';
            }
            
            let digits = val.replace(/\D/g, '');
            if (typeof intlTelInputUtils !== 'undefined' && digits.length > 0) {
                let formatted = intlTelInputUtils.formatNumber('+' + digits, iti.getSelectedCountryData().iso2, intlTelInputUtils.numberFormat.INTERNATIONAL);
                if (formatted) {
                    input.value = formatted;
                    let newLen = formatted.length;
                    input.setSelectionRange(cursor + (newLen - originalLen), cursor + (newLen - originalLen));
                }
            }
        });

        input.addEventListener('focus', function() {
            if (input.value.trim() === '') {
                const dial = '+' + iti.getSelectedCountryData().dialCode;
                input.value = dial + ' ';
            }
        });

        input.addEventListener('blur', function() {
            const dial = '+' + iti.getSelectedCountryData().dialCode;
            if (input.value.trim() === dial || input.value.trim() === '+' || input.value.trim() === '') {
                input.value = '';
            }
        });

        input.addEventListener('countrychange', function() {
            const dial = '+' + iti.getSelectedCountryData().dialCode;
            input.value = dial + ' ';
            input.setCustomValidity("");
        });
    }

    if (donorPhoneInput) {
        initPhoneInput(donorPhoneInput);
    }
    beneficiaryPhones.forEach(initPhoneInput);

    // 3. Donor-to-Shareholder Auto Handoff Sync Logic
    const syncCheckbox = document.getElementById('sync_donor_to_hisse');
    const donorNameInput = document.getElementById('donor_name');
    const hasShareholderRows = document.querySelector('.beneficiary-row') !== null;

    function applySync() {
        if (!syncCheckbox || !syncCheckbox.checked) return;

        const shareholderRows = document.querySelectorAll('.beneficiary-row');
        shareholderRows.forEach(row => {
            const nameInput = row.querySelector('.beneficiary-name-input');
            const phoneInput = row.querySelector('.beneficiary-phone-input');

            // Mirror Name
            if (donorNameInput && nameInput) {
                nameInput.value = donorNameInput.value.trim();
                nameInput.readOnly = true;
                nameInput.classList.add('bg-surface-alt/10');
                nameInput.setCustomValidity("");
            }

            // Mirror Phone and Country Flag
            if (donorPhoneInput && phoneInput) {
                const donorIti = phoneItis.get(donorPhoneInput);
                const bIti = phoneItis.get(phoneInput);
                if (donorIti && bIti) {
                    const country = donorIti.getSelectedCountryData().iso2;
                    bIti.setCountry(country);
                    phoneInput.value = donorPhoneInput.value;
                } else {
                    phoneInput.value = donorPhoneInput.value;
                }
                phoneInput.readOnly = true;
                phoneInput.classList.add('bg-surface-alt/10');
                phoneInput.setCustomValidity("");
            }
        });
    }

    function disableSync() {
        const shareholderRows = document.querySelectorAll('.beneficiary-row');
        shareholderRows.forEach(row => {
            const nameInput = row.querySelector('.beneficiary-name-input');
            const phoneInput = row.querySelector('.beneficiary-phone-input');
            
            if (nameInput) {
                nameInput.readOnly = false;
                nameInput.classList.remove('bg-surface-alt/10');
            }
            if (phoneInput) {
                phoneInput.readOnly = false;
                phoneInput.classList.remove('bg-surface-alt/10');
            }
        });
    }

    if (syncCheckbox && hasShareholderRows) {
        syncCheckbox.addEventListener('change', function() {
            if (this.checked) {
                applySync();
            } else {
                disableSync();
            }
        });

        // Mirror changes in real time
        if (donorNameInput) {
            donorNameInput.addEventListener('input', applySync);
        }
        if (donorPhoneInput) {
            donorPhoneInput.addEventListener('input', applySync);
            donorPhoneInput.addEventListener('countrychange', applySync);
        }

        // Run initial sync check
        applySync();
    }

    // 4. Checkout Submission AJAX Sequence with custom HTML5 validations
    const submitBtn = document.getElementById('submit-checkout-btn');
    const overlay   = document.getElementById('checkout-loading-overlay');
    const statusTitle = document.getElementById('loading-status-title');
    const statusDesc  = document.getElementById('loading-status-desc');
    const modal     = document.getElementById('payment-modal');
    const iframe    = document.getElementById('payment-iframe');
    const checkoutForm = document.getElementById('checkout-form');

    const setStatus = (title, desc) => {
        if (statusTitle) statusTitle.textContent = title;
        if (statusDesc) statusDesc.textContent = desc;
    };

    if (checkoutForm) {
        // Clear custom validity messages when user edits fields
        checkoutForm.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('input', function() {
                input.setCustomValidity("");
            });
            input.addEventListener('change', function() {
                input.setCustomValidity("");
            });
        });
    }

    if (submitBtn && checkoutForm) {
        submitBtn.addEventListener('click', async function(e) {
            e.preventDefault();

            // Run custom intl-tel-input validations
            if (donorPhoneInput) {
                const donorIti = phoneItis.get(donorPhoneInput);
                if (donorIti) {
                    if (!donorIti.isValidNumber()) {
                        donorPhoneInput.setCustomValidity("Lütfen geçerli bir telefon numarası giriniz.");
                    } else {
                        donorPhoneInput.setCustomValidity("");
                    }
                }
            }

            document.querySelectorAll('.beneficiary-phone-input').forEach(bPhone => {
                const bIti = phoneItis.get(bPhone);
                if (bIti) {
                    if (!bIti.isValidNumber()) {
                        bPhone.setCustomValidity("Lütfen geçerli bir hissedar telefon numarası giriniz.");
                    } else {
                        bPhone.setCustomValidity("");
                    }
                }
            });

            // Run Credit Card checks
            const rawCardNum = cardNumberInput.value.replace(/\s/g, '');
            if (rawCardNum.length < 15) {
                cardNumberInput.setCustomValidity("Lütfen geçerli bir kart numarası girin.");
            } else {
                cardNumberInput.setCustomValidity("");
            }

            const expiryVal = cardExpiryInput.value;
            if (expiryVal.length < 5 || !expiryVal.includes('/')) {
                cardExpiryInput.setCustomValidity("Lütfen geçerli bir son kullanma tarihi girin (AA/YY).");
            } else {
                cardExpiryInput.setCustomValidity("");
            }

            if (cardCvvInput.value.length < 3) {
                cardCvvInput.setCustomValidity("Lütfen geçerli bir CV2 kodu girin.");
            } else {
                cardCvvInput.setCustomValidity("");
            }

            // Apply validation styling
            checkoutForm.classList.add('was-validated');

            // Run native HTML5 check (will focus/bubble on first invalid element)
            if (!checkoutForm.reportValidity()) {
                return;
            }

            // Show Loading
            overlay.classList.remove('hidden');
            setStatus('Bilgiler Gönderiliyor', 'Bağışçı bilgileri ödeme sepeti ile eşleştiriliyor...');

            try {
                // Fetch donor and card values
                const donorName  = document.getElementById('donor_name').value.trim();
                const donorIti = phoneItis.get(donorPhoneInput);
                const donorPhone = donorIti ? donorIti.getNumber() : donorPhoneInput.value.trim();
                const donorEmail = document.getElementById('donor_email').value.trim();
                const donorNote  = document.getElementById('donor_note').value.trim();

                const cardHolderName = document.getElementById('card_holder').value.trim();
                const cardExpiry     = expiryVal;
                const cardCvv        = cardCvvInput.value.trim();

                // 2.1 API Call: Update Donor Details in Gateway Basket
                let response = await fetch('/_esas/basket.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        action: 'updateDonor',
                        name: donorName,
                        phone: donorPhone,
                        note: donorNote + (donorEmail ? ' [E-Posta: ' + donorEmail + ']' : '')
                    })
                });
                if (!response.ok) throw new Error('Donor güncellemesi başarısız.');

                // 2.2 API Call: Update Credit Card Details in Gateway Basket
                setStatus('Güvenli Oturum Hazırlanıyor', 'Kart bilgileri banka yönlendirmesi için cache\'leniyor...');
                response = await fetch('/_esas/basket.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        action: 'updateCard',
                        holderName: cardHolderName,
                        number: rawCardNum,
                        expiry: cardExpiry,
                        cvv: cardCvv
                    })
                });
                if (!response.ok) throw new Error('Kart güncellemesi başarısız.');

                // 2.3 API Call: Sync each line item's Person names and Intent purposes
                setStatus('Kişi Bilgileri Eşleniyor', 'Kurban hisseleri ve isim beyanları entegre ediliyor...');
                
                // Read the lines definition
                const lines = JSON.parse(document.getElementById('checkout-lines-json').textContent);
                
                for (const line of lines) {
                    const lineContainer = document.querySelector('[data-line-key="' + line.lineKey + '"]');
                    let intentPurposeId = null;
                    const rows = [];

                    if (lineContainer) {
                        const purposeSelect = lineContainer.querySelector('.intent-purpose-select');
                        if (purposeSelect) {
                            intentPurposeId = purposeSelect.value;
                        }
                    }

                    if (line.allowPersonName && lineContainer) {
                        const rowEls = lineContainer.querySelectorAll('.beneficiary-row');
                        rowEls.forEach(function(row) {
                            const nameInput = row.querySelector('.beneficiary-name-input');
                            const phoneInput = row.querySelector('.beneficiary-phone-input');
                            const nameVal = nameInput ? nameInput.value.trim() : '';
                            const bIti = phoneItis.get(phoneInput);
                            const phoneVal = bIti ? bIti.getNumber() : (phoneInput ? phoneInput.value.trim() : '');
                            
                            rows.push({
                                productId: line.productId,
                                parentCategoryId: line.parentCategoryId,
                                rootCategoryId: line.rootCategoryId,
                                quantity: 1,
                                amount: line.unitAmount,
                                personName: nameVal,
                                personPhone: phoneVal,
                                countryId: line.countryId,
                                intentVariantId: line.intentVariantId,
                                intentPurposeId: intentPurposeId
                            });
                        });
                    } else {
                        rows.push({
                            productId: line.productId,
                            parentCategoryId: line.parentCategoryId,
                            rootCategoryId: line.rootCategoryId,
                            quantity: line.quantity,
                            amount: line.unitAmount * line.quantity,
                            personName: '',
                            personPhone: '',
                            countryId: line.countryId,
                            intentVariantId: line.intentVariantId,
                            intentPurposeId: intentPurposeId
                        });
                    }

                    // Send syncCard payload
                    response = await fetch('/_esas/basket.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            action: 'syncCard',
                            cardKey: line.lineKey,
                            rows: rows
                        })
                    });
                    if (!response.ok) throw new Error('Line sync işlemi başarısız oldu.');
                }

                // 3. Open Payment Modal & Submit hidden Form to the iframe target
                setStatus('Bağlanıyor', 'Güvenlik doğrulaması sayfasına geçiliyor...');
                
                // Show modal, hide overlay
                modal.classList.remove('hidden');
                overlay.classList.add('hidden');

                // Build hidden inputs for inputs and submit to target iframe
                // Add Card details as hidden inputs so payment-start can read them in POST if required
                // Note: payment-start.php reads card details directly from Redis cache we set in step 2.2,
                // but we pass them along in the captcha form fields just in case.
                const hiddenCardHolder = document.createElement('input');
                hiddenCardHolder.type = 'hidden';
                hiddenCardHolder.name = 'cardHolderName';
                hiddenCardHolder.value = cardHolderName;
                checkoutForm.appendChild(hiddenCardHolder);

                const hiddenCardNumber = document.createElement('input');
                hiddenCardNumber.type = 'hidden';
                hiddenCardNumber.name = 'cardNumber';
                hiddenCardNumber.value = rawCardNum;
                checkoutForm.appendChild(hiddenCardNumber);

                const hiddenCardExpiry = document.createElement('input');
                hiddenCardExpiry.type = 'hidden';
                hiddenCardExpiry.name = 'cardExpiry';
                hiddenCardExpiry.value = cardExpiry;
                checkoutForm.appendChild(hiddenCardExpiry);

                const hiddenCardCvv = document.createElement('input');
                hiddenCardCvv.type = 'hidden';
                hiddenCardCvv.name = 'cardCvv';
                hiddenCardCvv.value = cardCvv;
                checkoutForm.appendChild(hiddenCardCvv);

                checkoutForm.submit();

            } catch (err) {
                console.error(err);
                overlay.classList.add('hidden');
                alert('Sistem Hatası: ' + err.message);
            }
        });
    }

    // 4. Listen to postMessage event callbacks from MPI/Gateway callback Page
    window.addEventListener('message', async function(event) {
        const data = event.data;
        if (!data) return;

        // Step updates (title updates)
        if (data.type === 'payment_step') {
            const titleText = document.getElementById('modal-title-text');
            if (titleText) {
                if (data.step === 'captcha') {
                    titleText.textContent = 'Güvenlik Doğrulaması';
                } else if (data.step === '3d_secure') {
                    titleText.textContent = '3D Secure Banka Onayı';
                }
            }
        }

        // Processing completed
        if (data.type === 'payment_result') {
            if (data.status === 'success') {
                overlay.classList.remove('hidden');
                setStatus('Bağış Başarılı', 'Bağış sepetiniz temizleniyor ve fişiniz hazırlanıyor...');

                try {
                    // Clear the local WordPress cart session
                    await fetch('/wp-json/hiyad/v1/cart', { method: 'DELETE' });
                } catch (e) {
                    console.error('Local cart clear failed: ', e);
                }

                // Redirect to receipt
                window.location.href = '/tesekkur/?order_id=' + encodeURIComponent(data.orderId);
            } else {
                // Payment failed, close modal
                modal.classList.add('hidden');
                iframe.src = 'about:blank';
                alert('Bağış İşlemi Başarısız: ' + (data.message || 'İşlem tamamlanamadı.'));
            }
        }
    });

    // Close modal handlers
    const closeModalBtn = document.getElementById('close-payment-modal');
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function() {
            if (confirm('Ödeme sayfasını kapatmak işlemi iptal edecektir. Emin misiniz?')) {
                modal.classList.add('hidden');
                iframe.src = 'about:blank';
            }
        });
    }

    // 5. Handle Sidebar Cart Item Removal via AJAX (fixes nested form validation bug)
    document.querySelectorAll('.checkout-item-remove').forEach(btn => {
        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();
            const lineKey = this.getAttribute('data-line-key');
            if (!lineKey) return;

            if (confirm('Bu bağış kalemini sepetinizden kaldırmak istediğinize emin misiniz?')) {
                overlay.classList.remove('hidden');
                setStatus('Kaldırılıyor', 'Seçilen bağış sepetinizden kaldırılıyor...');
                try {
                    const response = await fetch(`/wp-json/hiyad/v1/cart/items/${lineKey}`, {
                        method: 'DELETE',
                        headers: { 'Content-Type': 'application/json' }
                    });
                    if (response.ok) {
                        window.location.reload();
                    } else {
                        overlay.classList.add('hidden');
                        alert('Bağış kaldırılırken bir hata oluştu.');
                    }
                } catch (err) {
                    console.error(err);
                    overlay.classList.add('hidden');
                    alert('Bağlantı hatası.');
                }
            }
        });
    });

    // 6. Handle Sidebar Cart Item Quantity Updates (+/-) via AJAX
    document.querySelectorAll('.checkout-qty-btn').forEach(btn => {
        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();
            const lineKey = this.getAttribute('data-line-key');
            const action = this.getAttribute('data-action');
            if (!lineKey) return;

            const qtyTextEl = document.getElementById(`qty-text-${lineKey}`);
            if (!qtyTextEl) return;

            let currentQty = parseInt(qtyTextEl.textContent.trim()) || 1;
            let newQty = currentQty;

            if (action === 'increase') {
                newQty = currentQty + 1;
            } else if (action === 'decrease') {
                newQty = currentQty - 1;
            }

            if (newQty <= 0) {
                // Trigger removal check
                const removeBtn = document.querySelector(`.checkout-item-remove[data-line-key="${lineKey}"]`);
                if (removeBtn) removeBtn.click();
                return;
            }

            overlay.classList.remove('hidden');
            setStatus('Miktar Güncelleniyor', 'Hisse/adet bilgisi sepetinizle senkronize ediliyor...');

            try {
                // Post to custom admin-ajax route to update item quantity
                const formData = new FormData();
                formData.append('action', 'peta_update_quantity');
                formData.append('line_key', lineKey);
                formData.append('quantity', newQty);

                const response = await fetch('/wp-admin/admin-ajax.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                if (response.ok && result.success) {
                    window.location.reload();
                } else {
                    overlay.classList.add('hidden');
                    alert(result.data?.message || 'Miktar güncellenirken bir hata oluştu.');
                }
            } catch (err) {
                console.error(err);
                overlay.classList.add('hidden');
                alert('Bağlantı hatası.');
            }
        });
    });
});
</script>

<?php
get_footer();
