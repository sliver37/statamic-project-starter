<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Nav extends Component
{
    public $handle;
    public $isMain;
    public $hasToggle;
    public $alwaysMobile;
    public $icons;
    public $includeHome;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($handle, $isMain = false, $hasToggle = false, $alwaysMobile = false, $icons = null, $includeHome = true)
    {
        $this->handle = $handle;
        $this->isMain = (bool) json_decode($isMain);
        $this->hasToggle = (bool) json_decode($hasToggle);
        $this->alwaysMobile = (bool) json_decode($alwaysMobile);
        $this->icons = $icons;
        $this->includeHome = (bool) json_decode($includeHome);

        // If always mobile is set, toggle must be true
        if ($this->alwaysMobile) {
            $this->hasToggle = true;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.nav');
    }
}
