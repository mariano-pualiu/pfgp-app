<?php

namespace App\Providers;

// use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // As per: https://github.com/spatie/laravel-medialibrary/issues/37
        // $loader = AliasLoader::getInstance();
        // $loader->alias(
        //     \Spatie\MediaLibrary\MediaCollections\Models\Media::class,
        //     \App\Models\Spatie\MediaLibrary\Media::class
        // );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
