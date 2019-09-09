# Laravel locale package

## Installation

cd to project.

```shell script
mkdir packages/sun/locale;

git clone https://github.com/barryvdh/laravel-ide-helper.git
```

in your composer.json

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "packages/sun/locale",
            "options": {
                "symlink": true
            }
        }
    ],
    "require": {
      "sun/locale": "dev-master"
    }
}
```

After updating composer, add the service provider to the ```providers``` array in ```config/app.php```

```php
Sun\Locale\LocaleServiceProvider::class,
```

After:

```shell script
php artisan migrate
```
