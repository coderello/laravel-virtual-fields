<?php

namespace Coderello\VirtualFields\Tests;

use Orchestra\Testbench\TestCase;
use Coderello\VirtualFields\Providers\VirtualFieldsServiceProvider;

abstract class AbstractTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            VirtualFieldsServiceProvider::class,
        ];
    }
}
