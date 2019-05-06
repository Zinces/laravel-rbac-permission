@extends('layouts.admin')

@section('style')
    <style>
        #page li {
            display: inline-block;
        }

        #page .active span {
            background-color: #009688;
            color: #fff;
            border: 0px;
            height: 30px;
            border-radius: 2px;
        }

        #page .disabled span {
            color: #ccc;
        }
    </style>
@endsection

@section('content')
    <a href="{{ route('admin.permission.create') }}" class="layui-btn">添加权限</a>
    <table class="layui-table">
        <colgroup>
            <col width="50">
        </colgroup>
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>路由</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($permissions as $permission)
            <tr>
                <td>{{ $permission->id }}</td>
                <td>{{ $permission->name }}</td>
                <td>{{ $permission->routes }}</td>
                <td>{{ $permission->created_at }}</td>
                <td>
                    {{--<a href="{{ route('admin.permission.edit') }}?user_id={{ $permission->id }}" class="layui-btn layui-btn-sm">编辑</a>--}}
                    {{--@if($user->status==\App\Http\Models\User::STATUS_ENABLE)--}}
                        {{--<button class="layui-btn layui-btn-warm layui-btn-sm" type="button"--}}
                                {{--onclick="changeStatus({{ $user->id }})">禁用--}}
                        {{--</button>--}}
                    {{--@else--}}
                        {{--<button class="layui-btn layui-btn-normal layui-btn-sm" type="button"--}}
                                {{--onclick="changeStatus({{ $user->id }})">启用--}}
                        {{--</button>--}}
                    {{--@endif--}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div id="page" class="layui-box layui-laypage layui-laypage-default">{{ $permissions->links() }}</div>
@endsection

@section('script')
    <script>
        layui.use(['layer'], function () {
            var layer = layui.layer;
        });
    </script>
@endsection