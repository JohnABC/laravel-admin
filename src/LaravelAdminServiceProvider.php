<?php

namespace LaravelAdmin;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LaravelAdminServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->publishConfigs();
        $this->publishViews();
        $this->publishAssets();
    }

    public function boot()
    {
        $this->bootBladeDirective();
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
        ], 'config');

        $this->mergeConfigFrom($sourceConfigFile, 'laraveladmin');
    }

    protected function publishViews()
    {
        $this->loadViewsFrom($this->path('resources' . DIRECTORY_SEPARATOR . 'views'), 'laraveladmin');
    }

    protected function publishAssets()
    {
        $this->publishes([
            $this->path('public' . DIRECTORY_SEPARATOR . 'laraveladmin') => $this->app['config']->get('laraveladmin.publish.path.assets')
        ], 'public');
    }

    protected function bootBladeDirective()
    {
        Blade::directive('css', function ($src) {
            $attrs = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet', 'href' => asset(trim($src, '\'"'))];
            return new HtmlString('<link' . \Html::attributes($attrs) . '>');
        });

        Blade::directive('js', function ($src) {
            $attrs = ['src' => asset(trim($src, '\'"'))];
            return new HtmlString('<script' . \Html::attributes($attrs) . '></script>');
        });
    }
}
