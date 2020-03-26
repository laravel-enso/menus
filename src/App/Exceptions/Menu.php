<?php

namespace LaravelEnso\Menus\App\Exceptions;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class Menu extends ConflictHttpException
{
    public static function usedAsDefault()
    {
        return new self(
            __('The menu cannot be deleted because it is set as default for at least one role')
        );
    }

    public static function hasChildren()
    {
        return new self(__('The menu cannot be deleted because it has children'));
    }
}
