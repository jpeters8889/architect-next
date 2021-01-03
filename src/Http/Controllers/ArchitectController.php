<?php

namespace JPeters\Architect\Http\Controllers;

use Illuminate\View\View;

class ArchitectController
{
    public function __invoke(): View
    {
        return view('architect::architect');
    }
}
