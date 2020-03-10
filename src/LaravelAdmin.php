<?php

namespace LaravelAdmin;

class LaravelAdmin
{
    public function isUrl($path)
    {
        if (!preg_match('~^(#|//|https?://|(mailto|tel|sms):)~', $path)) {
            return filter_var($path, FILTER_VALIDATE_URL) !== false;
        }

        return true;
    }

    public function assetsUrl($path = '', $padConfigPath = true)
    {
        if ($this->isUrl($path)) {
            return $path;
        }

        $path = trim($path, '/');
        if ($padConfigPath) {
            $configPath = trim(strtr(config('laraveladmin.publish.assets.path'), '\//', '//'), '/');
            if (strpos($path, $configPath) !== 0) {
                $path = $configPath . '/' . $path;
            }
        }

        return asset(rtrim(config('laraveladmin.publish.assets.url'), '/') . '/' . $path);
    }
}