<?php

namespace JPeters\Architect\Tests\Laravel\Models;

use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    public function blog()
    {
        return $this->belongsToMany(Blog::class, 'blog_assigned_tags', 'tag_id', 'blog_id');
    }
}
