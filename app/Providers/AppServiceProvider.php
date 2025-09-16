<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        View::composer('cms.layouts.master', function ($view) {
            $title = 'e-Commerce';

            $view->with('title', $title); 
        });

        View::composer('frontend.layouts.master', function ($view) {
            $categories = Category::where('status', 1)->orderBy('name', 'asc')->get();
            
            #START CART
            $carts = collect();
            if (Auth::check()) {
                $carts = Cart::with('product')
                            ->where('user_id', Auth::id())
                            ->get();
            }
            #END CART
            
            $view->with([
                'menuCategories' => $categories,
                'carts' => $carts
            ]); 

        });
         View::composer('frontend.*', function ($view) {
            $settings = Setting::pluck('value', 'id')->toArray();
            $view->with([
                'webSettings' => $settings,
            ]); 

        });

    }
}
