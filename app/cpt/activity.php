<?php
/**
 * Register peta_activity Custom Post Type
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', 'dernek_register_activity_cpt', 0 );

function dernek_register_activity_cpt() {
    $labels = [
        'name'                  => _x( 'Faaliyetler', 'Post Type General Name', 'dernek-tema' ),
        'singular_name'         => _x( 'Faaliyet', 'Post Type Singular Name', 'dernek-tema' ),
        'menu_name'             => __( 'Faaliyetler', 'dernek-tema' ),
        'all_items'             => __( 'Tüm Faaliyetler', 'dernek-tema' ),
        'add_new_item'          => __( 'Yeni Faaliyet Ekle', 'dernek-tema' ),
        'add_new'               => __( 'Yeni Ekle', 'dernek-tema' ),
        'new_item'              => __( 'Yeni Faaliyet', 'dernek-tema' ),
        'edit_item'             => __( 'Faaliyeti Düzenle', 'dernek-tema' ),
        'update_item'           => __( 'Faaliyeti Güncelle', 'dernek-tema' ),
        'view_item'             => __( 'Faaliyeti Görüntüle', 'dernek-tema' ),
        'search_items'          => __( 'Faaliyet Ara', 'dernek-tema' ),
    ];

    $args = [
        'label'                 => __( 'Faaliyet', 'dernek-tema' ),
        'description'           => __( 'Dernek Faaliyetleri', 'dernek-tema' ),
        'labels'                => $labels,
        'supports'              => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-welcome-learn-more',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'faaliyetler',
        'rewrite'               => [ 'slug' => 'faaliyetler', 'with_front' => false ],
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
    ];

    register_post_type( 'activity', $args );
}
