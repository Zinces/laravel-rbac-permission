<?php
/**
 * User: gedongdong@100tal.com
 * Date: 2019/5/6 上午10:11
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Models\Permission;
use App\Http\Models\User;
use App\Library\ErrorCode;
use App\Validate\UserStoreValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(config('page_size'));
        return view('admin.permission.index', ['permissions' => $permissions]);
    }

    public function create()
    {
        $routes = $this->getRoutes();
        return view('admin.permission.create', ['routes' => $routes]);
    }

    protected function getRoutes()
    {
        $routes = [];

        $all_routes = app()->routes->getRoutes();
        foreach ($all_routes as $k => $value) {
            if (key_exists('as', $value->action) && !ends_with($value->action['as'], '.white')) {
                $routes[] = $value->action['as'];
            }
        }
        return $routes;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|unique:permission,name|max:20',
            'route' => 'required',
        ], [
            'name.unique'    => '名称已存在',
            'name.required'  => '请输入名称',
            'name.max'       => '名称最长20个字符',
            'route.required' => '请选择路由',
        ]);

        if ($validator->fails()) {
            return response(['code' => ErrorCode::BAD_REQUEST, 'msg' => $validator->errors()->first(), 'data' => []]);
        }

        $params = $validator->getData();

        $all_routes = $this->getRoutes();
        if (count($params['route']) != count(array_intersect($params['route'], $all_routes))) {
            return response(['code' => ErrorCode::BAD_REQUEST, 'msg' => '路由参数不正确', 'data' => []]);
        }

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
        $user_id = $request->get('user_id');

        $error = '';
        if (!$user_id) {
            $error = '参数有误';
        } else {
            $user = User::find($user_id);
        }


        return view('admin.user.edit');
    }

    /**
     * 修改用户状态
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function status(Request $request)
    {
        $user_id = $request->get('user_id');
        if (!$user_id) {
            return response(['code' => ErrorCode::BAD_REQUEST, 'msg' => '参数错误', 'data' => []]);
        }

        if ($user_id == session('user')['id']) {
            return response(['code' => ErrorCode::BAD_REQUEST, 'msg' => '你不能修改自己的状态', 'data' => []]);
        }

        $user = User::find($user_id);
        if (!$user) {
            return response(['code' => ErrorCode::BAD_REQUEST, 'msg' => '用户信息错误', 'data' => []]);
        }

        if ($user->administrator == User::ADMIN_YES && $user->status == User::STATUS_ENABLE) {
            //除了当前管理员，至少有一个启用状态的管理员
            if (User::where('id', '!=', $user_id)->where('administrator', '=', User::ADMIN_YES)->where('status', '=', User::STATUS_ENABLE)->count() <= 0) {
                return response(['code' => ErrorCode::BAD_REQUEST, 'msg' => '至少有一个管理员', 'data' => []]);
            }
        }

        $user->status = $user->status == User::STATUS_ENABLE ? User::STATUS_DISABLE : User::STATUS_ENABLE;

        if (!$user->save()) {
            return response(['code' => ErrorCode::SQL_ERROR, 'msg' => '操作失败', 'data' => []]);
        }
        return response(['code' => ErrorCode::OK, 'msg' => 'success', 'data' => []]);
    }
}