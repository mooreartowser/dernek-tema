# CPT (Custom Post Types & Taxonomies) Layer

Register all custom post types and custom taxonomies within this folder.

## How it works:
- Any PHP file in this directory will be automatically loaded by the theme's bootloader.
- Define register actions hooked into the WordPress `init` hook inside your PHP files here.

## Example Structure:
```php
<?php
add_action( 'init', function() {
    register_post_type( 'activity', [
        'labels' => [
            'name' => __( 'Faaliyetler', 'dernek-tema' ),
            'singular_name' => __( 'Faaliyet', 'dernek-tema' ),
        ],
        'public' => true,
        'has_archive' => true,
        'supports' => [ 'title', 'editor', 'thumbnail' ],
    ] );
} );
```
