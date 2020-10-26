<?php

namespace Tjventurini\GraphQLExceptions;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;

class GraphQLExceptionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupTranslations();
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
