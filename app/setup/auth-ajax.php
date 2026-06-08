<?php
/**
 * AJAX Handlers for Authentication
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Handle AJAX logout.
 */
add_action( 'wp_ajax_peta_logout', 'peta_ajax_logout' );
add_action( 'wp_ajax_nopriv_peta_logout', 'peta_ajax_logout' );
function peta_ajax_logout() {
    // Check origin or host to set secure cookie flags
    $host_header = $_SERVER['HTTP_HOST'] ?? '';
    $host_parts  = explode( ':', $host_header );
    $hostname    = ! empty( $host_parts[0] ) ? $host_parts[0] : 'localhost';
    $is_secure   = ( $hostname !== 'localhost' );

    // Clear endUserToken cookie
    $cookie_options = [
        'expires'  => time() - 3600,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Strict',
    ];

    if ( $is_secure ) {
        $cookie_options['secure'] = true;
    }

    setcookie( 'endUserToken', '', $cookie_options );

    wp_send_json_success( [
        'message' => __( 'Başarıyla çıkış yapıldı.', 'dernek-tema' )
    ] );
}

/**
 * Handle AJAX cart item quantity update.
 */
add_action( 'wp_ajax_peta_update_quantity', 'peta_ajax_update_quantity' );
add_action( 'wp_ajax_nopriv_peta_update_quantity', 'peta_ajax_update_quantity' );
function peta_ajax_update_quantity() {
    $line_key = isset( $_POST['line_key'] ) ? sanitize_text_field( wp_unslash( $_POST['line_key'] ) ) : '';
    $quantity = isset( $_POST['quantity'] ) ? absint( $_POST['quantity'] ) : 1;

    if ( empty( $line_key ) || $quantity <= 0 ) {
        wp_send_json_error( [ 'message' => __( 'Geçersiz parametreler.', 'dernek-tema' ) ], 400 );
    }

    $cookie_name = \Hiyad\Bridge\Cart\CartStore::COOKIE_NAME;
    $token = isset( $_COOKIE[$cookie_name] ) ? sanitize_text_field( wp_unslash( $_COOKIE[$cookie_name] ) ) : '';

    if ( empty( $token ) ) {
        wp_send_json_error( [ 'message' => __( 'Sepet bulunamadı.', 'dernek-tema' ) ], 400 );
    }

    try {
        $cart_store = new \Hiyad\Bridge\Cart\CartStore();
        $items = $cart_store->get_cart( $token );
        $target_item = null;

        foreach ( $items as $item ) {
            if ( ( $item['lineKey'] ?? '' ) === $line_key ) {
                $target_item = $item;
                break;
            }
        }

        if ( $target_item ) {
            // Remove the item
            $cart_store->remove_item( $token, $line_key );
            // Update quantity
            $target_item['quantity'] = $quantity;
            // Add item back
            $new_items = $cart_store->add_item( $token, $target_item );

            wp_send_json_success( [
                'message' => __( 'Miktar güncellendi.', 'dernek-tema' ),
                'items'   => $new_items
            ] );
        } else {
            wp_send_json_error( [ 'message' => __( 'Öğe sepetinizde bulunamadı.', 'dernek-tema' ) ], 404 );
        }
    } catch ( \Throwable $e ) {
        wp_send_json_error( [ 'message' => $e->getMessage() ], 500 );
    }
}
