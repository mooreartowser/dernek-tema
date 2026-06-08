# ACF (Advanced Custom Fields) Layer

All Advanced Custom Fields (ACF) configurations, layout fields, and field groups should be defined and managed within this folder.

## How it works:
- Any PHP file in this directory (e.g., `theme-settings.php`, `page-builder.php`) will be automatically included during theme bootstrapping.
- Register your custom field groups here using the ACF PHP utility function `acf_add_local_field_group()`.

## Benefits:
- Version-controlled ACF configurations.
- Clear separation from presentation files and other setup hooks.
