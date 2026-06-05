<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Forza Laravel a usare APP_URL per generare tutti gli URL
        // (necessario in Codespaces dove le richieste passano attraverso un proxy)
        URL::forceRootUrl(config('app.url'));

        // Forza HTTPS se APP_URL usa https
        if (str_starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}