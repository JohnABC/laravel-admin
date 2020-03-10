<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <link media="all" type="text/css" rel="stylesheet" href="{{ \LaravelAdmin::assetsUrl('layui/css/layui.css') }}" />
    <link media="all" type="text/css" rel="stylesheet" href="{{ \LaravelAdmin::assetsUrl('style/admin.css') }}" />

    @section('css')
    @show
    @section('js-title')
    @show

    <title>@yield('title', env('APP_NAME' . '-后台管理系统'))</title>
</head>
<body class="@yield('body-class', 'layui-layout-body')">
    @yield('body-content')
    @section('js-foot')
        <script type="text/javascript" src="{{ \LaravelAdmin::assetsUrl('layui/layui.js') }}"></script>
    @show
    <script type="text/javascript">
        layui.config({
            base: '{{ \LaravelAdmin::assetsUrl() }}/'
        }).extend({
            index: 'lib/index'
        }).use('index');
    </script>
</body>
</html>