<?php

namespace JPeters\Architect\Tests\Plans;

use JPeters\Architect\Plans\TextField\TextField;

class TextFieldPlanTest extends PlanTestCase
{
    protected function planClass(): string
    {
        return TextField::class;
    }
}
