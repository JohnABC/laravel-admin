<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title', env('APP_NAME' . '-后台管理系统'))</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">

    @section('css')
        @css('vendor/laraveladmin/layui/css/layui.css')
        @css('vendor/laraveladmin/style/admin.css')
    @show
    @section('js-title')
    @show
</head>
<body class="@yield('body-class', 'layui-layout-body')">
    @yield('body-content')
    @section('js-foot')
        @js('vendor/laraveladmin/layui/layui.js')
    @show
    <script type="text/javascript">
        layui.config({
            base: '{{ asset(config('laraveladmin.publish.path.assets')) }}/'
        }).extend({
            index: 'lib/index'
        }).use('index');
    </script>
</body>
</html>