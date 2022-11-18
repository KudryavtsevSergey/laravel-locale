# Laravel locale package

## Installation

composer.json

```json
{
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/KudryavtsevSergey/laravel-locale.git"
        }
    ],
    "require": {
      "sun/locale": "dev-master"
    }
}
```

After updating composer, add the service provider to the ```providers``` array in ```config/app.php```

```php
[
    Sun\Locale\LocaleServiceProvider::class,
];
```

And add alias:

```php
[
    'Locale' => Sun\Locale\Facade::class,
];
```

Then:

```shell script
php artisan migrate
```
