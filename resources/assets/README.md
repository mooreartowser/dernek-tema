# Assets Layer

This directory holds frontend assets. You should structure it with:
- `css/` (compiled or source CSS files, e.g., `main.css`)
- `js/` (JavaScript source code, e.g., `main.js`)
- `images/` (images, SVGs, logos, icons)
- `fonts/` (custom typography files)

## Integration:
The theme's `enqueue.php` is pre-configured to check for the existence of `resources/assets/css/main.css` and `resources/assets/js/main.js` and automatically load them on the front-end if found.
