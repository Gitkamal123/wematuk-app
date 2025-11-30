<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; 
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {        
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Share getQueryString function ke semua view
        View::composer('*', function ($view) {
            $view->with('getQueryString', function() {
                $queryParams = request()->except('page');
                return $queryParams ? '&' . http_build_query($queryParams) : '';
            });
        });
    }
}