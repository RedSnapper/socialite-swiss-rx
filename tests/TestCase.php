<?php

namespace RedSnapper\SwissRx\Tests\Feature\Tests;

use RedSnapper\SwissRx\Tests\Feature\SwissRxServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
  public function setUp(): void
  {
    parent::setUp();
    // additional setup
  }

  protected function getPackageProviders($app): array
  {
    return [
      SwissRxServiceProvider::class,
    ];
  }

  protected function getEnvironmentSetUp($app)
  {
    // perform environment setup
  }
}
