<?php
/**
 * Project Data Provider
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/ProviderInterface.php';

class ProjectProvider implements ProviderInterface {

    /**
     * Get list of project items from specific source.
     */
    public static function getItems( string $source, array $args = [] ): array {
        $items = [];

        switch ( $source ) {
            case 'crm':
                // In production, queries CRM API campaigns endpoint
                $crm_mock_campaigns = [
                    [
                        'id' => 'crm_camp_chad_water',
                        'code' => 'chad-su-kuyulari',
                        'name' => 'Çad Temiz Su Kuyuları Kampanyası',
                        'description' => 'Çad Çölü kırsalındaki 5 köyde toplam 10.000 insanın temiz suya kavuşması için çalışıyoruz.',
                        'coverImage' => get_template_directory_uri() . '/assets/demo/demo_waterwell.jpg',
                        'collected' => 280000,
                        'target' => 400000,
                        'isActive' => true
                    ],
                    [
                        'id' => 'crm_camp_idlib_food',
                        'code' => 'idlib-acil-gida',
                        'name' => 'İdlib Çadır Kent Acil Gıda Dağıtımları',
                        'description' => 'İdlib kırsalındaki mülteci kamplarında çetin kış şartlarında mücadele veren ailelere gıda kolisi yardımı.',
                        'coverImage' => get_template_directory_uri() . '/assets/demo/demo_relief.jpg',
                        'collected' => 95000,
                        'target' => 120000,
                        'isActive' => true
                    ]
                ];

                foreach ( $crm_mock_campaigns as $raw ) {
                    $items[] = self::normalize( $raw, 'crm' );
                }
                break;

            case 'wordpress':
            default:
                // Standard WordPress CPT 'project' query
                // It can merge dynamic collected/target values from CRM if needed (Hybrid Model)
                $query_args = wp_parse_args( $args, [
                    'post_type'      => 'project',
                    'posts_per_page' => 6,
                    'post_status'    => 'publish',
                ] );

                // If specific relationship project IDs are passed
                if ( isset( $args['post__in'] ) && is_array( $args['post__in'] ) ) {
                    $query_args['post__in'] = $args['post__in'];
                    $query_args['orderby'] = 'post__in';
                }

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
                // Static manually configured project array (e.g. from page builder inputs)
                $manual_projects = $args['projects'] ?? [];
                foreach ( $manual_projects as $raw ) {
                    $items[] = self::normalize( $raw, 'manual' );
                }
                break;
        }

        return $items;
    }

    /**
     * Get a single project item by ID or slug.
     */
    public static function getItem( string $source, $id, array $args = [] ): ?array {
        if ( $source === 'wordpress' && is_numeric( $id ) ) {
            $post = get_post( $id );
            if ( $post && $post->post_type === 'project' ) {
                return self::normalize( $post, 'wordpress' );
            }
            return null;
        }

        $items = self::getItems( $source, $args );
        foreach ( $items as $item ) {
            if ( $item['id'] === $id || $item['code'] === $id ) {
                return $item;
            }
        }
        return null;
    }

    /**
     * Normalize project dataset into unified theme presentation schema.
     */
    public static function normalize( $raw_data, string $source ): array {
        $normalized = [
            'id'               => '',
            'code'             => '',
            'title'            => '',
            'description'      => '',
            'content'          => '',
            'image_url'        => '',
            'url'              => '',
            'collected_amount' => 0,
            'target_amount'    => 0,
            'percentage'       => 0,
            'is_active'        => true,
        ];

        if ( $source === 'crm' && is_array( $raw_data ) ) {
            $normalized['id']               = $raw_data['id'] ?? '';
            $normalized['code']             = $raw_data['code'] ?? '';
            $normalized['title']            = $raw_data['name'] ?? '';
            $normalized['description']      = $raw_data['description'] ?? '';
            $normalized['image_url']        = $raw_data['coverImage'] ?? '';
            $normalized['collected_amount'] = (float) ( $raw_data['collected'] ?? 0 );
            $normalized['target_amount']    = (float) ( $raw_data['target'] ?? 0 );
            $normalized['is_active']        = (bool) ( $raw_data['isActive'] ?? true );
            $normalized['url']              = esc_url( add_query_arg( 'project_code', $normalized['code'], '/projeler' ) );
        } elseif ( $source === 'wordpress' && is_object( $raw_data ) ) {
            $p_id = $raw_data->ID;
            $normalized['id']               = $p_id;
            $normalized['code']             = $raw_data->post_name;
            $normalized['title']            = get_the_title( $p_id );
            $normalized['description']      = get_the_excerpt( $p_id );
            $normalized['content']          = apply_filters( 'the_content', $raw_data->post_content );
            $normalized['image_url']        = get_the_post_thumbnail_url( $p_id, 'full' ) ?: '';
            $normalized['url']              = get_permalink( $p_id );

            // Retrieve funding metrics (dynamic integration fallback)
            // This is hybrid logic: standard details from CPT, but numerical totals
            // can load from custom fields or fall back to mock numbers
            $collected = get_post_meta( $p_id, 'collected_amount', true );
            $target    = get_post_meta( $p_id, 'target_amount', true );
            
            // Allow ACF get_field checks
            if ( function_exists( 'get_field' ) ) {
                $collected = get_field( 'collected_amount', $p_id ) ?: $collected;
                $target    = get_field( 'target_amount', $p_id ) ?: $target;
            }

            $normalized['collected_amount'] = (float) ( $collected ?: 45000 );
            $normalized['target_amount']    = (float) ( $target ?: 60000 );
            $normalized['is_active']        = get_post_meta( $p_id, 'project_active', true ) !== '0';
        } elseif ( $source === 'manual' && is_array( $raw_data ) ) {
            $normalized['id']               = $raw_data['id'] ?? uniqid();
            $normalized['code']             = $raw_data['code'] ?? '';
            $normalized['title']            = $raw_data['title'] ?? '';
            $normalized['description']      = $raw_data['description'] ?? '';
            $normalized['image_url']        = $raw_data['image_url'] ?? '';
            $normalized['url']              = $raw_data['url'] ?? '#';
            $normalized['collected_amount'] = (float) ( $raw_data['collected_amount'] ?? 0 );
            $normalized['target_amount']    = (float) ( $raw_data['target_amount'] ?? 0 );
            $normalized['is_active']        = (bool) ( $raw_data['is_active'] ?? true );
        }

        // Calculate progress percentage
        if ( $normalized['target_amount'] > 0 ) {
            $normalized['percentage'] = min( 100, round( ( $normalized['collected_amount'] / $normalized['target_amount'] ) * 100 ) );
        }

        return $normalized;
    }
}
