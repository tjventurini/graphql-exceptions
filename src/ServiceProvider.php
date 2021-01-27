<?php

namespace Tjventurini\GraphQLExceptions;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Tjventurini\GraphQLExceptions\Services\GraphQLExceptionService;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('graphql-exceptions-service', function ($app) {
            return new GraphQLExceptionService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // setup translation files
        $this->setupTranslations();

        // setup package config
        $this->mergeConfigFrom(__DIR__ . '/../config/graphql-exceptions.php', 'graphql-exceptions');

        // enable package config to be published
        $this->publishes([
            __DIR__ . '/../config/graphql-exceptions.php', config_path('graphql-exceptions.php')
        ]);
    }

    /**
     * Setup translations.
     *
     * @return void
     * @throws BindingResolutionException
     */
    private function setupTranslations(): void
    {
        // setup path to load translations
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'graphql-exceptions');

        // publish translations
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/graphql-exceptions'),
        ], 'lang');
    }
}
