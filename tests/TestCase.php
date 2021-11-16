<?php

namespace ArtARTs36\ArtisanDocumentator\Tests;

use ArtARTs36\ArtisanDocumentator\Providers\ArtisanDocumentatorServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Illuminate\Contracts\Console\Kernel;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ArtisanDocumentatorServiceProvider::class,
        ];
    }
}
