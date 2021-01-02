<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use JPeters\Architect\Tests\Laravel\Models\Blog;

$factory->define(Blog::class, function (Faker $faker) {
    return [
        'title' => $title = $faker->sentence,
        'slug' => \Illuminate\Support\Str::slug($title),
        'body' => $faker->paragraphs(3, true),
    ];
});
