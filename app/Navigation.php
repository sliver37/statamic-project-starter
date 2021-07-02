<?php

namespace App;

use Statamic\Facades\Nav as NavigationRepository;

class Navigation
{
    protected $items;

    public static function all()
    {
        return NavigationRepository::all();
    }

    public static function find($id)
    {
        return static::tag('nav', ['handle' => NavigationRepository::find($id)->handle()]);
    }

    public static function findByHandle($handle)
    {
        return static::tag('nav', ['handle'=> $handle]);
    }

    public static function tag(string $name, array $params = [], array $context = [])
    {
        return new static(tag($name, $params, $context));
    }

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function __toString()
    {
        return $this->render($this->items);
    }

    public function render(array $items = [])
    {
        if (empty($items)) {
            $items = $this->items;
        }

        return view('navigation.navigation', ['navHelper' => $this, 'navItems' => $items]);
    }
}
