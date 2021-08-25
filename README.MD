#Sociaite/Swiss-Rx
### A Laravel Socialite driver for Swiss RX, an authentication system for Swiss healthcare professionals


[![Latest Version on Packagist](https://img.shields.io/packagist/v/vendor_slug/package_slug.svg?style=flat-square)](https://packagist.org/packages/vendor_slug/package_slug)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/vendor_slug/package_slug/run-tests?label=tests)](https://github.com/redsnapper/socialite-swiss-rx/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/vendor_slug/package_slug.svg?style=flat-square)](https://packagist.org/packages/vendor_slug/package_slug)

---
This repo can be used to provide OAuth authentication with [Swiss Rx] (https://swiss-rx-login.ch/).

## Installation

You can install the package via composer:

```bash
composer require redsnapper/socialite-swissrx
```

Add event listener mapping in your `EventServiceProvider.php`

```php
//Providers\EventServiceProvider.php

use RedSnapper\SwissRx\SwissRxExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;

protected $listen = [
        //...
        SocialiteWasCalled::class => [
            SwissRXExtendSocialite::class
        ],
    ];
```

Then go to your services.php and add swissrx credentials. When using your callback, **make sure it's registered with swiss-rx first**.
```php
//config\services.php

//...
'swissrx' => [
    'client_id' => env('SWISS_RX_KEY'),
    'client_secret' => env('SWISS_RX_SECRET'),
    'redirect' => config('app.url') . "/swiss-rx/callback",
],
```

And finally add your Swiss-Rx key and secret to the `.env` file:
```php

SWISS_RX_KEY=<your-key>
SWISS_RX_SECRET=<your-secret>
```

## Usage

Register your routes
```php
//web.php

Route::get('/swiss-rx/login', [LoginController::class, 'redirectToProvider'])->name('login');
Route::get('/swiss-rx/callback', [LoginController::class, 'handleProviderCallback'])->name('login.callback');
```

Then in your controller call the `redirectToProvider()` and `handleProviderCallbac()`:
```php
//Http\Controllers\LoginController.php

use Laravel\Socialite\Facades\Socialite;


public function redirectToProvider()
{
    return Socialite::driver('swissrx')->with([
        'lang' => request()->get('lang', 'en')
    ])->redirect();
}

public function handleProviderCallback()
{
    $swissRxUser = Socialite::driver('swissrx')->user();

    retunr $swissRxUser;
}

```

## Testing

```bash
vendor/bin/phpunit
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
