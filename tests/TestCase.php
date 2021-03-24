<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Installs passport
     */
    protected function passportInstall(): void
    {
        Artisan::call('passport:install --force');
    }
}
