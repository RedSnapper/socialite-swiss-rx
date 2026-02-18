<?php

namespace RedSnapper\SwissRx;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Arr;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class SwissRx extends AbstractProvider
{

    /**
     * Unique SwissRxTest Identifier.
     */
    public const IDENTIFIER = 'SWISSRX';

    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = ['anonymous'];

    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            "https://swiss-rx-login.ch/oauth/authorize",
            $state
        );
    }

    protected function getTokenUrl()
    {
        return "https://swiss-rx-login.ch/oauth/token";
    }

    protected function getUserByToken($token)
    {
        $this->enableTokenValidationLeewayIfConfigured();

        return (array)JWT::decode($token, new Key(config('services.swissrx.client_secret'), 'HS256'));
    }

    protected function mapUserToObject(array $user)
    {
        return (new SwissRxUser())->setRaw($user)->map([
            'id'    => $user['nameid'],
            'name'  => Arr::get($user, 'unique_name'),
            'email' => Arr::get($user, 'email'),
        ]);
    }

    private function enableTokenValidationLeewayIfConfigured()
    {
        $leeway = Arr::get($this->config, 'token_leeway');
        if (is_numeric($leeway)) {
            JWT::$leeway = $leeway;
        }
    }

    public static function additionalConfigKeys(): array
    {
        return ['token_leeway'];
    }
}
