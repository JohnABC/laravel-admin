<?php

namespace LaravelAdmin;

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
        //
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
            $this->path('public') => $this->app['config']->get('laraveladmin.publishe.path.assets')
        ]);
    }
}
