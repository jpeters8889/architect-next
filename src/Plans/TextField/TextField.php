<?php

namespace JPeters\Architect\Plans\TextField;

use JPeters\Architect\Plans\Plan;

class TextField extends Plan
{
    public function tableComponent(): string
    {
        return TableComponent::class;
    }
}
