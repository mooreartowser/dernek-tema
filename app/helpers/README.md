# Helpers Layer

Place global helper functions, utility classes, and custom formatting tools in this directory.

## How it works:
- Files in this directory are loaded **first** during the theme bootstrapping process.
- This ensures any global helper functions or array utility helpers are fully initialized before theme settings, ACF fields, or services are defined.

## Guidelines:
- Namespace functions or check `if ( ! function_exists( 'name' ) )` to avoid conflicts.
- Do not place theme configuration/setup hooks here (use `app/setup/` instead).
