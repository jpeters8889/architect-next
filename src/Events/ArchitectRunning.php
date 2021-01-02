<?php

declare(strict_types=1);

namespace JPeters\Architect\Events;

use Illuminate\Http\Request;
use Illuminate\Foundation\Events\Dispatchable;

class ArchitectRunning
{
    use Dispatchable;

    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
