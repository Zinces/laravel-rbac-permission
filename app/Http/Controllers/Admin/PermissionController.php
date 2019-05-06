<?php
/**
 * User: gedongdong@100tal.com
 * Date: 2019/5/6 上午10:11
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Models\Permission;
use App\Library\ErrorCode;
use App\Service\RouteService;
use App\Validate\PermissionStoreValidate;
use App\Validate\PermissionUpdateValidate;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(config('page_size'));
        return view('admin.permission.index', ['permissions' => $permissions]);
    }

    public function create()
    {
        $routes = RouteService::getRoutes();
        return view('admin.permission.create', ['routes' => $routes]);
    }

    public function store(Request $request)
    {
        $validate = new PermissionStoreValidate($request);

        if (!$validate->goCheck()) {
            return response(['code' => ErrorCode::BAD_REQUEST, 'msg' => $validate->errors->first(), 'data' => []]);
        }

        $params = $validate->requestData;

        $permission = new Permission();

        $permission->name   = $params['name'];
        $permission->routes = implode(',', $params['route']);

        if (!$permission->save()) {
            return response(['code' => ErrorCode::SQL_ERROR, 'msg' => '保存失败', 'data' => []]);
        }
        return response(['code' => ErrorCode::OK, 'msg' => 'success', 'data' => []]);
    }

    public function edit(Request $request)
    {
        $permission_id = $request->get('permission_id');

        $error      = '';
        $permission = null;

        if (!$permission_id) {
            $error = '参数有误';
        } else {
            $permission = Permission::find($permission_id);
            if (!$permission) {
                $error = '获取权限信息错误';
            } else {
                $permission->routes = explode(',', $permission->routes);
            }
        }

        $routes = RouteService::getRoutes();

        return view('admin.permission.edit', ['permission' => $permission, 'error' => $error, 'routes' => $routes]);
    }

    public function update(Request $request)
    {
        $validate = new PermissionUpdateValidate($request);

        if (!$validate->goCheck()) {
            return response(['code' => ErrorCode::BAD_REQUEST, 'msg' => $validate->errors->first(), 'data' => []]);
        }

        $params = $validate->requestData;

        $permission = Permission::find($params['id']);

        $permission->name   = $params['name'];
        $permission->routes = implode(',', $params['route']);

        if (!$permission->save()) {
            return response(['code' => ErrorCode::SQL_ERROR, 'msg' => '保存失败', 'data' => []]);
        }
        return response(['code' => ErrorCode::OK, 'msg' => 'success', 'data' => []]);
    }
}