<?php

namespace Coderello\VirtualFields\Tests;

use Coderello\VirtualFields\Tests\Models\Comment;
use Coderello\VirtualFields\Tests\Models\Post;
use Coderello\VirtualFields\Tests\VirtualFields\Post\CommentsNumber;

class VirtualFieldsTest extends AbstractTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testFieldsAppears()
    {
        /** @var Post $post */
        $post = factory(Post::class)->create();

        $post->refresh();

        $this->assertEquals(0, $post->getAttribute('comments_number'));

        $post->comments()->saveMany(
            factory(Comment::class, 10)->make()
        );

        $post->refresh();

        $this->assertEquals(10, $post->getAttribute('comments_number'));
    }

    public function testOrdering()
    {
        /** @var Post $firstPost */
        $firstPost = factory(Post::class)->create();

        $firstPost->comments()->saveMany(
            factory(Comment::class, 6)->make()
        );

        /** @var Post $secondPost */
        $secondPost = factory(Post::class)->create();

        $secondPost->comments()->saveMany(
            factory(Comment::class, 10)->make()
        );

        /** @var Post $secondPost */
        $thirdPost = factory(Post::class)->create();

        $thirdPost->comments()->saveMany(
            factory(Comment::class, 2)->make()
        );

        $this->assertEquals(
            collect([$thirdPost, $firstPost, $secondPost])
                ->pluck('id')
                ->toArray(),
            Post::query()
                ->orderBy((new CommentsNumber)->getVirtualExpression())
                ->pluck('id')
                ->toArray()
        );
    }

    public function testFiltering()
    {
        /** @var Post $firstPost */
        $firstPost = factory(Post::class)->create();

        $firstPost->comments()->saveMany(
            factory(Comment::class, 6)->make()
        );

        /** @var Post $secondPost */
        $secondPost = factory(Post::class)->create();

        $secondPost->comments()->saveMany(
            factory(Comment::class, 10)->make()
        );

        /** @var Post $secondPost */
        $thirdPost = factory(Post::class)->create();

        $thirdPost->comments()->saveMany(
            factory(Comment::class, 2)->make()
        );

        $this->assertEquals(
            collect([$firstPost, $secondPost])
                ->pluck('id')
                ->toArray(),
            Post::query()
                ->where((new CommentsNumber)->getVirtualExpression(), '>', 5)
                ->pluck('id')
                ->toArray()
        );
    }
}
