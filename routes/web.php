<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//以.white结尾的别名为不需要授权的路由

Route::namespace('Admin')->prefix('admin')->group(function () {
    Route::get('login', 'LoginController@index')->name('admin.login.white');
    Route::post('login', 'LoginController@login')->name('admin.login.post.white');

    Route::middleware(['login', 'menu'])->group(function () {
        Route::get('/', 'AdminController@index')->name('admin.index.white');
        Route::post('logout', 'LoginController@logout')->name('admin.logout.white');
        Route::get('forbidden', function () {
            return view('admin.403');
        })->name('admin.forbidden.white');

        Route::middleware('auth.can')->group(function () {
            Route::get('/user', 'UserController@index')->name('admin.user.index');
            Route::get('/user/create', 'UserController@create')->name('admin.user.create');
            Route::post('/user/store', 'UserController@store')->name('admin.user.store');
            Route::post('/user/status', 'UserController@status')->name('admin.user.status');
            Route::get('/user/edit', 'UserController@edit')->name('admin.user.edit');
            Route::post('/user/update', 'UserController@update')->name('admin.user.update');

            Route::get('/permission', 'PermissionController@index')->name('admin.permission.index');
            Route::get('/permission/create', 'PermissionController@create')->name('admin.permission.create');
            Route::post('/permission/store', 'PermissionController@store')->name('admin.permission.store');
            Route::get('/permission/edit', 'PermissionController@edit')->name('admin.permission.edit');
            Route::post('/permission/update', 'PermissionController@update')->name('admin.permission.update');
            Route::post('/permission/delete', 'PermissionController@delete')->name('admin.permission.delete');

            Route::get('/roles', 'RolesController@index')->name('admin.roles.index');
            Route::get('/roles/create', 'RolesController@create')->name('admin.roles.create');
            Route::post('/roles/store', 'RolesController@store')->name('admin.roles.store');
            Route::get('/roles/edit', 'RolesController@edit')->name('admin.roles.edit');
            Route::post('/roles/update', 'RolesController@update')->name('admin.roles.update');
            Route::post('/roles/delete', 'RolesController@delete')->name('admin.roles.delete');

            Route::get('/menu', 'MenuController@index')->name('admin.menu.index');
            Route::get('/menu/create', 'MenuController@create')->name('admin.menu.create');
            Route::post('/menu/store', 'MenuController@store')->name('admin.menu.store');
            Route::get('/menu/edit', 'MenuController@edit')->name('admin.menu.edit');
            Route::post('/menu/update', 'MenuController@update')->name('admin.menu.update');
            Route::post('/menu/delete', 'MenuController@delete')->name('admin.menu.delete');
        });
    });
});


