# Custom Page Templates

Place custom page templates in this directory.

## How it works:
WordPress automatically scans files in this directory for custom Page Templates. To register a page template, add a PHP file and include the Template Name header:

```php
<?php
/**
 * Template Name: Anasayfa (Home)
 * Template Post Type: page
 */

// Your custom layout logic here
```
