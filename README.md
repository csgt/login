# CSGT Login

Configurable login, registration, password reset, social login, profile, password-expiration, and TOTP screens for Laravel applications.

## Compatibility

This release supports Laravel 5.x through Laravel 13.x. The PHP version is determined by the Laravel release used by the host application; the package itself uses PHP 5.5-compatible syntax.

| Laravel | Typical PHP range | Socialite |
|---|---|---|
| 5.x | 5.5.9+ (subject to the selected 5.x release) | 1.x–4.x |
| 6.x–8.x | Framework-supported versions | 5.x |
| 9.x–12.x | Framework-supported versions | 5.x |
| 13.x | 8.3+ | 5.23.1+ |

Laravel 5–10 are no longer supported upstream. Compatibility is retained for existing applications, but those applications should be isolated and upgraded because they no longer receive framework security fixes.

## Installation

```bash
composer require csgt/login
```

Laravel 5.5 and newer discover the service provider and `Login` alias automatically. On Laravel 5.0–5.4, add these entries to `config/app.php`:

```php
'providers' => array(
    Csgt\Login\LoginServiceProvider::class,
),

'aliases' => array(
    'Login' => Csgt\Login\Login::class,
),
```

Publish the configuration and translations:

```bash
php artisan vendor:publish --provider="Csgt\Login\LoginServiceProvider"
```

The package expects the application to provide an authenticatable user model and the tables named in `config/csgtlogin.php`. It does not run or publish destructive database migrations.

## Configuration

The default user table is `authusuarios`, with `usuarioid` as its key and `email` as its login field. Change those values in `config/csgtlogin.php` to match the host application.

For OAuth, set provider credentials through environment variables:

```dotenv
FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
FACEBOOK_REDIRECT_URI=https://example.test/oauth/facebook/callback

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=https://example.test/oauth/google/callback
```

The standard Laravel `services.facebook` and `services.google` configuration is also honored. OAuth providers are disabled by default.

Registration uses the model configured at `auth.providers.users.model` (or the legacy Laravel 5 `auth.model` key). Its fillable attributes must include the fields enabled for registration.

The profile view extends `template/template`, preserving the package's historical host-layout contract. Applications may publish and override the package views when using another layout.

## Routes

The package registers the historical endpoints, including:

- `GET /login` and `POST /auth/login`
- `GET|POST /auth/register`
- `GET /logout`
- `GET /password/email`, `POST /password/email`, and password reset routes
- `GET /oauth/{provider}` and its callback
- authenticated profile and two-step routes

Use `csgtlogin.routeextras` to add a prefix, domain, or middleware to the complete route group.

## Testing

```bash
composer test
```

The CI matrix resolves and tests the package against Laravel 5, 6, 7, 8, 9, 10, 11, 12, and 13.

## License

MIT. See [LICENSE.md](LICENSE.md).
