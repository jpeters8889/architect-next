<?php

namespace JPeters\Architect\Tests\Laravel\Models;

use Illuminate\Database\Eloquent\Model;

class BlogType extends Model
{
    protected $guarded = [];

    protected $visible = ['id', 'type'];

    public function blog()
    {
        return $this->hasMany(Blog::class, 'type_id');
    }
}
