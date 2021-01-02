<?php

namespace JPeters\Architect\Http\Views;

use Illuminate\View\View;
use JPeters\Architect\Blueprints\Manager;
use JPeters\Architect\Blueprints\Navigator;

class NavigationComposer
{
    private Navigator $blueprintNavigator;

    public function __construct(Navigator $blueprintNavigator)
    {
        $this->blueprintNavigator = $blueprintNavigator;
    }

    public function compose(View $view)
    {
        $view->with('navigation', $this->blueprintNavigator->render());
    }
}
