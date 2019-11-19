<?php

namespace Coderello\VirtualFields\Tests\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content',
    ];
}
