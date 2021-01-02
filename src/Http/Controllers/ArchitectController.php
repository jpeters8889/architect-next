<?php

namespace JPeters\Architect\Http\Controllers;

class ArchitectController
{
    public function __invoke()
    {
        return view('architect::architect');
    }
}
