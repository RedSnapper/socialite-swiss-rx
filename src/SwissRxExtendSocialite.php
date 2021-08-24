<?php

namespace RedSnapper\SwissRx;

use SocialiteProviders\Manager\SocialiteWasCalled;

class SwissRxExtendSocialite {

    /**
     * Execute the provider.
     *
     * @param  SocialiteWasCalled  $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('swissrx', SwissRx::class);
    }
}