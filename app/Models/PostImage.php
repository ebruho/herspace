<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostImage extends Model
{
    public $timestamps = false;

    protected $fillable = ['post_id', 'image_url', 'caption', 'order_index'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}