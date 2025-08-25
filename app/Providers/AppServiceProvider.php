<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('cms.layouts.master', function ($view) {
            $title = 'e-Commerce';

            $view->with('title', $title); 
        });

        View::composer('frontend.layouts.master', function ($view) {
            $settings = Setting::pluck('value', 'id')->toArray();
            $categories = Category::where('status', 1)->orderBy('name', 'asc')->get();
            
            $view->with([
                'webSettings' => $settings,
                'menuCategories' => $categories
            ]); 

        });

    }
}
