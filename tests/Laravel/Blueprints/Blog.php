<?php

namespace JPeters\Architect\Tests\Laravel\Blueprints;

use JPeters\Architect\Blueprints\Blueprint;
use JPeters\Architect\Plans\TextField;
use JPeters\Architect\Tests\Laravel\Models\Blog as BlogModel;

class Blog extends Blueprint
{
    public function model(): string
    {
        return BlogModel::class;
    }

    public function plans(): array
    {
        return [
            TextField::build('title'),
        ];
    }

    public function displayCount(): int
    {
        return BlogModel::query()->count();
    }
}
