<?php
/**
 * User: gedongdong@100tal.com
 * Date: 2019/1/28 下午9:20
 */

namespace App\Validate;


use App\Http\Models\Menu;
use App\Http\Models\MenuRoles;
use App\Http\Models\Roles;
use App\Service\RouteService;

class MenuUpdateValidate extends BaseValidate
{
    protected $rules = [];

    protected $message = [
        'id.required'    => 'ID参数不存在',
        'id.numeric'     => 'ID参数不正确',
        'name.required'  => '请输入名称',
        'name.max'       => '名称最长20个字符',
        'route.required' => '请输入路由',
        'pid.required'   => '请选择父级菜单',
        'role.required'  => '请选择可见角色',
    ];

    public function __construct($request)
    {
        parent::__construct($request);
        $this->rules = [
            'id'    => 'required|numeric',
            'name'  => 'required|max:20',
            'route' => 'nullable',
            'pid'   => 'required',
            'role'  => 'required',
        ];
    }

    protected function customValidate()
    {
        $id    = $this->requestData['id'];
        $name  = $this->requestData['name'];
        $pid   = $this->requestData['pid'];
        $route = $this->requestData['route'];
        $role  = $this->requestData['role'] ?? '';

        if ($pid < 0) {
            $this->validator->errors()->add('pid', '父级菜单参数不正确');
            return false;
        } elseif ($pid > 0) {
            if (!Menu::find($pid)) {
                $this->validator->errors()->add('pid', '父级菜单不存在');
                return false;
            }
        }

        if (!Menu::find($id)) {
            $this->validator->errors()->add('id', '菜单信息不正确');
            return false;
        }

        if (Menu::where('id', '!=', $id)->where('name', '=', $name)->count() > 0) {
            $this->validator->errors()->add('name', '该名称已存在');
            return false;
        }

        if ($pid != 0) {
            $routes = RouteService::getRoutes();
            if (!in_array($route, $routes)) {
                $this->validator->errors()->add('route', '路由标识不存在');
                return false;
            }
        }

        if (!$role) {
            $this->validator->errors()->add('role', '请选择可见角色');
            return false;
        } else {
            if ($pid == 0) {
                if (count($role) != Roles::whereIn('id', $role)->count()) {
                    $this->validator->errors()->add('route', '可见角色参数不正确');
                    return false;
                }
            } else {
                if (count($role) != MenuRoles::where('menu_id', $pid)->whereIn('roles_id', $role)->count()) {
                    $this->validator->errors()->add('route', '可见角色参数不正确');
                    return false;
                }
            }
        }

    }
}