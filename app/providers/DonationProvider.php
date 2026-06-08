<?php
/**
 * Donation Data Provider
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/ProviderInterface.php';

class DonationProvider implements ProviderInterface {

    /**
     * Get list of donation items from specific source.
     */
    public static function getItems( string $source, array $args = [] ): array {
        $items = [];

        switch ( $source ) {
            case 'crm':
                // Check if CRM adapter is available and get categories
                $selected_codes = $args['crm_categories'] ?? [];
                if ( function_exists( 'kadim_crm_bridge' ) ) {
                    require_once __DIR__ . '/CRMDonationAdapter.php';
                    if ( ! empty( $selected_codes ) && is_array( $selected_codes ) ) {
                        $items = CRMDonationAdapter::getFeaturedDonations( $selected_codes );
                    } else {
                        // Default fallback categories
                        $items = CRMDonationAdapter::getFeaturedDonations( [ 'KURBAN', 'YETIM', 'SU_KUYUSU', 'ACIL_YARDIM' ] );
                    }
                }

                // Fallback to manual blocks if CRM is unavailable or returns empty
                if ( empty( $items ) ) {
                    $items = self::getItems( 'manual', $args );
                }
                break;

            case 'wordpress':
                // If the NGO decides to store donation products as custom post types or posts in WP
                $query_args = wp_parse_args( $args, [
                    'post_type'      => 'post', // or custom 'donation_product' post type
                    'category_name'  => 'bagis-fonlari',
                    'posts_per_page' => 6,
                    'post_status'    => 'publish',
                ] );

                $query = new WP_Query( $query_args );
                if ( $query->have_posts() ) {
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $items[] = self::normalize( $query->post, 'wordpress' );
                    }
                    wp_reset_postdata();
                }
                break;

            case 'manual':
            default:
                // Pull manually entered data from ACF fields (e.g. custom block cards or Theme Settings option)
                $manual_cards = $args['cards'] ?? get_field( 'featured_donations_fallback', 'option' );
                if ( is_array( $manual_cards ) && ! empty( $manual_cards ) ) {
                    foreach ( $manual_cards as $card ) {
                        $items[] = self::normalize( $card, 'manual' );
                    }
                } else {
                    // Static demo mock cards if field is empty
                    $demo_cards = [
                        [
                            'image'       => get_template_directory_uri() . '/assets/demo/demo_orphan.jpg',
                            'title'       => 'Yetim Bağışı',
                            'description' => 'Bir yetimin aylık eğitim ve sıcak yemek masraflarını karşılayın.',
                            'url'         => '/bagislar/',
                            'price'       => 500,
                        ],
                        [
                            'image'       => get_template_directory_uri() . '/assets/demo/demo_waterwell.jpg',
                            'title'       => 'Su Kuyusu Bağışı',
                            'description' => 'Temiz suya hasret coğrafyalarda kalıcı su kuyuları açın.',
                            'url'         => '/bagislar/',
                            'price'       => 35000,
                        ]
                    ];
                    foreach ( $demo_cards as $card ) {
                        $items[] = self::normalize( $card, 'manual' );
                    }
                }
                break;
        }

        return $items;
    }

    /**
     * Get a single donation item by identifier.
     */
    public static function getItem( string $source, $id, array $args = [] ): ?array {
        $items = self::getItems( $source, $args );
        foreach ( $items as $item ) {
            if ( $item['id'] === $id || $item['code'] === $id ) {
                return $item;
            }
        }
        return null;
    }

    /**
     * Normalize different donation source formats into a single, unified view schema.
     */
    public static function normalize( $raw_data, string $source ): array {
        $normalized = [
            'id'          => '',
            'code'        => '',
            'title'       => '',
            'description' => '',
            'image'       => '',
            'image_url'   => '',
            'url'         => '/bagislar/',
            'donation_url'=> '/bagislar/',
            'price'       => null,
            'is_intent'   => false,
        ];

        if ( $source === 'crm' && is_array( $raw_data ) ) {
            $normalized['id']           = $raw_data['id'] ?? '';
            $normalized['code']         = $raw_data['code'] ?? '';
            $normalized['title']        = $raw_data['name'] ?? '';
            $normalized['description']  = $raw_data['description'] ?? '';
            $normalized['image_url']    = $raw_data['coverPhoto']['publicUrl'] ?? '';
            $normalized['image']        = $normalized['image_url'];
            $normalized['price']        = isset( $raw_data['price'] ) && $raw_data['price'] > 0 ? (float) $raw_data['price'] : null;
            $normalized['donation_url'] = esc_url( add_query_arg( [
                'product_code' => $normalized['code'],
                'crm_id'       => $normalized['id']
            ], '/bagislar/' ) );
            $normalized['url']          = $normalized['donation_url'];
            // Intent variants like Adak/Kurban check
            if ( strpos( $normalized['code'], 'KURBAN' ) !== false || strpos( $normalized['code'], 'ADAK' ) !== false ) {
                $normalized['is_intent'] = true;
            }
        } elseif ( $source === 'wordpress' && is_object( $raw_data ) ) {
            $p_id = $raw_data->ID;
            $normalized['id']           = $p_id;
            $normalized['code']         = $raw_data->post_name;
            $normalized['title']        = get_the_title( $p_id );
            $normalized['description']  = get_the_excerpt( $p_id );
            $normalized['image_url']    = get_the_post_thumbnail_url( $p_id, 'medium' ) ?: '';
            $normalized['image']        = $normalized['image_url'];
            $normalized['price']        = get_post_meta( $p_id, 'donation_price', true ) ?: null;
            $normalized['donation_url'] = get_permalink( $p_id );
            $normalized['url']          = $normalized['donation_url'];
        } elseif ( $source === 'manual' && is_array( $raw_data ) ) {
            $normalized['id']           = sanitize_title( $raw_data['title'] ?? uniqid() );
            $normalized['code']         = sanitize_title( $raw_data['title'] ?? '' );
            $normalized['title']        = $raw_data['title'] ?? '';
            $normalized['description']  = $raw_data['description'] ?? '';
            $normalized['image_url']    = $raw_data['image'] ?? '';
            $normalized['image']        = $normalized['image_url'];
            $normalized['price']        = isset( $raw_data['price'] ) && $raw_data['price'] > 0 ? (float) $raw_data['price'] : null;
            $normalized['donation_url'] = $raw_data['url'] ?? '/bagislar/';
            $normalized['url']          = $normalized['donation_url'];
        }

        return $normalized;
    }
}
