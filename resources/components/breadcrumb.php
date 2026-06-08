<?php
/**
 * Breadcrumb Component
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define home item
$crumbs = [
    [
        'title' => __( 'Ana Sayfa', 'dernek-tema' ),
        'url'   => home_url( '/' )
    ]
];

if ( is_archive() ) {
    $crumbs[] = [
        'title' => post_type_archive_title( '', false ),
        'url'   => ''
    ];
} elseif ( is_single() ) {
    $post_type = get_post_type();
    $post_type_obj = get_post_type_object( $post_type );
    
    if ( $post_type_obj && $post_type_obj->has_archive ) {
        $crumbs[] = [
            'title' => $post_type_obj->labels->name,
            'url'   => get_post_type_archive_link( $post_type )
        ];
    }
    
    $crumbs[] = [
        'title' => get_the_title(),
        'url'   => ''
    ];
} elseif ( is_page() ) {
    global $post;
    if ( ! empty( $post->post_parent ) ) {
        $parent_id = $post->post_parent;
        $parent_crumbs = [];
        while ( $parent_id ) {
            $page = get_post( $parent_id );
            if ( $page ) {
                $parent_crumbs[] = [
                    'title' => get_the_title( $page->ID ),
                    'url'   => get_permalink( $page->ID )
                ];
                $parent_id = $page->post_parent;
            } else {
                break;
            }
        }
        $crumbs = array_merge( $crumbs, array_reverse( $parent_crumbs ) );
    }
    $crumbs[] = [
        'title' => get_the_title(),
        'url'   => ''
    ];
} elseif ( is_search() ) {
    $crumbs[] = [
        'title' => sprintf( __( 'Arama Sonuçları: %s', 'dernek-tema' ), get_search_query() ),
        'url'   => ''
    ];
} elseif ( is_404() ) {
    $crumbs[] = [
        'title' => __( '404 - Bulunamadı', 'dernek-tema' ),
        'url'   => ''
    ];
}

// Render breadcrumbs
if ( count( $crumbs ) > 1 ) : ?>
    <nav class="flex items-center flex-wrap gap-2 text-xs font-medium text-white/80" aria-label="Breadcrumb">
        <?php foreach ( $crumbs as $index => $crumb ) : 
            $is_last = ( $index === count( $crumbs ) - 1 );
            if ( ! $is_last && ! empty( $crumb['url'] ) ) : ?>
                <a href="<?php echo esc_url( $crumb['url'] ); ?>" class="hover:text-primary transition-colors">
                    <?php echo esc_html( $crumb['title'] ); ?>
                </a>
                <span class="text-white/30 select-none">/</span>
            <?php else : ?>
                <span class="text-white font-semibold truncate max-w-[240px]" aria-current="page">
                    <?php echo esc_html( $crumb['title'] ); ?>
                </span>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
<?php endif; ?>
