<?php
/**
 * User: gedongdong@100tal.com
 * Date: 2019/5/5 下午9:20
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
}