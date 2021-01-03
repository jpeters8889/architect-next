<?php

namespace JPeters\Architect\Http\Controllers;

use Illuminate\View\View;

class BlueprintController
{
    public function index(): View
    {
        return view('architect::blueprints.index');
    }
}
