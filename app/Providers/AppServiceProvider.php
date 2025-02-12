<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('settings', function () {
            $settings = Setting::pluck('value', 'key')->toArray();
            return $settings;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('categories', Category::where('menu_top', 1)->where('status', 1)->get());
            $view->with('subCategories', SubCategory::where('status', 1)->get());
        });
    }
}
