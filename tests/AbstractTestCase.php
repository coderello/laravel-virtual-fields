<?php

namespace Coderello\VirtualFields\Tests;

use Coderello\VirtualFields\Tests\Migrations\CreateCommentsTable;
use Coderello\VirtualFields\Tests\Migrations\CreatePostsTable;
use Coderello\VirtualFields\Tests\Models\Comment;
use Coderello\VirtualFields\Tests\Models\Post;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase;
use Coderello\VirtualFields\Providers\VirtualFieldsServiceProvider;

abstract class AbstractTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();

        $this->setUpFactories();
    }

    protected function getPackageProviders($app)
    {
        return [
            VirtualFieldsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
        $app['config']->set('app.key', 'base64:'.base64_encode(
            Encrypter::generateKey($app['config']['app.cipher'])
        ));
    }

    protected function setUpDatabase()
    {
        (new CreatePostsTable)->up();
        (new CreateCommentsTable)->up();
    }

    protected function setUpFactories()
    {

        $factory = app(Factory::class);

        $factory->define(Post::class, function (Generator $faker) {
            return [
                'title' => $faker->words(3, true),
                'content' => $faker->sentences(15, true),
            ];
        });

        $factory->define(Comment::class, function (Generator $faker) {
            return [
                'content' => $faker->sentences(3, true),
            ];
        });
    }
}
