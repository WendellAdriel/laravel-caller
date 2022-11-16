<?php

namespace WendellAdriel\LaravelCaller\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelCaller extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-caller';
    }
}
