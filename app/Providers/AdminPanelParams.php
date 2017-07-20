<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use View;

class AdminPanelParams extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('m', (new \Moment\Moment('@'.time(), 'CET')));
        View::share('timeNow', (new \Moment\Moment('@'.time(), 'CET'))->subtractDays(env('profitDay'))->format('Y-m-d'));
        View::share('todaysProfitsCount', \App\Profit::where('status', 0)->where('created_at', '>', (new \Moment\Moment('@'.time(), 'CET'))->subtractDays(env('profitDay'))->format('Y-m-d').' 00:00:00')->where('created_at', '<', (new \Moment\Moment('@'.time(), 'CET'))->subtractDays(env('profitDay'))->format('Y-m-d').' 23:59:59')->count());
        View::share('todaysProfitsSentCount', \App\Profit::where('status', 1)->where('created_at', '>', (new \Moment\Moment('@'.time(), 'CET'))->subtractDays(env('profitDay'))->format('Y-m-d').' 00:00:00')->where('created_at', '<', (new \Moment\Moment('@'.time(), 'CET'))->subtractDays(env('profitDay'))->format('Y-m-d').' 23:59:59')->count());
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
