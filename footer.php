<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Retrieve Theme Option Values
$footer_logo = get_field( 'footer_logo', 'option' );
$company_name = get_field( 'company_name', 'option' );
$footer_desc = get_field( 'footer_description', 'option' );
$copyright = get_field( 'footer_copyright', 'option' );

// Contact Details
$phone = get_field( 'contact_phone', 'option' );
$whatsapp = get_field( 'contact_whatsapp', 'option' );
$email = get_field( 'contact_email', 'option' );
$address = get_field( 'contact_address', 'option' );

// Social Media Links
$social_links = get_field( 'social_links', 'option' );
?>

</div><!-- .flex-1 (closes from header.php) -->

<footer class="bg-navy-dark text-white pt-16 pb-8 border-t-4 border-primary mt-auto">
    <?php
    ob_start();
    ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
        
        <!-- Column 1: Branding & Description -->
        <div class="flex flex-col gap-5">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block group">
                <?php if ( $footer_logo ) : ?>
                    <img src="<?php echo esc_url( $footer_logo['url'] ); ?>" alt="<?php echo esc_attr( $company_name ? $company_name : get_bloginfo( 'name' ) ); ?>" class="h-12 w-auto object-contain">
                <?php else : ?>
                    <span class="font-heading font-bold text-2xl text-primary group-hover:text-primary-hover transition-colors">
                        <?php echo esc_html( $company_name ? $company_name : get_bloginfo( 'name' ) ); ?>
                    </span>
                <?php endif; ?>
            </a>
            
            <?php if ( $footer_desc ) : ?>
                <p class="text-text-muted text-sm leading-relaxed max-w-sm">
                    <?php echo esc_html( $footer_desc ); ?>
                </p>
            <?php endif; ?>

            <!-- Social Media Badges -->
            <?php if ( is_array( $social_links ) ) : ?>
                <div class="flex items-center gap-3 mt-2">
                    <?php 
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
                        <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-white/5 hover:bg-primary hover:text-white text-text-muted flex items-center justify-center transition-all duration-200" title="<?php echo esc_attr( ucfirst($platform) ); ?>">
                            <i class="<?php echo esc_attr( $icon_class ); ?> text-base"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Column 2: Footer Menu -->
        <div class="flex flex-col gap-5">
            <h4 class="font-heading font-bold text-lg text-primary tracking-wide">
                <?php esc_html_e( 'Kurumsal', 'dernek-tema' ); ?>
            </h4>
            <?php 
            if ( has_nav_menu( 'footer' ) ) {
                wp_nav_menu( [
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'flex flex-col gap-2.5 text-sm text-text-muted',
                    'fallback_cb'    => '__return_false',
                    'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                ] );
            } else {
                echo '<p class="text-text-muted text-xs">' . esc_html__( 'Alt bilgi menüsü tanımlanmamış.', 'dernek-tema' ) . '</p>';
            }
            ?>
        </div>

        <!-- Column 3: Footer Secondary Menu -->
        <div class="flex flex-col gap-5">
            <h4 class="font-heading font-bold text-lg text-primary tracking-wide">
                <?php esc_html_e( 'Hızlı Bağlantılar', 'dernek-tema' ); ?>
            </h4>
            <?php 
            if ( has_nav_menu( 'footer_secondary' ) ) {
                wp_nav_menu( [
                    'theme_location' => 'footer_secondary',
                    'container'      => false,
                    'menu_class'     => 'flex flex-col gap-2.5 text-sm text-text-muted',
                    'fallback_cb'    => '__return_false',
                    'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                ] );
            } else {
                echo '<p class="text-text-muted text-xs">' . esc_html__( 'İkincil alt bilgi menüsü tanımlanmamış.', 'dernek-tema' ) . '</p>';
            }
            ?>
        </div>

        <!-- Column 4: Contact Information -->
        <div class="flex flex-col gap-5">
            <h4 class="font-heading font-bold text-lg text-primary tracking-wide">
                <?php esc_html_e( 'İletişim', 'dernek-tema' ); ?>
            </h4>
            <ul class="flex flex-col gap-3.5 text-sm text-text-muted">
                <?php if ( $address ) : ?>
                    <li class="flex gap-2.5 items-start">
                        <i class="ri-map-pin-2-fill text-primary text-base mt-0.5 shrink-0"></i>
                        <span><?php echo nl2br( esc_html( $address ) ); ?></span>
                    </li>
                <?php endif; ?>
                
                <?php if ( $phone ) : ?>
                    <li class="flex gap-2.5 items-center">
                        <i class="ri-phone-fill text-primary text-base shrink-0"></i>
                        <a href="tel:<?php echo esc_attr( str_replace(' ', '', $phone) ); ?>" class="hover:text-white transition-colors">
                            <?php echo esc_html( $phone ); ?>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ( $email ) : ?>
                    <li class="flex gap-2.5 items-center">
                        <i class="ri-mail-fill text-primary text-base shrink-0"></i>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>" class="hover:text-white transition-colors break-all">
                            <?php echo esc_html( $email ); ?>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ( $whatsapp ) : ?>
                    <li class="flex gap-2.5 items-center">
                        <i class="ri-whatsapp-fill text-emerald-500 text-lg shrink-0"></i>
                        <a href="https://wa.me/<?php echo esc_attr( str_replace(['+', ' ', '(', ')', '-'], '', $whatsapp) ); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors font-medium text-emerald-400">
                            <?php esc_html_e( 'WhatsApp ile İletişime Geç', 'dernek-tema' ); ?>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

    </div>
    <?php
    $container_content = ob_get_clean();
    get_template_part( 'resources/components/container', null, [
        'content' => $container_content,
    ] );
    ?>

    <!-- Bottom copyright bar -->
    <?php
    ob_start();
    ?>
    <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-text-muted">
        <p>
            <?php 
            if ( $copyright ) {
                echo esc_html( str_replace( '{year}', date( 'Y' ), $copyright ) );
            } else {
                echo esc_html( sprintf( '© %s %s. Tüm Hakları Saklıdır.', date( 'Y' ), $company_name ? $company_name : get_bloginfo( 'name' ) ) );
            }
            ?>
        </p>
        <p class="flex items-center gap-1">
            <?php esc_html_e( 'Tasarım ve Altyapı:', 'dernek-tema' ); ?>
            <span class="font-semibold text-white">7 Kıta Derneği</span>
        </p>
    </div>
    <?php
    $container_content = ob_get_clean();
    get_template_part( 'resources/components/container', null, [
        'content' => $container_content,
    ] );
    ?>
</footer>

<?php wp_footer(); ?>
</body>
</html>
