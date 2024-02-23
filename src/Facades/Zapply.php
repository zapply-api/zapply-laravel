<?php

namespace Zapply\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class Zapply extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'zapply';
    }
}
