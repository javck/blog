<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Faker\Generator::class,function(){
            return \Faker\Factory::create("zh_TW");
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //全域
        //view()->share('name','vincent');
        view()->composer(['blogs.*'],function($view){
            $view->with('name','vincent');
        });

    }
}
