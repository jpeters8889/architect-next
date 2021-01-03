<?php

namespace JPeters\Architect\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JPeters\Architect\Blueprints\Blueprint;
use JPeters\Architect\Blueprints\Manager;

class BlueprintRequest extends FormRequest
{
    public function resolve(): Blueprint
    {
        /** @var Manager $manager */
        $manager = app(Manager::class);

        return $manager->resolve($this->route('blueprint'));
    }

    public function rules(): array
    {
        return [];
    }
}
