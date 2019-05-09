<?php
/**
 * User: gedongdong@100tal.com
 * Date: 2019/5/6 上午10:11
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Models\Permission;
use App\Http\Models\RolePermission;
use App\Http\Models\Roles;
use App\Library\ErrorCode;
use App\Validate\RolesStoreValidate;
use App\Validate\RolesUpdateValidate;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Roles::paginate(config('page_size'));
        return view('admin.roles.index', ['roles' => $roles]);
    }

    public function create()
    {
        $permissions = Permission::select('id', 'name')->get();
        return view('admin.roles.create', ['permissions' => $permissions]);
    }

    public function store(Request $request)
    {
        $validate = new RolesStoreValidate($request);

        if (!$validate->goCheck()) {
            return response(['code' => ErrorCode::BAD_REQUEST, 'msg' => $validate->errors->first(), 'data' => []]);
        }

        $params = $validate->requestData;

        DB::beginTransaction();
        try {
            $roles = new Roles();

            $roles->name = $params['name'];
            $roles->save();

            $pivot = [];
            foreach ($params['permission'] as $permission) {
                $pivot[] = [
                    'roles_id'      => $roles->id,
                    'permission_id' => $permission,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s')
                ];
            }
            RolePermission::insert($pivot);

            DB::commit();
            return response(['code' => ErrorCode::OK, 'msg' => 'success', 'data' => []]);
        } catch (QueryException $e) {
            DB::rollBack();
            return response(['code' => ErrorCode::SQL_ERROR, 'msg' => '保存失败', 'data' => []]);
        }
    }

    public function edit(Request $request)
    {
        $role_id = $request->get('role_id');

        $error = '';
        $role  = null;

        $permission_ids = [];
        if (!$role_id) {
            $error = '参数有误';
        } else {
            $role = Roles::find($role_id);
            if (!$role) {
                $error = '获取权限信息错误';
            } else {
                //该角色具有的权限组id
                $permission_ids = RolePermission::where('roles_id', '=', $role_id)->pluck('permission_id')->toArray();
            }
        }

        //所有权限组
        $permissions = Permission::select('id', 'name')->get();

        return view('admin.roles.edit', ['permissions' => $permissions, 'error' => $error, 'permission_ids' => $permission_ids, 'role' => $role]);
    }

    public function update(Request $request)
    {
        $validate = new RolesUpdateValidate($request);

        if (!$validate->goCheck()) {
            return response(['code' => ErrorCode::BAD_REQUEST, 'msg' => $validate->errors->first(), 'data' => []]);
        }

        $params = $validate->requestData;

        DB::beginTransaction();
        try {
            $roles = Roles::find($params['id']);

            $roles->name = $params['name'];
            $roles->save();

            //删除旧的关联关系
            RolePermission::where('roles_id','=',$params['id'])->delete();

            $pivot = [];
            foreach ($params['permission'] as $permission) {
                $pivot[] = [
                    'roles_id'      => $roles->id,
                    'permission_id' => $permission,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s')
                ];
            }
            RolePermission::insert($pivot);

            DB::commit();
            return response(['code' => ErrorCode::OK, 'msg' => 'success', 'data' => []]);
        } catch (QueryException $e) {
            DB::rollBack();
            return response(['code' => ErrorCode::SQL_ERROR, 'msg' => '保存失败', 'data' => []]);
        }
    }
}