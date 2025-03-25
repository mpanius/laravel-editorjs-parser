<?php

namespace Ixbtcom\LaravelEditorJsParser;

use Illuminate\Support\ServiceProvider;

class LaravelEditorJsParserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-editorjs-parser.php', 'laravel-editorjs-parser');

        $this->app->singleton('laravel-editorjs-parser', static function ($app) {
            return new LaravelEditorJsParser;
        });
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-editorjs-parser');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-editorjs-parser.php' => config_path('laravel-editorjs-parser.php'),
            ], 'laravel-editorjs-parser-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => $this->app->resourcePath('views/vendor/laravel-editorjs-parser'),
            ], 'laravel-editorjs-parser-views');
        }
    }
}
