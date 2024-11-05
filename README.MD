#Sociaite/Swiss-Rx
### A Laravel Socialite driver for Swiss RX, an authentication system for Swiss healthcare professionals


[![Latest Version on Packagist](https://img.shields.io/packagist/v/vendor_slug/package_slug.svg?style=flat-square)](https://packagist.org/packages/redsnapper/socialite-swissrx)
[![GitHub Tests Action Status](https://github.com/redsnapper/socialite-swiss-rx/workflows/run-tests/badge.svg)](https://github.com/redsnapper/socialite-swiss-rx/actions)
[![Total Downloads](https://img.shields.io/packagist/dt/redsnapper/socialite-swissrx.svg?style=flat-square)](https://packagist.org/packages/redsnapper/socialite-swissrx)

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
    'token_leeway'  => env('SWISS_RX_TOKEN_LEEWAY'), // optional - you can use this if you are getting 'Cannot handle token prior to...' exceptions
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

Then in your controller call the `redirectToProvider()` and `handleProviderCallback()`:
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

### Scopes
By default the `anonymous` scope is used, which will not return any user data other than their ID. To retrieve user data use the socialite method `setScopes()` to request the `personal` scope:
```php
public function redirectToProvider()
{
    return Socialite::driver('swissrx')->with([
        'lang' => request()->get('lang', 'en')
    ])
    ->setScopes(['personal'])
    ->redirect();
}
```

## Older style secrets
Swiss RX previously provided shorter secrets that were 9 characters long, where these are provided there is a need to repeat the secret twice to form the key used to decode the JWT token passed from Swiss RX. The package has been updated in v1.2 to now also support the new longer length secrets.

## Testing

```bash
vendor/bin/phpunit
```

## Changelog

Please see [CHANGELOG](https://github.com/RedSnapper/socialite-swiss-rx/blob/main/CHANGELOG.MD) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/RedSnapper/socialite-swiss-rx/blob/main/.github/workflows/CONTRIBUTING.MD) for details.

## License

The MIT License (MIT). Please see [License File](https://github.com/RedSnapper/socialite-swiss-rx/blob/main/LICENCE.MD) for more information.
