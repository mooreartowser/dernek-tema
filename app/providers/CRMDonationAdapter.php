<?php
/**
 * CRM Donation Catalog Data Adapter
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CRMDonationAdapter {

    /**
     * Retrieve and normalize selected categories from the CRM catalog.
     *
     * @param array $selected_category_codes Array of selected CRM category codes
     * @return array Normalized list of donation cards
     */
    public static function getFeaturedDonations( array $selected_category_codes ): array {
        if ( ! function_exists( 'kadim_crm_bridge' ) ) {
            return [];
        }

        try {
            $catalog_browser = \kadim_crm_bridge()->catalog_browser();
            $catalog_tree = $catalog_browser->get_catalog_tree();
        } catch ( \Throwable $th ) {
            return [];
        }

        if ( empty( $catalog_tree ) || ! is_array( $catalog_tree ) ) {
            return [];
        }

        $cards = [];

        foreach ( $selected_category_codes as $code ) {
            if ( empty( $code ) ) {
                continue;
            }
            
            // Find the category node recursively in the tree
            $category_node = self::findCategoryNode( $catalog_tree, $code );
            if ( ! $category_node ) {
                continue;
            }

            // Normalize the category node
            $cards[] = self::normalizeCategory( $category_node );
        }

        return $cards;
    }

    /**
     * Helper to recursively find a category node by code in the catalog tree.
     */
    private static function findCategoryNode( array $categories, string $code ): ?array {
        foreach ( $categories as $category ) {
            if ( ! is_array( $category ) ) {
                continue;
            }

            $cat_code = trim( $category['code'] ?? $category['id'] ?? '' );
            if ( strcasecmp( $cat_code, $code ) === 0 ) {
                return $category;
            }

            if ( isset( $category['children'] ) && is_array( $category['children'] ) ) {
                $found = self::findCategoryNode( $category['children'], $code );
                if ( $found ) {
                    return $found;
                }
            }
        }

        return null;
    }

    /**
     * Normalize a CRM category node to match the DonationProvider schema.
     */
    private static function normalizeCategory( array $category ): array {
        $category_code = trim( $category['code'] ?? $category['id'] ?? '' );
        $category_name = trim( $category['name'] ?? '' );
        $image_url     = trim( $category['coverPhoto']['publicUrl'] ?? '' );
        
        // Default cover fallback if not specified
        if ( empty( $image_url ) ) {
            $image_url = get_template_directory_uri() . '/assets/demo/demo_relief.jpg';
        }

        // Get the first product's price if available
        $price = null;
        if ( isset( $category['products'] ) && is_array( $category['products'] ) && ! empty( $category['products'] ) ) {
            $first_product = $category['products'][0];
            if ( isset( $first_product['price'] ) && $first_product['price'] > 0 ) {
                $price = (float) $first_product['price'];
            }
        }

        // Form checkout URL with parameters
        $donation_url = esc_url( add_query_arg( [
            'requested_category' => $category_code
        ], '/bagislar/' ) );

        return [
            'id'           => $category['id'] ?? $category_code,
            'code'         => $category_code,
            'title'        => $category_name,
            'description'  => trim( $category['description'] ?? sprintf( __( '%s alanında bağış yaparak ihtiyaç sahiplerine destek olabilirsiniz.', 'dernek-tema' ), $category_name ) ),
            // Dual-compatible keys for theme compatibility
            'image'        => $image_url,
            'image_url'    => $image_url,
            'url'          => $donation_url,
            'donation_url' => $donation_url,
            'price'        => $price,
            'is_intent'    => ( strpos( $category_code, 'KURBAN' ) !== false || strpos( $category_code, 'ADAK' ) !== false ),
        ];
    }
}
