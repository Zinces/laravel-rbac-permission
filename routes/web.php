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

    Route::middleware('login')->group(function () {
        Route::get('/', 'AdminController@index')->name('admin.index.white');

        Route::post('logout', 'LoginController@logout')->name('admin.logout.white');

        Route::get('/user', 'UserController@index')->name('admin.user.index');
        Route::get('/user/create', 'UserController@create')->name('admin.user.create');
        Route::post('/user/store', 'UserController@store')->name('admin.user.store');
        Route::post('/user/status', 'UserController@status')->name('admin.user.status');
        Route::get('/user/edit', 'UserController@edit')->name('admin.user.edit');

        Route::get('/permission', 'PermissionController@index')->name('admin.permission.index');
        Route::get('/permission/create', 'PermissionController@create')->name('admin.permission.create');
        Route::post('/permission/store', 'PermissionController@store')->name('admin.permission.store');
    });
});


