<?php

namespace App\View\Components\layouts;

use Illuminate\View\Component;

class layout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return <<<'blade'
<div>
    <!-- It is never too late to be what you might have been. - George Eliot -->
</div>
blade;
    }
}
