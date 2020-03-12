<?php

namespace LaravelAdmin;

class LaravelAdmin
{
    protected $menu = [];
    protected $logo = '';
    protected $logoLink = '';
    protected $homeLink = '';
    protected $pageLayoutParts = [
        'header' => 'laraveladmin::layouts.layout-page-header',
        'menu' => 'laraveladmin::layouts.layout-page-menu',
        'tags' => 'laraveladmin::layouts.layout-page-tags',
        'content' => 'laraveladmin::layouts.layout-page-content',
        'assist' => 'laraveladmin::layouts.layout-page-assist',
    ];



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
                $path = trim($configPath . '/' . $path, '/');
            }
        }

        return asset(rtrim(config('laraveladmin.publish.assets.url'), '/') . '/' . $path);
    }

    public function bindLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    public function getLogo()
    {
        return $this->headerTitle ?: view()->shared('laraveladmin-logo', env('APP_NAME'));
    }

    public function bindLogoLink($logoLink)
    {
        $this->logoLink = $logoLink;

        return $this;
    }

    public function getLogoLink()
    {
        return $this->logoLink ?: view()->shared('laraveladmin-logo-link', '');
    }

    public function bindHomeLink($homeLink)
    {
        $this->homeLink = $homeLink;

        return $this;
    }

    public function getHomeLink()
    {
        return $this->homeLink ?: view()->shared('laraveladmin-home-link', '');
    }

    public function bindPageLayoutPart($part, $layout)
    {
        $this->pageLayoutParts[$part] = $layout;

        return $this;
    }

    public function getPageLayoutPart($part)
    {
        return $this->pageLayoutParts[$part];
    }

    public function bindMenu($menu)
    {
        $this->menu = $menu;

        return $this;
    }

    public function getMenu()
    {
        return $this->menu;
    }

    public function getMenuHtml()
    {
        return $this->convertMenu($this->menu ?: view()->shared('laraveladmin-menu', [
            [
                'name' => 'Home',
                'icon' => 'home',
                'subMenus' => [
                    [
                        'name' => 'GitHub',
                        'route' => 'https://github.com/JohnABC/laravel-admin'
                    ],
                    [
                        'name' => 'Packagist',
                        'subMenus' => [
                            [
                                'name' => 'LaravelAdmin',
                                'route' => 'https://packagist.org/packages/johnabc/laravel-admin'
                            ],
                            [
                                'name' => 'JohnABC',
                                'route' => 'https://packagist.org/users/John_ABC/',
                            ]
                        ],
                    ]
                ]
            ]
        ]));
    }

    public function convertMenu($menus, $top = true)
    {
        $outerTag = $top ? 'ul' : 'dl';
        $outerTagId = $top ? 'LAY-system-side-menu' : '';
        $outerTagClass = $top ? 'layui-nav layui-nav-tree' : 'layui-nav-child';
        $innerTag = $top ? 'li' : 'dd';
        $innerTagClass = $top ? 'layui-nav-item' : '';

        $html = "<{$outerTag} id='{$outerTagId}' class='{$outerTagClass}'>";
        foreach ($menus as $menu) {
            if (!empty($menu['hide'])) {
                continue;
            }

            [$linkHref, $linkLayHref] = $this->convertLink($menu);

            $html .= "<{$innerTag} class='{$innerTagClass}'>";
            $html .= "<a {$linkHref} {$linkLayHref}>";
            if (!empty($menu['icon'])) {
                $html .= "<i class='layui-icon layui-icon-{$menu['icon']}'></i>";
            }
            $html .= "<cite>{$menu['name']}</cite>";
            $html .= '</a>';

            if (!empty($menu['subMenus'])) {
                $html .= $this->convertMenu($menu['subMenus'], false);
            }

            $html .= "</{$innerTag}>";
        }

        $html .= "</{$outerTag}>";

        return $html;
    }

    public function convertLink($config, $blankField = 'blank', $linkField = 'route')
    {
        $href = empty($config[$blankField]) || empty($config[$linkField]) ? "href='javascript:;'" : "href='{$config[$linkField]}'";
        $layHref = empty($config[$blankField]) && !empty($config[$linkField]) ? "lay-href='{$config[$linkField]}'" : '';

        return [$href, $layHref];
    }
}