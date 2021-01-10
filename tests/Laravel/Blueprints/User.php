<?php

namespace JPeters\Architect\Tests\Laravel\Blueprints;

use JPeters\Architect\Blueprints\Blueprint;
use JPeters\Architect\Cards\Card;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\TextField\Textfield;
use JPeters\Architect\Tests\Laravel\Cards\UserCard;

class User extends Blueprint
{
    public function model(): string
    {
        return \JPeters\Architect\Tests\Laravel\Models\User::class;
    }

    public function plans(): array
    {
        return [
//            new Textfield('name'),
//
//            new Textfield('email'),
//
//            new Textfield('password'),
//
//            (new Textfield('api_token'))->hideFromIndexOnMobile(),
//
//            (new DateTime('created_at'))->hideOnForms(),
//
//            (new DateTime('updated_at'))->hideOnIndex()->hideOnForms(),
        ];
    }

    public function blueprintBuilding(): string
    {
        return 'Foo Bar';
    }
}
