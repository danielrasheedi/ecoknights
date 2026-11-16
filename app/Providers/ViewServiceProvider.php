<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $userRole = session('user_role');
            
            $layout = match($userRole) {
                'Administrator' => 'layout.administrator',
                default => 'layout.volunteer'
            };
            
            $view->with('layout', $layout);
        });
    }

    /**
     * Register services.
     */
    public function register()
    {
        //
    }
}