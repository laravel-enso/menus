<?php

namespace LaravelEnso\MenuManager\app\Classes;

use Illuminate\Support\Collection;
use LaravelEnso\MenuManager\app\Models\Menu;

class BreadcrumbsBuilder
{
    private $breadcrumbs;
    private $menus;
    private $currentMenu;

    public function __construct(Collection $menus)
    {
        $this->menus = $menus;
        $this->breadcrumbs = collect();
        $this->currentMenu = (new CurrentMenuDetector($this->menus))->get();
        $this->build();
    }

    public function get()
    {
        return $this->breadcrumbs;
    }

    private function build()
    {
        $currentMenu = $this->currentMenu;

        while ($currentMenu) {
            $this->prependBreadcrumb($currentMenu);

            $currentMenu = $currentMenu->parent;
        }

        $this->appendTermination();
    }

    private function appendTermination()
    {
        $termination = $this->getRouteEndingSegment();

        if (!$termination) {
            return;
        }

        $termination = config('breadcrumbs.'.$termination)
            ? __(config('breadcrumbs.'.$termination))
            : __($termination);

        $this->pushBreadcrumb($termination);
    }

    private function prependBreadcrumb(Menu $currentMenu)
    {
        $this->breadcrumbs->prepend([
            'label' => strtolower(__($currentMenu->name)),
            'link'  => $currentMenu->link,
        ]);
    }

    private function pushBreadcrumb(string $termination)
    {
        $this->breadcrumbs->push([
            'label' => $termination,
            'link'  => request()->path(),
        ]);
    }

    private function getRouteEndingSegment()
    {
        $routeArray = explode('.', request()->route()->getName());

        return count($routeArray) > 1 ? end($routeArray) : null;
    }
}
