<?php
/**
 * Gallery Data Provider
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/ProviderInterface.php';

class GalleryProvider implements ProviderInterface {

    /**
     * Get list of gallery items from specific source.
     */
    public static function getItems( string $source, array $args = [] ): array {
        $items = [];

        switch ( $source ) {
            case 'crm':
                // In production, queries CRM Media Gallery API for a specific project/activity code
                $crm_mock_media = [
                    [
                        'id' => 'crm_med_1',
                        'mediaType' => 'IMAGE',
                        'publicUrl' => get_template_directory_uri() . '/assets/demo/demo_relief.jpg',
                        'title' => 'Saha Yardımları Gönüllü Grubu'
                    ],
                    [
                        'id' => 'crm_med_2',
                        'mediaType' => 'VIDEO',
                        'publicUrl' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                        'title' => 'Yetimhane Külliyesi Açılışı'
                    ]
                ];

                foreach ( $crm_mock_media as $raw ) {
                    $items[] = self::normalize( $raw, 'crm' );
                }
                break;

            case 'wordpress':
                // Queries WP media library attachments matching tags or post parents
                $query_args = wp_parse_args( $args, [
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'post_status'    => 'inherit',
                    'posts_per_page' => 8,
                ] );

                if ( isset( $args['post_parent'] ) ) {
                    $query_args['post_parent'] = $args['post_parent'];
                }

                $query = new WP_Query( $query_args );
                if ( $query->have_posts() ) {
                    foreach ( $query->posts as $attachment ) {
                        $items[] = self::normalize( $attachment, 'wordpress' );
                    }
                }
                break;

            case 'manual':
            default:
                // Parse standard block configurations: photos (gallery field) and videos (repeater field)
                $photos = $args['gallery_images'] ?? [];
                $videos = $args['video_urls'] ?? [];

                // Normalize and append photos
                if ( is_array( $photos ) ) {
                    foreach ( $photos as $photo_url ) {
                        $photo_raw = [
                            'type' => 'image',
                            'url'  => is_array( $photo_url ) ? $photo_url['url'] : $photo_url,
                            'title'=> is_array( $photo_url ) ? ($photo_url['title'] ?? '') : '',
                        ];
                        $items[] = self::normalize( $photo_raw, 'manual' );
                    }
                }

                // Normalize and append videos
                if ( is_array( $videos ) ) {
                    foreach ( $videos as $video ) {
                        $video_raw = [
                            'type'  => 'video',
                            'url'   => $video['video_url'] ?? '',
                            'title' => $video['title'] ?? '',
                        ];
                        $items[] = self::normalize( $video_raw, 'manual' );
                    }
                }

                // Fallback to static dummy arrays if empty
                if ( empty( $items ) ) {
                    $demo_items = [
                        [
                            'type'  => 'image',
                            'url'   => get_template_directory_uri() . '/assets/demo/demo_relief.jpg',
                            'title' => 'Demolar 1'
                        ],
                        [
                            'type'  => 'video',
                            'url'   => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                            'title' => 'Klip 1'
                        ]
                    ];
                    foreach ( $demo_items as $item ) {
                        $items[] = self::normalize( $item, 'manual' );
                    }
                }
                break;
        }

        return $items;
    }

    /**
     * Get single gallery item.
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
     * Normalize media datasets into theme unified gallery keys.
     */
    public static function normalize( $raw_data, string $source ): array {
        $normalized = [
            'id'            => '',
            'type'          => 'image', // 'image' or 'video'
            'url'           => '',
            'thumbnail_url' => '',
            'title'         => '',
        ];

        if ( $source === 'crm' && is_array( $raw_data ) ) {
            $normalized['id']            = $raw_data['id'] ?? uniqid();
            $normalized['type']          = strtolower( $raw_data['mediaType'] ?? 'image' );
            $normalized['url']           = $raw_data['publicUrl'] ?? '';
            $normalized['title']         = $raw_data['title'] ?? '';
            
            if ( $normalized['type'] === 'video' ) {
                // Parse YouTube thumbnail if matching
                $normalized['thumbnail_url'] = self::getYoutubeThumbnail( $normalized['url'] );
            } else {
                $normalized['thumbnail_url'] = $normalized['url'];
            }
        } elseif ( $source === 'wordpress' && is_object( $raw_data ) ) {
            $p_id = $raw_data->ID;
            $normalized['id']            = $p_id;
            $normalized['type']          = strpos( $raw_data->post_mime_type, 'video' ) !== false ? 'video' : 'image';
            $normalized['url']           = wp_get_attachment_url( $p_id );
            $normalized['thumbnail_url'] = wp_get_attachment_image_url( $p_id, 'medium' ) ?: $normalized['url'];
            $normalized['title']         = get_the_title( $p_id );
        } elseif ( $source === 'manual' && is_array( $raw_data ) ) {
            $normalized['id']            = uniqid();
            $normalized['type']          = $raw_data['type'] ?? 'image';
            $normalized['url']           = $raw_data['url'] ?? '';
            $normalized['title']         = $raw_data['title'] ?? '';
            
            if ( $normalized['type'] === 'video' ) {
                $normalized['thumbnail_url'] = self::getYoutubeThumbnail( $normalized['url'] );
            } else {
                $normalized['thumbnail_url'] = $normalized['url'];
            }
        }

        return $normalized;
    }

    /**
     * Helper to retrieve YouTube thumbnail from watch/embed links.
     */
    private static function getYoutubeThumbnail( string $url ): string {
        $video_id = '';
        if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|[^/]+\?v=)|youtu\.be/)([^"&?/\s]{11})%i', $url, $match ) ) {
            $video_id = $match[1];
        }
        
        if ( ! empty( $video_id ) ) {
            return "https://img.youtube.com/vi/{$video_id}/hqdefault.jpg";
        }
        
        return get_template_directory_uri() . '/assets/demo/demo_education.jpg';
    }
}
