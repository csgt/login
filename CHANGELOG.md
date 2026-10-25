# Changelog

All notable changes to `csgt/login` are documented here.

## Unreleased

### Added

- Laravel 5.x through 13.x dependency constraints and CI coverage.
- Package auto-discovery and configurable login throttling.
- Package-owned authentication, registration, and password-reset flows.

### Changed

- Replaced removed Laravel auth traits, implicit controller routes, route filters, `Input`, `lists()`, and legacy model configuration APIs.
- Replaced the implicit Laravel Collective HTML dependency with native Blade markup.
- Adapted the legacy `Login::consumer()` API to Laravel Socialite.

### Security

- Removed embedded OAuth client credentials from the distributed configuration.
- Regenerate sessions after login and invalidate them on logout where supported.
