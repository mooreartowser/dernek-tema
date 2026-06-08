# Theme Options Layer

Configure and register global options pages, theme-wide customizer panels, or settings screens here.

## How it works:
- Any PHP file in this directory will be automatically loaded by the theme's bootloader.
- Typically, you will use ACF's `acf_add_options_page()` or the standard WordPress Customizer API to define theme options here.

## Example:
```php
<?php
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( [
        'page_title' => __( 'Tema Ayarları', 'dernek-tema' ),
        'menu_title' => __( 'Tema Ayarları', 'dernek-tema' ),
        'menu_slug'  => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ] );
}
```
