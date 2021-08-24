<?php

namespace RedSnapper\SwissRx\Tests\Feature;

use Mockery;
use Orchestra\Testbench\TestCase;

class SwissRxTest extends TestCase {

    /** @test */
    public function it_authenticates_user_via_swiss_rx_service()
    {
        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('getId')
            ->andReturn(1234567890)
            ->shouldReceive('getEmail')
            ->andReturn('email@test.com');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);
    }
}
