<?php

namespace WendellAdriel\LaravelCaller;

use Illuminate\Support\ServiceProvider;

class LaravelCallerServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/../config/caller.php' => base_path('config/caller.php'),
            ],
            'config'
        );
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/caller.php', 'caller');
    }
}
