<?php

namespace RedSnapper\SwissRx;

use Illuminate\Support\Arr;
use SocialiteProviders\Manager\OAuth2\User;

class SwissRxUser extends User
{
    public function getAccessGroups(): array
    {
        $accessGroups = Arr::get($this->getRaw(), 'AccGrp', '');
        if (filled($accessGroups)) {
            return array_map('trim', explode(',', $accessGroups));
        }

        return [];
    }
}
