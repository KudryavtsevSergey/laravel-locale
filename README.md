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

After:

```shell script
php artisan migrate
```
