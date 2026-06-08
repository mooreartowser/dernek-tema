<?php
/**
 * Gutenberg Blocks Bootstrapper
 *
 * @package DernekTema
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'acf/init', 'dernek_register_acf_blocks' );
/**
 * Register Gutenberg blocks and their local ACF fields.
 */
function dernek_register_acf_blocks() {
    if ( ! function_exists( 'acf_register_block_type' ) ) {
        return;
    }

    $blocks_path = get_template_directory() . '/resources/views/blocks';

    if ( ! is_dir( $blocks_path ) ) {
        return;
    }

    $block_dirs = glob( $blocks_path . '/*', GLOB_ONLYDIR );

    if ( empty( $block_dirs ) ) {
        return;
    }

    foreach ( $block_dirs as $dir ) {
        $register_file = $dir . '/register.php';

        if ( file_exists( $register_file ) ) {
            require_once $register_file;
        }
    }
}
