<?php

namespace Zapply\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Zapply\Zapply as ZapplySdk;

class Zapply extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ZapplySdk::class;
    }
}
