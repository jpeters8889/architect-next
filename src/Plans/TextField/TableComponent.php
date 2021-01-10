<?php

namespace JPeters\Architect\Plans\TextField;

use JPeters\Architect\Plans\BaseTableComponent;

class TableComponent extends BaseTableComponent
{
    protected function view(): string
    {
        return 'architect::plans.text-field.table';
    }
}
