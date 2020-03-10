<?php

namespace LaravelAdmin;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LaravelAdminServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerLaravelAdmin();

        $this->publishConfigs();
        $this->publishViews();
        $this->publishAssets();
    }

    public function boot()
    {
        $this->bootBladeDirective();
    }

    public function registerLaravelAdmin()
    {
        $this->app->singleton('laraveladmin', function ($app) {
            return new LaravelAdmin();
        });
    }

    protected function path($path)
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . ltrim($path, '\\/');
    }

    protected function publishConfigs()
    {
        $sourceConfigFile = $this->path('config' . DIRECTORY_SEPARATOR . 'laraveladmin.php');
        $this->publishes([
            $sourceConfigFile => config_path('laraveladmin.php')
        ], 'laraveladmin-config');

        $this->mergeConfigFrom($sourceConfigFile, 'laraveladmin');
    }

    protected function publishViews()
    {
        $this->loadViewsFrom($this->path('resources' . DIRECTORY_SEPARATOR . 'views'), 'laraveladmin');
    }

    protected function publishAssets()
    {
        $this->publishes([
            $this->path('public' . DIRECTORY_SEPARATOR . 'laraveladmin') => public_path(config('laraveladmin.publish.assets.path'))
        ], 'laraveladmin-public');
    }

    protected function bootBladeDirective()
    {
        Blade::directive('css', function ($src) {
            $attrs = [
                'media' => 'all',
                'type' => 'text/css',
                'rel' => 'stylesheet',
                'href' => $this->app->make('laraveladmin')->assetsUrl(trim($src, '\'"'))
            ];

            return new HtmlString('<link' . \Html::attributes($attrs) . '>');
        });

        Blade::directive('js', function ($src) {
            $attrs = ['src' => $this->app->make('laraveladmin')->assetsUrl(trim($src, '\'"'))];

            return new HtmlString('<script' . \Html::attributes($attrs) . '></script>');
        });
    }
}
