<?php

namespace Coderello\VirtualFields\Tests\Models;

use Coderello\VirtualFields\HasVirtualFieldsTrait;
use Coderello\VirtualFields\Tests\VirtualFields\Post\CommentsNumber;
use Coderello\VirtualFields\VirtualField;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasVirtualFieldsTrait;

    protected $fillable = [
        'title',
        'content',
    ];

    public function virtualFields(): array
    {
        return [
            'comments_number' => new CommentsNumber,
        ];
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
