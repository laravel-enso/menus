<?php

namespace LaravelEnso\MenuManager\app\Enums;

use LaravelEnso\Helpers\Classes\AbstractEnum;

class PagesBreadcrumbs extends AbstractEnum
{
    public function __construct()
    {
        $this->data = [
            'createResource' => __('create resource'),
            'reorder'        => __('reorder'),
            'editTexts'      => __('edit texts'),
        ];
    }
}
