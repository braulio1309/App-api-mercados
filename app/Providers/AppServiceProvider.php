<?php

namespace App\Providers;

use Illuminate\Support\Pluralizer;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Pluralizer::useLanguage('spanish');

        Sanctum::usePersonalAccessTokenModel(\App\Models\PersonalAccessToken::class);
    }
}
