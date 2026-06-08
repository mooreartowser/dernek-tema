<?php
/**
 * Register peta_project Custom Post Type
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', 'dernek_register_project_cpt', 0 );

function dernek_register_project_cpt() {
    $labels = [
        'name'                  => _x( 'Projeler', 'Post Type General Name', 'dernek-tema' ),
        'singular_name'         => _x( 'Proje', 'Post Type Singular Name', 'dernek-tema' ),
        'menu_name'             => __( 'Projeler', 'dernek-tema' ),
        'all_items'             => __( 'Tüm Projeler', 'dernek-tema' ),
        'add_new_item'          => __( 'Yeni Proje Ekle', 'dernek-tema' ),
        'add_new'               => __( 'Yeni Ekle', 'dernek-tema' ),
        'new_item'              => __( 'Yeni Proje', 'dernek-tema' ),
        'edit_item'             => __( 'Projeyi Düzenle', 'dernek-tema' ),
        'update_item'           => __( 'Projeyi Güncelle', 'dernek-tema' ),
        'view_item'             => __( 'Projeyi Görüntüle', 'dernek-tema' ),
        'search_items'          => __( 'Proje Ara', 'dernek-tema' ),
    ];

    $args = [
        'label'                 => __( 'Proje', 'dernek-tema' ),
        'description'           => __( 'Yardım Projeleri', 'dernek-tema' ),
        'labels'                => $labels,
        'supports'              => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-pressthis',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'projeler',
        'rewrite'               => [ 'slug' => 'projeler', 'with_front' => false ],
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
    ];

    register_post_type( 'project', $args );
}
