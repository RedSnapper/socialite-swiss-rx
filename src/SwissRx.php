<?php

namespace RedSnapper\SwissRx;

use Firebase\JWT\JWT;
use Illuminate\Support\Arr;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class SwissRx extends AbstractProvider {

    /**
     * Unique SwissRx Identifier.
     */
    public const IDENTIFIER = 'SWISSRX';

    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = ['personal'];

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
        return (array)  JWT::decode($token, str_repeat(config('services.swissrx.client_secret'), 2), ['HS256']);
    }

    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['nameid'],
            'name' => Arr::get($user, 'unique_name'),
            'email' => Arr::get($user, 'email'),
        ]);
    }
}