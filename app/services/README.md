# Services Layer

This layer acts as the domain and business logic provider for the theme. Write service objects, API wrappers, donation handlers, and querying services here.

## Guidelines:
- Write classes that handle single responsibilities (e.g., `DonationService`, `EventQueryService`).
- Keep these classes decoupled from presentation templates.
- Any PHP file in this directory will be automatically loaded by the bootloader, making the classes and functions globally available.
