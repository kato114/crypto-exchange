<?php

namespace App\Providers;

use App\Category;
use App\GeneralSettings;
use App\Menu;
use App\Post;
use App\Social;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $data['basic'] =  GeneralSettings::first();
       $data['gnl'] =  GeneralSettings::first();
       $data['menus'] =  Menu::all();
       $data['social'] =  Social::all();
        View::share($data);



        View::composer('partials.latest-blog', function ($view) {
            $view->with('post',Post::latest()->take(5)->get());
        });
        View::composer('partials.category-list', function ($view) {
            $view->with('category',Category::whereStatus(1)->get());
        });


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
