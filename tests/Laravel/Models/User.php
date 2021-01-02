<?php

namespace JPeters\Architect\Tests\Laravel\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $guarded = [];
}
