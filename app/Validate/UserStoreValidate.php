<?php
/**
 * User: gedongdong@100tal.com
 * Date: 2019/1/28 下午9:20
 */

namespace App\Validate;


use Illuminate\Validation\Rule;

class UserStoreValidate extends BaseValidate
{
    protected $rules = [];

    protected $message = [
        'name.required'            => '请输入姓名',
        'name.max'                 => '姓名最多20个字符',
        'email.required'           => '请输入邮箱',
        'email.email'              => '邮箱格式不正确',
        'email.unique'             => '邮箱已经存在',
        'password.required'        => '请输入密码',
        'password.digits_between'  => '密码长度为6-12个字符',
        'password_repeat.required' => '请输入确认密码',
        'password_repeat.same'     => '两次填写的密码不一致',
        'status.required'          => '请选择状态',
        'status.in'                => '状态值不正确',
        'administrator.required'   => '请选择是否管理员',
        'administrator.in'         => '管理员参数不正确',
    ];

    public function __construct($request)
    {
        parent::__construct($request);
        $this->rules = [
            'name'            => 'required|max:20',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|digits_between:6,12',
            'password_repeat' => 'required|same:password',
            'status'          => ['required', Rule::in([1, 2])],
            'administrator'   => ['required', Rule::in([1, 2])],
        ];
    }

    protected function customValidate()
    {
        //$unit         = $this->requestData['unit'];
        //$price_old    = $this->requestData['price_old'];
        //$price        = $this->requestData['price'];
        //$price_reason = $this->requestData['price_reason'];
        //$weight       = $this->requestData['weight'];
        //$volume       = $this->requestData['volume'];
        //
        //if ((count($unit) != count($price_old)) || (count($unit) != count($price)) || (count($unit) != count($price_reason)) || (count($unit) != count($weight)) || (count($unit) != count($volume))) {
        //    $this->validator->errors()->add('unit', '规格信息有误');
        //    return false;
        //}

    }
}