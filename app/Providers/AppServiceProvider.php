<?php

namespace App\Providers;

use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Guard $auth)
    {
        Schema::defaultStringLength(191);
        Carbon::setLocale('pt_BR');

        // Atrás de proxy/CDN o Laravel não enxerga o HTTPS e gera URLs http://,
        // que o navegador bloqueia (mixed content => "TypeError: Failed to fetch").
        if (config('app.env') === 'production' || request()->server('HTTPS') || request()->header('X-Forwarded-Proto') === 'https') {
            URL::forceScheme('https');
        }

        view()->composer('*', function ($view) use ($auth) {

            $social = DB::table('consulting_environments')
                ->first();

            $user = User::find(1);

            $view->with('data', [
                'social' => @$social,
                'user' => @$user
            ]);
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
