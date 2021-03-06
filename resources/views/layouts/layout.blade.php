<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <link media="all" type="text/css" rel="stylesheet" href="{{ \LaravelAdmin::assetsUrl('layui/css/layui.css') }}" />
    <link media="all" type="text/css" rel="stylesheet" href="{{ \LaravelAdmin::assetsUrl('style/admin.css') }}" />

    @stack('laraveladmin-css')

    <script type="text/javascript" src="{{ \LaravelAdmin::assetsUrl('layui/layui.js') }}"></script>

    @stack('laraveladmin-js-title')
    <title>{{ $title ?? env('APP_NAME') }}</title>
</head>
<body class="@yield('laraveladmin-body-class', 'layui-layout-body')">
    @yield('laraveladmin-body-content')

    @stack('laraveladmin-js-foot-src')

    <script type="text/javascript">
        layui.config({
            base: '{{ \LaravelAdmin::assetsUrl() }}/'
        })
    </script>

    @stack('laraveladmin-js-foot-text')
</body>
</html>
