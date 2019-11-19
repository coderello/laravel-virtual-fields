<?php

namespace Coderello\VirtualFields\Tests\VirtualFields\Post;

use Coderello\VirtualFields\VirtualField;
use Illuminate\Support\Facades\DB;

class CommentsNumber extends VirtualField
{
    public function getVirtualValue()
    {
        return DB::table('comments')
            ->whereColumn('post_id', 'posts.id')
            ->selectRaw('COUNT(*)');
    }

    public function getCast(): ?string
    {
        return 'integer';
    }
}
