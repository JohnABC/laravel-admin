@extends('laraveladmin::layouts.layout')
@section('body-content')
    <div id="@yield('body-content-class', 'LAY_app')">
        <div class="layui-layout layui-layout-admin">
            @foreach (['header', 'menu', 'tags', 'content', 'assist'] as $laraveladminPageLayoutPart)
                @php
                    $laraveladminPageLayout = \LaravelAdmin::getPageLayoutPart($laraveladminPageLayoutPart);
                @endphp
                @include($laraveladminPageLayout)
            @endforeach
            {{--
            <!-- 头部区域 -->
            @include('laraveladmin::layouts.layout-page-header')
            <!-- 侧边菜单 -->
            @include('laraveladmin::layouts.layout-page-menu')
            <!-- 页面标签 -->
            @include('laraveladmin::layouts.layout-page-tags')
            <!-- 主体内容 -->
            @include('laraveladmin::layouts.layout-page-content')
            <!-- 辅助元素，一般用于移动设备下遮罩 -->
            @include('laraveladmin::layouts.layout-page-assist')
            --}}
        </div>
    </div>
@endsection
@section('js-foot-text')
    <script type="text/javascript">
        layui.extend({
            index: 'lib/index'
        }).use('index');
    </script>
@endsection
