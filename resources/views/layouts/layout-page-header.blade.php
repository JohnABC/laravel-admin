<!-- 头部区域 -->
<div class="layui-header">
    <ul class="layui-nav layui-layout-left">
        @section('laraveladmin-header-flexible-before')
        @show
        @section('laraveladmin-header-flexible')
        <li class="layui-nav-item layadmin-flexible" lay-unselect>
            <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
            </a>
        </li>
        @show
        @section('laraveladmin-header-web-before')
        @show
        @section('laraveladmin-header-web')
        <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="{{ \LaravelAdmin::getHeaderWeb('link') }}" target="_blank" title="前台">
                <i class="layui-icon {{ \LaravelAdmin::getHeaderWeb('icon') }}"></i>
            </a>
        </li>
        @show
        @section('laraveladmin-header-refresh-before')
        @show
        @section('laraveladmin-header-refresh')
        <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;" layadmin-event="refresh" title="刷新">
                <i class="layui-icon layui-icon-refresh-3"></i>
            </a>
        </li>
        @show
        @section('laraveladmin-header-search-before')
        @show
        @section('laraveladmin-header-search')
        <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <input type="text" placeholder="{{ \LaravelAdmin::getHeaderSearch('title') }}" autocomplete="off" class="layui-input layui-input-search" layadmin-event="serach" lay-action="{{ \LaravelAdmin::getHeaderSearch('link') }}">
        </li>
        @show
    </ul>
    <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
        @section('laraveladmin-header-message-before')
        @show
        @section('laraveladmin-header-message')
        <li class="layui-nav-item" lay-unselect>
            <a lay-href="{{ \LaravelAdmin::getHeaderMessage('link') }}" layadmin-event="message" lay-text="{{ \LaravelAdmin::getHeaderMessage('title') }}">
                <i class="layui-icon {{ \LaravelAdmin::getHeaderMessage('icon') }}"></i>

                @if(\LaravelAdmin::getHeaderMessage('dot'))
                <span class="layui-badge-dot"></span>
                @endif
            </a>
        </li>
        @show
        @section('laraveladmin-header-theme-before')
        @show
        @section('laraveladmin-header-theme')
        <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="theme">
                <i class="layui-icon layui-icon-theme"></i>
            </a>
        </li>
        @show
        @section('laraveladmin-header-note-before')
        @show
        @section('laraveladmin-header-note')
        <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="note">
                <i class="layui-icon layui-icon-note"></i>
            </a>
        </li>
        @show
        @section('laraveladmin-header-screen-before')
        @show
        @section('laraveladmin-header-screen')
        <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="fullscreen">
                <i class="layui-icon layui-icon-screen-full"></i>
            </a>
        </li>
        @show
        @section('laraveladmin-header-user-before')
        @show
        @section('laraveladmin-header-user')
        <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;">
                <cite>{{ \LaravelAdmin::getHeaderUser('user') }}</cite>
            </a>
            <dl class="layui-nav-child">
                @foreach (\LaravelAdmin::getHeaderUser('list') as $laraveladminHeaderUserLine)
                    @if (!empty($laraveladminHeaderUserLine['hr']))
                        <hr />
                    @else
                        <dd><a {!! \LaravelAdmin::convertLink($laraveladminHeaderUserLine) !!}>{{ $laraveladminHeaderUserLine['title'] }}</a></dd>
                    @endif
                @endforeach
            </dl>
        </li>
        @show
        {{--
        <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="about"><i class="layui-icon layui-icon-more-vertical"></i></a>
        </li>
        <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
            <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
        </li>
        --}}
    </ul>
</div>