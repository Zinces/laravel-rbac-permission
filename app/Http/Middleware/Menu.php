<?php

namespace App\Http\Middleware;

use App\Http\Models\MenuRoles;
use App\Http\Models\Users;
use App\Http\Models\UsersRoles;
use Closure;
use \App\Http\Models\Menu as MenuModel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class Menu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = $request->session()->get('user');

        $currRouteName = Route::currentRouteName();

        $menu_tree = [];
        $menu_arr  = [];
        $menus     = MenuModel::all()->toArray();
        foreach ($menus as $m) {
            $menu_arr[$m['id']] = $m;
        }

        if ($user['administrator'] == Users::ADMIN_YES) {
            //超管获取所有菜单
            MenuModel::menuTree($menu_arr, $menu_tree);
        } else {
            $role_ids = UsersRoles::where('user_id', '=', $user['id'])->pluck('roles_id')->toArray();
            $menu_ids = MenuRoles::whereIn('roles_id', $role_ids)->pluck('menu_id')->toArray();
            $menus    = MenuModel::whereIn('id', $menu_ids)->get()->toArray();

            $menu_tmp = [];
            foreach ($menus as $m) {
                $menu_tmp[$m['id']] = $m;
                //同时获取父级菜单
                if ($m['pid'] != 0 && !key_exists($m['pid'], $menu_tmp)) {
                    $menu_tmp[$m['pid']] = $menu_arr[$m['pid']];
                }
            }
            MenuModel::menuTree($menu_tmp, $menu_tree);
        }

        View::share('menu_tree', $menu_tree);

        return $next($request);
    }
}
