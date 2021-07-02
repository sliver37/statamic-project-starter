<?php

namespace App;

use Illuminate\Support\Str;
use Statamic\Facades\Entry;
use Statamic\Facades\Nav as NavigationRepository;
use Statamic\Facades\Site;
use Statamic\Modifiers\Modify;
use Statamic\Structures\Nav as StatamicNav;
use Statamic\Structures\NavTree;
use Statamic\Tags\Loader as TagLoader;
use Statamic\View\Antlers\Parser;

class Navigation
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

    public function __construct(StatamicNav $navigation)
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
            $navigation = app(TagLoader::class)->load('nav', [
                'parser'     => app(Parser::class),
                'params'     => ['handle' => $this->navigation->handle()],
                'content'    => null,
                'context'    => null,
            ])->index();
        }

        return view('navigation.navigation', ['navigationHelper' => $this, 'navigation' => $navigation]);
    }
}
