<?php

namespace LaravelAdmin;

class LaravelAdmin
{
    public const TARGET_FLAG_TAG = 'tag';
    public const TARGET_FLAG_SELF = 'self';
    public const TARGET_FLAG_BLANK = 'blank';

    protected $menu = [];
    protected $logo = '';
    protected $logoLink = '';
    protected $homeLink = '';

    protected $headerWeb = [];
    protected $headerSearch = [];
    protected $headerMessage = [];
    protected $headerUser = [];

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
        return $this->logo ?: view()->shared('laraveladmin-logo', env('LARAVELADMIN_LOGO', env('APP_NAME')));
    }

    public function bindLogoLink($logoLink)
    {
        $this->logoLink = $logoLink;

        return $this;
    }

    public function getLogoLink()
    {
        return $this->logoLink ?: view()->shared('laraveladmin-logo-link', env('LARAVELADMIN_LOGO_LINK', 'https://www.google.com?logo'));
    }

    public function bindHomeLink($homeLink)
    {
        $this->homeLink = $homeLink;

        return $this;
    }

    public function getHomeLink()
    {
        return $this->homeLink ?: view()->shared('laraveladmin-home-link', env('LARAVELADMIN_HOME_LINK', 'https://www.google.com?home-link'));
    }

    public function bindHeaderWeb($link, $title = '网站', $icon = 'layui-icon-website')
    {
        if (is_array($link)) {
            $this->headerWeb = array_merge($this->headerWeb, $link);
        } else {
            $this->headerWeb = ['link' => $link, 'title' => $title, 'icon' => $icon];
        }

        return $this;
    }

    public function getHeaderWeb($key = null)
    {
        $default = [
            'link' => view()->shared('laraveladmin-header-web-link', env('LARAVELADMIN_HEADER_WEB_LINK', 'https://www.google.com?header-web-link')),
            'title' => '网站',
            'icon' => 'layui-icon-website'
        ];

        $rtn = array_merge($default, $this->headerWeb);

        return $key ? $rtn[$key] : $rtn;
    }

    public function bindHeaderSearch($link, $title = '搜索...')
    {
        if (is_array($link)) {
            $this->headerSearch = array_merge($this->headerSearch, $link);
        } else {
            $this->headerSearch = ['link' => $link, 'title' => $title];
        }

        return $this;
    }

    public function getHeaderSearch($key = null)
    {
        $default = [
            'link' => view()->shared('laraveladmin-header-search-link', env('LARAVELADMIN_HEADER_SEARCH_LINK', 'https://www.google.com/search?q=')),
            'title' => '搜索...',
        ];

        $rtn = array_merge($default, $this->headerSearch);

        return $key ? $rtn[$key] : $rtn;
    }

    public function bindHeaderMessage($link, $title = '消息中心', $icon = 'layui-icon-notice')
    {
        if (is_array($link)) {
            $this->headerMessage = array_merge($this->headerMessage, $link);
        } else {
            $this->headerMessage = ['link' => $link, 'title' => $title, 'icon' => $icon];
        }

        return $this;
    }

    public function bindHeaderMessageDot($dot = true)
    {
        $this->headerMessage['dot'] = $dot;

        return $this;
    }

    public function getHeaderMessage($key = null)
    {
        $default = [
            'link' => view()->shared('laraveladmin-header-message-link', env('LARAVELADMIN_HEADER_MESSAGE_LINK', 'https://www.google.com/?header-message-link')),
            'title' => '消息中心',
            'icon' => 'layui-icon-notice',
            'dot' => false
        ];

        $rtn = array_merge($default, $this->headerMessage);

        return $key ? $rtn[$key] : $rtn;
    }

    public function buildHeaderUserLine($title = '', $link = null, $target = self::TARGET_FLAG_TAG)
    {
        if (!$title) {
            return ['hr' => true];
        }

        return ['title' => $title, 'link' => $link, 'target' => $target];
    }

    public function bindHeaderUser($user, ...$args)
    {
        if (is_array($user)) {
            $this->headerUser = array_merge($this->headerUser, $user);
        } else {
            $this->headerUser = ['user' => $user, 'list' => $args];
        }

        return $this;
    }

    public function getHeaderUser($key = null)
    {
        $default = [
            'user' => '随永杰',
            'list' => [
                ['title' => '基本资料'],
                ['hr' => true],
                ['title' => '退出', 'target' => static::TARGET_FLAG_SELF]
            ]
        ];

        $rtn = array_merge($default, $this->headerUser);

        return $key ? $rtn[$key] : $rtn;
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
                        'link' => 'https://github.com/JohnABC/laravel-admin'
                    ],
                    [
                        'name' => 'Packagist',
                        'subMenus' => [
                            [
                                'name' => 'LaravelAdmin',
                                'link' => 'https://packagist.org/packages/johnabc/laravel-admin'
                            ],
                            [
                                'name' => 'JohnABC',
                                'link' => 'https://packagist.org/users/John_ABC/',
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

            $link = $this->convertLink($menu);

            $html .= "<{$innerTag} class='{$innerTagClass}'>";
            $html .= "<a {$link}>";
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

    public function convertLink($config, $linkField = 'link', $targetField = 'target')
    {
        $href = "href='javascript:;'";
        $layHref = $blank = '';

        $targetFlag = $config[$targetField] ?? static::TARGET_FLAG_TAG;
        $hasLink = !empty($config[$linkField]);
        if ($targetFlag == static::TARGET_FLAG_TAG) {
            $layHref = $hasLink ? "lay-href='{$config[$linkField]}'" : '';
        } elseif (in_array($targetFlag, [static::TARGET_FLAG_SELF, static::TARGET_FLAG_BLANK])) {
            if ($hasLink) {
                $href = "href='{$config[$linkField]}'";
                if ($targetFlag == static::TARGET_FLAG_BLANK) {
                    $blank = "target='_blank'";
                }
            }
        }

        return " {$href} {$layHref} {$blank}";
    }
}