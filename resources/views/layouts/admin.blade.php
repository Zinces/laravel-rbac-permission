<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{ env('APP_NAME','Laravel') }}-管理后台</title>
    <link rel="stylesheet" href="/js/layui/css/layui.css">
    @yield('style')
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">layui 后台布局</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="">控制台</a></li>
            <li class="layui-nav-item"><a href="">商品管理</a></li>
            <li class="layui-nav-item"><a href="">用户</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">其它系统</a>
                <dl class="layui-nav-child">
                    <dd><a href="">邮件管理</a></dd>
                    <dd><a href="">消息管理</a></dd>
                    <dd><a href="">授权管理</a></dd>
                </dl>
            </li>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    {{ session('user')['name'] }}
                </a>
                {{--<dl class="layui-nav-child">--}}
                    {{--<dd><a href="">修改密码</a></dd>--}}
                {{--</dl>--}}
            </li>
            <li class="layui-nav-item">
                <a href="{{ route('admin.logout.white') }}"
                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                    退出
                </a>

                <form id="logout-form" action="{{ route('admin.logout.white') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree" lay-filter="test">
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;">权限管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="{{ route('admin.user.index') }}">用户管理</a></dd>
                        <dd><a href="{{ route('admin.roles.index') }}">角色管理</a></dd>
                        <dd><a href="{{ route('admin.permission.index') }}">权限组管理</a></dd>
                        <dd><a href="{{ route('admin.menu.index') }}">菜单管理</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;">解决方案</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;">列表一</a></dd>
                        <dd><a href="javascript:;">列表二</a></dd>
                        <dd><a href="">超链接</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item"><a href="">云市场</a></li>
                <li class="layui-nav-item"><a href="">发布商品</a></li>
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            @yield('content')
        </div>
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © layui.com - 底部固定区域
    </div>
</div>
<script src="/js/layui/layui.js"></script>
<script src="/js/jquery1.12.1.js"></script>
<script>
    //JavaScript代码区域
    layui.use('element', function () {
        var element = layui.element;

    });
</script>
@yield('script')
</body>
</html>