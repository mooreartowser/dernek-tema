<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Remix Icon CDN for premium icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- International Tel Input CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/js/intlTelInput.min.js"></script>
    <style>
        .iti { width: 100% !important; }
        .iti__country-list { z-index: 9999 !important; }
    </style>

    <?php 
    // GSC Meta Tag Verification
    $tracking_gsc = get_field( 'tracking_gsc', 'option' );
    if ( $tracking_gsc ) {
        echo $tracking_gsc . "\n";
    }
    
    // GA Tracking Code
    $tracking_ga = get_field( 'tracking_ga', 'option' );
    if ( $tracking_ga ) {
        echo $tracking_ga . "\n";
    }

    // GTM Tracking Code (Head Part)
    $tracking_gtm = get_field( 'tracking_gtm', 'option' );
    if ( $tracking_gtm ) {
        if ( strpos( $tracking_gtm, '<script' ) !== false ) {
            echo $tracking_gtm . "\n";
        } else {
            echo '<script>' . $tracking_gtm . '</script>' . "\n";
        }
    }
    ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-background text-text font-sans antialiased min-h-screen flex flex-col' ); ?>>
<?php 
wp_body_open(); 
$cart_snapshot = apply_filters( 'peta_cart_snapshot', null );
$is_logged_in  = isset( $_COOKIE['endUserToken'] ) && ! empty( $_COOKIE['endUserToken'] );
?>

<!-- Top bar -->
<div class="bg-navy-dark text-white text-xs border-b border-white/10 py-2.5">
    <div class="max-w-container-default mx-auto px-container-px flex justify-between items-center">
        <div class="flex items-center gap-6">
            <?php 
            $phone = get_field( 'contact_phone', 'option' );
            $email = get_field( 'contact_email', 'option' );
            if ( $phone ) : ?>
                <a href="tel:<?php echo esc_attr( str_replace(' ', '', $phone) ); ?>" class="hover:text-primary transition-colors flex items-center gap-1.5">
                    <i class="ri-phone-fill text-primary text-sm"></i> <?php echo esc_html( $phone ); ?>
                </a>
            <?php endif; ?>
            <?php if ( $email ) : ?>
                <a href="mailto:<?php echo esc_attr( $email ); ?>" class="hover:text-primary transition-colors flex items-center gap-1.5">
                    <i class="ri-mail-fill text-primary text-sm"></i> <?php echo esc_html( $email ); ?>
                </a>
            <?php endif; ?>
        </div>
        <div class="flex items-center gap-4">
            <?php 
            $social_links = get_field( 'social_links', 'option' );
            if ( is_array( $social_links ) ) :
                foreach ( $social_links as $link ) :
                    $platform = $link['platform'];
                    $url = $link['url'];
                    $icon_class = 'ri-share-line';
                    if ( $platform === 'facebook' ) $icon_class = 'ri-facebook-fill';
                    elseif ( $platform === 'instagram' ) $icon_class = 'ri-instagram-line';
                    elseif ( $platform === 'x' ) $icon_class = 'ri-twitter-x-fill';
                    elseif ( $platform === 'youtube' ) $icon_class = 'ri-youtube-fill';
                    elseif ( $platform === 'linkedin' ) $icon_class = 'ri-linkedin-fill';
                    elseif ( $platform === 'tiktok' ) $icon_class = 'ri-tiktok-fill';
                    ?>
                    <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-primary transition-colors text-sm">
                        <i class="<?php echo esc_attr( $icon_class ); ?>"></i>
                    </a>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</div>

<!-- Header -->
<header class="bg-white border-b border-border py-4 sticky top-0 z-50 shadow-sm">
    <div class="max-w-container-default mx-auto px-container-px flex justify-between items-center">
        <!-- Logo -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2.5 group">
            <?php 
            $logo = get_field( 'site_logo', 'option' );
            $company_name = get_field( 'company_name', 'option' );
            if ( $logo ) : ?>
                <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr( $company_name ? $company_name : get_bloginfo( 'name' ) ); ?>" class="h-10 w-auto object-contain">
            <?php else : ?>
                <span class="font-heading font-bold text-2xl text-secondary group-hover:text-primary transition-colors leading-tight">
                    <?php echo esc_html( $company_name ? $company_name : get_bloginfo( 'name' ) ); ?>
                </span>
            <?php endif; ?>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden lg:flex items-center gap-8">
            <?php 
            wp_nav_menu( [
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'flex gap-6 items-center text-sm font-semibold text-text',
                'fallback_cb'    => '__return_false',
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            ] );
            ?>
        </nav>

        <!-- Header Actions: User, Cart, Donate CTA -->
        <div class="flex items-center gap-3.5 md:gap-4 z-50">
            <!-- User Profile / Login -->
            <div class="relative" id="header-user-menu">
                <?php if ( $is_logged_in ) : ?>
                    <!-- Logged In: Profile Icon and Dropdown -->
                    <button id="user-menu-trigger" class="w-10 h-10 rounded-pill border border-border/80 hover:border-primary/40 flex items-center justify-center text-secondary hover:text-primary transition-all bg-white relative cursor-pointer" aria-label="Profil Menüsü">
                        <i class="ri-user-fill text-lg"></i>
                    </button>
                    <!-- User Dropdown Menu -->
                    <div id="user-dropdown" class="absolute right-0 mt-2.5 w-48 bg-white border border-border/60 rounded-medium shadow-lg py-2 hidden opacity-0 scale-95 origin-top-right transition-all duration-200 z-50">
                        <a href="<?php echo esc_url( home_url( '/hesabim/' ) ); ?>" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-text hover:bg-surface-alt hover:text-primary transition-colors">
                            <i class="ri-dashboard-3-line text-sm"></i> <?php esc_html_e( 'Bağış Panelim', 'dernek-tema' ); ?>
                        </a>
                        <button id="header-logout-btn" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-danger hover:bg-danger/5 transition-colors text-left cursor-pointer">
                            <i class="ri-logout-box-r-line text-sm"></i> <?php esc_html_e( 'Çıkış Yap', 'dernek-tema' ); ?>
                        </button>
                    </div>
                <?php else : ?>
                    <!-- Guest: Login Button Triggering OTP Modal -->
                    <button id="login-modal-trigger" class="w-10 h-10 rounded-pill border border-border/80 hover:border-primary/40 flex items-center justify-center text-secondary hover:text-primary transition-all bg-white cursor-pointer" aria-label="Giriş Yap">
                        <i class="ri-user-line text-lg"></i>
                    </button>
                <?php endif; ?>
            </div>

            <!-- Cart Icon with Badge -->
            <button id="cart-drawer-trigger" class="w-10 h-10 rounded-pill border border-border/80 hover:border-primary/40 flex items-center justify-center text-secondary hover:text-primary transition-all bg-white relative cursor-pointer" aria-label="Sepetim">
                <i class="ri-shopping-basket-2-line text-lg"></i>
                <span id="cart-badge" class="<?php echo ( ! empty($cart_snapshot['lineCount']) && $cart_snapshot['lineCount'] > 0 ) ? '' : 'hidden'; ?> absolute -top-1 -right-1 bg-primary text-white text-[10px] font-black w-5 h-5 rounded-pill flex items-center justify-center shadow-sm border-2 border-white leading-none">
                    <?php echo esc_html( $cart_snapshot['lineCount'] ?? 0 ); ?>
                </span>
            </button>

            <!-- Desktop Donate CTA -->
            <?php 
            $donate_cta_title = get_field( 'header_donate_cta_title', 'option' );
            $donate_cta_url = get_field( 'header_donate_cta_url', 'option' );
            if ( $donate_cta_title && $donate_cta_url ) : ?>
                <a href="<?php echo esc_url( $donate_cta_url ); ?>" class="hidden sm:flex bg-primary hover:bg-primary-hover text-white text-sm font-bold px-5 py-2.5 rounded-medium shadow-sm transition-all duration-200 items-center gap-2">
                    <i class="ri-heart-fill"></i>
                    <?php echo esc_html( $donate_cta_title ); ?>
                </a>
            <?php endif; ?>

            <!-- Mobile Menu Trigger -->
            <button id="mobile-menu-trigger" class="lg:hidden text-text hover:text-primary transition-colors focus:outline-none p-1.5 cursor-pointer" aria-label="Menüyü Aç">
                <i class="ri-menu-3-line text-2xl"></i>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Navigation Drawer -->
<div id="mobile-navigation" class="fixed inset-0 z-40 bg-navy-dark/40 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300 lg:hidden">
    <div class="absolute right-0 top-0 bottom-0 w-80 max-w-full bg-white shadow-xl flex flex-col transform translate-x-full transition-transform duration-300">
        <!-- Close Header -->
        <div class="p-6 border-b border-border flex justify-between items-center">
            <span class="font-heading font-bold text-xl text-secondary">Menü</span>
            <button id="mobile-menu-close" class="text-text hover:text-primary transition-colors focus:outline-none" aria-label="Menüyü Kapat">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>

        <!-- Scrollable content -->
        <div class="flex-1 overflow-y-auto p-6 flex flex-col justify-between">
            <div>
                <?php 
                wp_nav_menu( [
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'flex flex-col gap-4 text-base font-semibold text-text mb-8',
                    'fallback_cb'    => '__return_false',
                ] );
                ?>
            </div>

            <!-- Mobile CTAs -->
            <div class="flex flex-col gap-4 border-t border-border pt-6">
                <?php if ( $cta_title && $cta_url ) : ?>
                    <a href="<?php echo esc_url( $cta_url ); ?>" class="text-center text-sm font-semibold text-text hover:text-primary transition-colors py-2">
                        <?php echo esc_html( $cta_title ); ?>
                    </a>
                <?php endif; ?>

                <?php if ( $donate_cta_title && $donate_cta_url ) : ?>
                    <a href="<?php echo esc_url( $donate_cta_url ); ?>" class="bg-primary hover:bg-primary-hover text-white text-center text-sm font-bold py-3 rounded-medium shadow-sm transition-all duration-200 flex items-center justify-center gap-2">
                        <i class="ri-heart-fill"></i>
                        <?php echo esc_html( $donate_cta_title ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const trigger = document.getElementById('mobile-menu-trigger');
    const close = document.getElementById('mobile-menu-close');
    const nav = document.getElementById('mobile-navigation');
    const drawer = nav ? nav.querySelector('.transform') : null;

    if (trigger && nav && drawer) {
        trigger.addEventListener('click', function() {
            nav.classList.remove('opacity-0', 'pointer-events-none');
            drawer.classList.remove('translate-x-full');
        });

        const closeMenu = function() {
            nav.classList.add('opacity-0', 'pointer-events-none');
            drawer.classList.add('translate-x-full');
        };

        close.addEventListener('click', closeMenu);
        nav.addEventListener('click', function(e) {
            if (e.target === nav) {
                closeMenu();
            }
        });
    }
});
</script>

<!-- Cart Drawer Backdrop -->
<div id="cart-drawer-backdrop" class="fixed inset-0 bg-navy-dark/40 backdrop-blur-sm z-50 opacity-0 pointer-events-none transition-all duration-300">
    <!-- Cart Drawer Content -->
    <div id="cart-drawer" class="fixed right-0 top-0 bottom-0 w-96 max-w-full bg-white shadow-2xl flex flex-col translate-x-full transition-all duration-300 ease-out z-50">
        <!-- Header -->
        <div class="p-6 border-b border-border/60 flex justify-between items-center bg-surface-alt/10">
            <div class="flex items-center gap-2">
                <i class="ri-shopping-basket-2-line text-primary text-xl"></i>
                <span class="font-heading font-black text-lg text-secondary"><?php esc_html_e( 'Bağış Sepetim', 'dernek-tema' ); ?></span>
            </div>
            <button id="cart-drawer-close" class="text-text-muted hover:text-primary transition-colors cursor-pointer" aria-label="Kapat">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>

        <!-- Cart Items List (Scrollable) -->
        <div id="cart-drawer-items" class="flex-1 overflow-y-auto p-6 space-y-4">
            <?php if ( empty( $cart_snapshot['items'] ) ) : ?>
                <!-- Empty State -->
                <div class="cart-empty-state h-full flex flex-col items-center justify-center text-center p-6 space-y-4">
                    <div class="w-16 h-16 rounded-pill bg-surface-alt/60 flex items-center justify-center text-text-muted">
                        <i class="ri-shopping-basket-2-line text-3xl"></i>
                    </div>
                    <div>
                        <h4 class="font-heading font-bold text-secondary text-base"><?php esc_html_e( 'Sepetiniz Boş', 'dernek-tema' ); ?></h4>
                        <p class="font-sans text-xs text-text-muted mt-1"><?php esc_html_e( 'Henüz sepetinize bir bağış eklemediniz.', 'dernek-tema' ); ?></p>
                    </div>
                    <a href="<?php echo esc_url( home_url( '/bagislar/' ) ); ?>" class="inline-flex bg-primary hover:bg-primary-hover text-white text-xs font-bold px-5 py-2.5 rounded-medium transition-colors">
                        <?php esc_html_e( 'Bağışları İncele', 'dernek-tema' ); ?>
                    </a>
                </div>
            <?php else : ?>
                <!-- Cart Items Grid -->
                <?php foreach ( $cart_snapshot['items'] as $item ) : ?>
                    <div class="cart-item flex items-center justify-between gap-4 p-3 bg-surface-alt/30 border border-border/40 rounded-medium transition-all" data-line-key="<?php echo esc_attr( $item['lineKey'] ); ?>">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-sans font-bold text-xs text-secondary truncate"><?php echo esc_html( $item['title'] ); ?></h4>
                            <div class="flex items-center gap-2 mt-1">
                                <?php get_template_part( 'resources/components/quantity-selector', null, [
                                    'value'        => $item['quantity'],
                                    'line_key'     => $item['lineKey'],
                                    'button_class' => 'cart-qty-btn',
                                    'class'        => 'scale-90 origin-left',
                                ] ); ?>
                                <span class="text-[10px] text-text-muted select-none">
                                    &times; <?php echo number_format( $item['unitAmount'], 0, ',', '.' ); ?> ₺
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-sans font-black text-xs text-secondary whitespace-nowrap">
                                <?php echo number_format( $item['lineTotal'], 0, ',', '.' ); ?> ₺
                            </span>
                            <button class="cart-item-remove text-text-muted hover:text-danger transition-colors cursor-pointer" data-line-key="<?php echo esc_attr( $item['lineKey'] ); ?>" aria-label="Sil">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Footer Summary & Checkout Button -->
        <div id="cart-drawer-footer" class="p-6 border-t border-border/60 bg-surface-alt/10 space-y-4 <?php echo empty( $cart_snapshot['items'] ) ? 'hidden' : ''; ?>">
            <div class="flex justify-between items-center font-sans">
                <span class="text-text-muted text-xs font-semibold"><?php esc_html_e( 'Toplam Bağış Tutarı', 'dernek-tema' ); ?></span>
                <span id="cart-drawer-total" class="text-secondary font-black text-lg"><?php echo number_format( $cart_snapshot['totalAmount'] ?? 0, 0, ',', '.' ); ?> ₺</span>
            </div>
            
            <div class="grid grid-cols-1 gap-2 pt-2">
                <a href="<?php echo esc_url( home_url( '/odeme/' ) ); ?>" class="w-full bg-primary hover:bg-primary-hover text-white text-center text-sm font-black py-3.5 rounded-medium shadow-sm transition-all duration-200 flex items-center justify-center gap-2">
                    <i class="ri-secure-payment-line text-base"></i>
                    <?php esc_html_e( 'Bağışı Tamamla', 'dernek-tema' ); ?>
                </a>
                <?php
                get_template_part( 'resources/components/button', null, [
                    'variant'    => 'outline',
                    'size'       => 'small',
                    'text'       => __( 'Sepeti Temizle', 'dernek-tema' ),
                    'class'      => 'w-full hover:bg-danger/5 text-text-muted hover:text-danger border-border cursor-pointer',
                    'attributes' => 'id="cart-drawer-clear"',
                ] );
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Login Modal Backdrop -->
<div id="login-modal-backdrop" class="fixed inset-0 bg-navy-dark/40 backdrop-blur-sm z-50 opacity-0 pointer-events-none transition-all duration-300 flex items-center justify-center p-4">
    <!-- Login Modal Content -->
    <div id="login-modal" class="w-full max-w-md bg-white border border-border rounded-large shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out flex flex-col relative">
        <!-- Close Button -->
        <button id="login-modal-close" class="absolute top-4 right-4 text-text-muted hover:text-primary transition-colors cursor-pointer z-10" aria-label="Kapat">
            <i class="ri-close-line text-2xl"></i>
        </button>

        <!-- Banner / Header -->
        <div class="p-6 pb-4 border-b border-border/50 bg-surface-alt/15 text-center flex flex-col items-center gap-2">
            <div class="w-12 h-12 rounded-pill bg-primary/10 text-primary flex items-center justify-center">
                <i class="ri-user-received-line text-xl"></i>
            </div>
            <h3 class="font-heading font-black text-lg text-secondary"><?php esc_html_e( 'Bağışçı Girişi', 'dernek-tema' ); ?></h3>
            <p class="font-sans text-xs text-text-muted max-w-[280px]"><?php esc_html_e( 'Bağış geçmişinizi incelemek ve bilgilerinizi yönetmek için telefon numaranızla giriş yapın.', 'dernek-tema' ); ?></p>
        </div>

        <!-- Content Area -->
        <div class="p-6">
            <!-- Step 1: Send OTP Form -->
            <form id="otp-send-form" class="space-y-4" autocomplete="off">
                <div class="space-y-1">
                    <?php
                    get_template_part( 'resources/components/input', null, [
                        'type'     => 'tel',
                        'id'       => 'login-phone',
                        'required' => true,
                        'label'    => __( 'Telefon Numarası', 'dernek-tema' ),
                    ] );
                    ?>
                    <p class="text-[10px] text-text-muted mt-1.5 leading-relaxed"><?php esc_html_e( 'Üyeliğiniz yoksa giriş yaptığınızda otomatik oluşturulacaktır.', 'dernek-tema' ); ?></p>
                </div>
                
                <?php
                get_template_part( 'resources/components/button', null, [
                    'type'       => 'submit',
                    'variant'    => 'primary',
                    'class'      => 'w-full gap-2 justify-center flex items-center cursor-pointer shadow-sm py-3.5',
                    'text'       => '<span>' . esc_html__( 'Doğrulama Kodu Gönder', 'dernek-tema' ) . '</span> <i class="ri-arrow-right-line"></i>',
                    'escape'     => false,
                ] );
                ?>
            </form>

            <!-- Step 2: Verify OTP Form (hidden by default) -->
            <form id="otp-verify-form" class="space-y-4 hidden" autocomplete="off">
                <div class="space-y-1 text-center">
                    <label for="login-otp" class="block text-xs font-bold text-secondary mb-2"><?php esc_html_e( 'Doğrulama Kodu (SMS)', 'dernek-tema' ); ?></label>
                    <?php
                    get_template_part( 'resources/components/input', null, [
                        'type'        => 'text',
                        'id'          => 'login-otp',
                        'required'    => true,
                        'placeholder' => '123456',
                        'input_class' => 'max-w-[180px] mx-auto text-center tracking-[0.5em] font-black text-lg py-3 bg-surface-alt/20 text-secondary',
                        'attributes'  => 'maxlength="6" pattern="[0-9]{6}"',
                    ] );
                    ?>
                    <p id="otp-timer-text" class="text-[10px] text-text-muted mt-2">
                        <?php esc_html_e( 'Kalan Süre: ', 'dernek-tema' ); ?><span id="otp-timer" class="font-bold text-primary">120</span> <?php esc_html_e( 'sn', 'dernek-tema' ); ?>
                    </p>
                </div>

                <div class="space-y-2 pt-2">
                    <?php
                    get_template_part( 'resources/components/button', null, [
                        'type'       => 'submit',
                        'variant'    => 'primary',
                        'class'      => 'w-full gap-2 justify-center flex items-center cursor-pointer shadow-sm py-3.5',
                        'text'       => '<i class="ri-checkbox-circle-line"></i> <span>' . esc_html__( 'Girişi Tamamla', 'dernek-tema' ) . '</span>',
                        'escape'     => false,
                    ] );
                    ?>
                    <?php
                    get_template_part( 'resources/components/button', null, [
                        'variant'    => 'outline',
                        'size'       => 'small',
                        'text'       => __( 'Geri Dön / Numarayı Değiştir', 'dernek-tema' ),
                        'class'      => 'w-full hover:bg-surface-alt text-text-muted hover:text-secondary border-border cursor-pointer',
                        'type'       => 'button',
                        'attributes' => 'id="otp-back-btn"',
                    ] );
                    ?>
                </div>
            </form>

            <!-- Status Alerts -->
            <div id="login-alert" class="mt-4 p-3 rounded-medium border text-xs font-semibold hidden animate-fade-in"></div>
        </div>
    </div>
</div>

<div class="flex-1 flex flex-col">
