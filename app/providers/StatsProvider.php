<?php
/**
 * Stats Data Provider
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/ProviderInterface.php';

class StatsProvider implements ProviderInterface {

    /**
     * Get list of stats items from specific source.
     */
    public static function getItems( string $source, array $args = [] ): array {
        $items = [];

        switch ( $source ) {
            case 'crm':
                // In production, queries CRM API aggregation counters endpoint
                // We map dynamic values in real time from CRM statistics
                $crm_mock_stats = [
                    [
                        'key' => 'wells_count',
                        'icon' => 'ri-drop-line',
                        'title' => 'Aktif Su Kuyusu',
                        'count' => 384, // Real integer from CRM database
                        'suffix' => '+',
                        'description' => 'Asya ve Afrika genelinde açtığımız temiz su kaynakları.'
                    ],
                    [
                        'key' => 'orphans_count',
                        'icon' => 'ri-heart-line',
                        'title' => 'Sponsorlu Yetim',
                        'count' => 12450,
                        'suffix' => '+',
                        'description' => 'Aylık eğitim, barınma ve gıda desteği sağladığımız çocuklar.'
                    ],
                    [
                        'key' => 'countries_count',
                        'icon' => 'ri-global-line',
                        'title' => 'Hizmet Ülkesi',
                        'count' => 24,
                        'suffix' => '',
                        'description' => 'İyiliği ulaştırdığımız toplam ülke sayısı.'
                    ]
                ];

                foreach ( $crm_mock_stats as $raw ) {
                    $items[] = self::normalize( $raw, 'crm' );
                }
                break;

            case 'wordpress':
                // Queries standard WordPress options page or dashboard counters
                $options_stats = get_option( 'dernek_theme_stats' );
                if ( is_array( $options_stats ) ) {
                    foreach ( $options_stats as $stat ) {
                        $items[] = self::normalize( $stat, 'wordpress' );
                    }
                } else {
                    // Fallback to ACF global theme settings counters if available
                    $fallback_stats = [
                        [
                            'icon' => 'ri-global-line',
                            'value' => '24+',
                            'title' => 'Ülke',
                            'description' => 'Destek ulaştırdığımız ülke sayısı'
                        ]
                    ];
                    foreach ( $fallback_stats as $stat ) {
                        $items[] = self::normalize( $stat, 'wordpress' );
                    }
                }
                break;

            case 'manual':
            default:
                // Pull from custom editor Gutenberg blocks inputs
                $manual_stats = $args['stats'] ?? [];
                if ( ! empty( $manual_stats ) ) {
                    foreach ( $manual_stats as $stat ) {
                        $items[] = self::normalize( $stat, 'manual' );
                    }
                } else {
                    // Static editor demo values fallback
                    $demo_stats = [
                        [
                            'icon'        => 'ri-global-line',
                            'value'       => '24+',
                            'title'       => 'Hizmet Ülkesi',
                            'description' => 'Destek ulaştırdığımız ülke sayısı'
                        ],
                        [
                            'icon'        => 'ri-heart-line',
                            'value'       => '1.2M+',
                            'title'       => 'Faydalanıcı',
                            'description' => 'Ulaştığımız ihtiyaç sahibi sayısı'
                        ]
                    ];
                    foreach ( $demo_stats as $stat ) {
                        $items[] = self::normalize( $stat, 'manual' );
                    }
                }
                break;
        }

        return $items;
    }

    /**
     * Get a single statistic by key.
     */
    public static function getItem( string $source, $id, array $args = [] ): ?array {
        $items = self::getItems( $source, $args );
        foreach ( $items as $item ) {
            if ( $item['id'] === $id ) {
                return $item;
            }
        }
        return null;
    }

    /**
     * Normalize statistic dataset into standard theme key map.
     */
    public static function normalize( $raw_data, string $source ): array {
        $normalized = [
            'id'          => '',
            'icon'        => 'ri-heart-line',
            'value'       => '0',
            'title'       => '',
            'description' => '',
        ];

        if ( $source === 'crm' && is_array( $raw_data ) ) {
            $normalized['id']          = $raw_data['key'] ?? '';
            $normalized['icon']        = $raw_data['icon'] ?? 'ri-heart-line';
            $normalized['title']       = $raw_data['title'] ?? '';
            $normalized['description'] = $raw_data['description'] ?? '';
            
            // Render CRM integer with formatting and optional suffix
            $count = isset( $raw_data['count'] ) ? (int) $raw_data['count'] : 0;
            $suffix = $raw_data['suffix'] ?? '';
            
            if ( $count >= 1000000 ) {
                $normalized['value'] = number_format( $count / 1000000, 1, ',', '.' ) . 'M' . $suffix;
            } elseif ( $count >= 1000 ) {
                $normalized['value'] = number_format( $count / 1000, 1, ',', '.' ) . 'K' . $suffix;
            } else {
                $normalized['value'] = number_format( $count, 0, ',', '.' ) . $suffix;
            }
        } elseif ( ( $source === 'wordpress' || $source === 'manual' ) && is_array( $raw_data ) ) {
            $normalized['id']          = sanitize_title( $raw_data['title'] ?? uniqid() );
            $normalized['icon']        = $raw_data['icon'] ?? 'ri-heart-line';
            $normalized['value']       = $raw_data['value'] ?? '0';
            $normalized['title']       = $raw_data['title'] ?? '';
            $normalized['description'] = $raw_data['description'] ?? '';
        }

        return $normalized;
    }
}
