<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NavItem extends Component
{
    /**
     * The item we are rendering
     *
     * @var object
     */
    public $item;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.nav-item');
    }
}
