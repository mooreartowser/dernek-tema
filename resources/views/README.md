# Views Layer

This directory holds the template view files representing main page styles (e.g., custom pages, posts, archives, search results).

## Structure:
- Keep PHP processing to a minimum in views; they should primarily receive variables from controller code or helpers and render HTML markup.
- For repeating parts of markup, extract them to `resources/components/` and load them as components.
