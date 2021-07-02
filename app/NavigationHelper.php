<?php

namespace App;

use Statamic\Facades\Nav as NavigationRepository;
use Statamic\Structures\Nav;

class NavigationHelper
{
    protected $navigation;

    public static function all()
    {
        return NavigationRepository::all();
    }

    public static function find($id)
    {
        $navigation = NavigationRepository::find($id);

        return new static($navigation);
    }

    public static function findByHandle($handle)
    {
        $navigation = NavigationRepository::findByHandle($handle);

        return new static($navigation);
    }

    public function __construct(Nav $navigation)
    {
        $this->navigation = $navigation;
    }

    public function __toString()
    {
        return $this->render();
    }

    public function render($navigation = null)
    {
        if (is_null($navigation)) {
            $navigation = tag('nav', ['handle'=> $this->navigation->handle()]);
        }

        return view('navigation.navigation', ['navigationHelper' => $this, 'navigation' => $navigation]);
    }
}
