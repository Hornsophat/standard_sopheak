<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use DB;
use View;

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
        // $profile_settings =  DB::table('settings')->select('*')->get();
        // $profile_setting =[];
        // foreach ($profile_settings as $value) {
        //     $profile_setting[$value->key] = $value->value;
        // }
        // View::share('profile_setting', $profile_setting);
        Carbon::serializeUsing(function ($carbon) {
            return $carbon->format('U');
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
