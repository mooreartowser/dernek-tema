<?php
/**
 * Core Provider Interface
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

interface ProviderInterface {
    /**
     * Get list of items from a specific data source.
     *
     * @param string $source Data source ('manual', 'wordpress', 'crm')
     * @param array  $args   Optional query parameters/filters
     * @return array Array of normalized data structures
     */
    public static function getItems( string $source, array $args = [] ): array;

    /**
     * Get a single item by identifier from a specific data source.
     *
     * @param string $source Data source ('manual', 'wordpress', 'crm')
     * @param mixed  $id     Unique ID of the item
     * @param array  $args   Optional extra context parameters
     * @return array|null Normalized data array or null if not found
     */
    public static function getItem( string $source, $id, array $args = [] ): ?array;

    /**
     * Normalize raw database, ACF, or API data structures into a unified theme schema.
     *
     * @param mixed  $raw_data Raw input from the source
     * @param string $source   The source context ('manual', 'wordpress', 'crm')
     * @return array Normalized array
     */
    public static function normalize( $raw_data, string $source ): array;
}
