<?php

/**
 * 管理员模块
 * Author: CK
 * Date: 2017/7/25
 */

namespace Modules\Backend\Services;


use Modules\Backend\Models\Admin;
use Modules\Backend\Models\NavBar;
use Modules\Backend\Models\SysTime;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Session;

class AdminService
{


    /**
     * 当前时间处于的时间段
     */
    public function timeStageNow($params)
    {
        $stage['stage'] = $this->timeStage($params);
        return ['code' => 1, 'data' => $stage];
    }

    /**
     * 清除所有注册学生信息
     */
    public function adminDelAll($params)
    {
        if ($params['is_super'] !== 1) {
            return ['code' => 90002, 'msg' => '无权操作'];
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $res = Admin::where('is_super', '=', 2)->delete();
        if ($res) {
            return ['code' => 1, 'msg' => '删除成功'];
        }
        return ['code' => 90002, 'msg' => '删除失败'];
    }

    /**
     * 管理员 列表
     * @params int $limit 每页显示数量
     * @params int $page 当前页数
     * @return array
     */
    public function adminList($params)
    {
        $res = Admin::adminList($params);
        $list = $res['list'];
        $admin_id_array = [];
        foreach ($list as $key => $value) {
            $admin_id_array[] = $list[$key]['admin_id'];
        }
        $info = AdminInfo::adminInfoList($admin_id_array);
        foreach ($list as $key => $value) {
            foreach ($info as $k => $v) {
                if ($list[$key]['admin_id'] == $info[$k]['admin_id']) {
                    $temp = [
                        'company_name' => $info[$k]['company_name'],
                    ];
                    $list[$key] = array_merge($list[$key], $temp);
                }
            }
        }

        $result['data']['admin_list'] = $list;
        $result['data']['total'] = $res['total'];
        $result['data']['pages'] = $res['pages'];
        $result['code'] = 1;
        return $result;
    }

    /**
     * 取回密码
     */
    public function adminUpdatedPwd($params)
    {
        $validator = \Validator::make($params, [
            'admin_name' => array('regex:/^(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)|(^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[Xx])$)$/',
                'required', 'min:18', 'max:18'),
            'admin_password' => array('regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,16}$/', 'required', 'same:confirm_password'),
            'confirm_password' => array('regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,16}$/', 'required', 'same:admin_password'),
            'question' => 'required',
            'answer' => 'required',
        ], [
            'integer' => ':attribute必须为整数',
            'required' => ':attribute必填',
            'regex' => ':attribute为8到16位英文和数字',
            'same' => '密码和确认密码不一致',
            'unique' => ':attribute已被注册',
            'min' => ':attribute最少为18位',
            'max' => ':attribute最多为18位'
        ], [
            'admin_name' => '身份证',
            'admin_password' => '密码',
            'confirm_password' => '确认密码',
            'question' => '密保问题',
            'answer' => '密码答案'
        ]);
        if (!$validator->passes()) {
            $result['code'] = 90002;
            $result['msg'] = $validator->messages()->first();
            return $result;
        }
        $data = Admin::where('admin_name', $params['admin_name'])->first();
        if ($data) {
            if ($data['question'] == $params['question'] && $data['answer'] == $params['answer']) {
                $user['admin_id'] = $data['admin_id'];
                $user['admin_password'] = bcrypt($params['admin_password']);
                $res = Admin::adminUpdatedPwd($user);
                if ($res) {
                    return ['code' => 1, 'msg' => '修改成功'];
                }
                return ['code' => 90002, 'msg' => '修改失败，请重试'];
            }
            return ['caode' => 9002, 'msg' => '密码问题或者密码答案不正确'];
        }
        return ['code' => 90002, 'msg' => '账号不存在'];


    }


    /**
     * 管理员  添加
     * @params string $admin_name 账号
     * @params string $admin_password 密码
     * @return array
     */
    public function adminAdd($params)
    {
        $validator = \Validator::make($params, [
            'admin_name' => array('regex:/^(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)|(^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[Xx])$)$/',
                'required', 'unique:admins', 'min:18', 'max:18'),
            'admin_password' => array('regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,16}$/', 'required', 'same:confirm_password'),
            'confirm_password' => array('regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,16}$/', 'required', 'same:admin_password'),
            'question' => 'required',
            'answer' => 'required',
            'code' => 'required',
        ], [
            'integer' => ':attribute必须为整数',
            'required' => ':attribute必填',
            'regex' => ':attribute不符合规定',
            'same' => '密码和确认密码不一致',
            'unique' => ':attribute已被注册',
            'min' => ':attribute最少为18位',
            'max' => ':attribute最多为18位'
        ], [
            'admin_name' => '身份证',
            'admin_password' => '密码',
            'confirm_password' => '确认密码',
            'question' => '密保问题',
            'code' => '验证码',
            'answer' => '密码答案'
        ]);
        $age = date('Y', time()) - substr($params['admin_name'], 6, 4);
        if ($age > 13 || $age < 11) {
            return ['code' => 90002, 'msg' => '您的年龄不在报名年龄范围内！'];
        }
        if (!$validator->passes()) {
            $result['code'] = 90002;
            $result['msg'] = $validator->messages()->first();
            return $result;
        }
        if (is_null($params['captcha'])) {
            return ["code" => 10000, "msg" => "验证码已过期,请重新获取"];
        } elseif (!is_null($params['captcha'])) {
            if ($params['captcha'] !== $params['code']) {
                return ["code" => 10000, "msg" => "验证码填写错误"];
            }
        }
        if (!Admin::adminExist($params['admin_name'])) {
            DB::beginTransaction();
            $res1 = Admin::adminAdd($params);
            if ($res1) {
                DB::commit();
                $result['code'] = 1;
                $result['msg'] = '注册成功';
            } else {
                DB::rollback();
                $result['code'] = 10001;
                $result['msg'] = '注册用户失败';
            }
        } else {
            $result['code'] = 10004;
            $result['msg'] = '该注册账号已存在';
        }
        return $result;
    }

    /**
     * 管理员  编辑
     * @params int $admin_id 管理员ID
     * @params string $admin_password 密码
     * @return array
     */
    public function adminEdit($params)
    {
        $validator = \Validator::make($params, [
            'admin_id' => 'required',
            'admin_name' => 'required',
//            'admin_nick' => 'required',
            'question' => 'required',
            'answer' => 'required',
        ], [
            'required' => ':attribute为必填项',
            'max' => ':attribute长度不符合要求',
            'unique' => ':attribute必须唯一'
        ], [
            'admin_id' => 'id',
            'admin_name' => '帐号',
//            'admin_nick' => '昵称',
            'question' => '问题',
            'answer' => '答案',
        ]);
        if (!$validator->passes()) {
            $result['code'] = 90002;
            $result['msg'] = $validator->messages()->first();
            return $result;
        }
        DB::beginTransaction();

        $res1 = Admin::adminEdit($params);
        if ($res1 != false) {
            DB::commit();
            $result['code'] = 1;
            $result['msg'] = '编辑成功';
        } else {
            DB::rollback();
            $result['code'] = 10002;
            $result['msg'] = '编辑失败';
        }

        return $result;
    }

    /**
     * 管理员  详情
     * @params int $admin_id 管理员ID
     * @return array
     */
    public function adminDetail($params)
    {
        if (!isset($params['admin_id'])) {
            return ['code' => 90002, 'msg' => 'admin_id'];
        }
        $res = Admin::where('admin_id', $params['admin_id'])->select('admin_id', 'admin_name', 'admin_nick', 'question', 'answer')->first();
        $result['data']['admin_id'] = $res['admin_id'];
        $result['data']['admin_name'] = $res['admin_name'];
        $result['data']['question'] = $res['question'];
        $result['data']['answer'] = $res['answer'];
        $result['code'] = 1;
        return $result;
    }

    /**
     * 管理员  删除
     * @params int $admin_id 管理员ID
     * @return array
     */
    public function adminDelete($params)
    {
        DB::beginTransaction();
        $res = Admin::adminDelete($params['admin_id']);
        if ($res) {
            DB::commit();
            $result['code'] = 1;
            $result['msg'] = '删除成功';
        } else {
            DB::rollback();
            $result['code'] = 10003;
            $result['msg'] = '删除失败';
        }
        return $result;
    }

    /**
     * 管理员  登录
     * @params string $admin_name 管理员账号
     * @params string $admin_password 管理员密码
     * @return array
     */
    public function adminLogin($params)
    {
        $validator = \Validator::make($params, [
            'admin_name' => 'required',
            'admin_password' => 'required',
            'code' => 'required',
        ], [
            'required' => ':attribute为必填项',
        ], [
            'admin_name' => '账号',
            'admin_password' => '密码',
            'code' => '验证码',
        ]);
        if (!$validator->passes()) {
            return ['code' => 90002, 'msg' => $validator->messages()->first()];
        }
        if (is_null($params['captcha'])) {
            return ["code" => 10000, "msg" => "验证码已过期,请重新获取"];
        } elseif (!is_null($params['captcha'])) {
            if ($params['captcha'] !== $params['code']) {
                return ["code" => 10000, "msg" => "验证码填写错误"];
            }
        }
        $admin_info = Admin::adminInfo($params['admin_name']);
        if ($admin_info) {
            if (password_verify($params['admin_password'], $admin_info['admin_password'])) {
                $result['code'] = 1;
                $result['msg'] = '登录成功';
                $customClaim = [
                    'from' => 'admin',
                    'admin_id' => $admin_info['admin_id'],
                    'admin_name' => $admin_info['admin_name'],
                    'is_super' => $admin_info['is_super'],
                ];
                $token = JWTAuth::fromUser($admin_info, $customClaim);
                $result['data']['token'] = $token;
                $result['data']['admin_name'] = $admin_info['admin_name'];
                $result['data']['admin_id'] = $admin_info['admin_id'];
                $result['data']['is_super'] = $admin_info['is_super'];
                #判断当前时间处于第几阶段
                $stage = $this->timeStage($params);
                if ($result['data']['is_super'] == 2) {
                    $catagory = NavBar::where('time_stage', 'like', '%' . $stage . '%')
                        ->where('is_super', 2)
                        ->where('navi_display', 1)
                        ->orWhere('time_stage', 'like', '%' . 4 . '%')
                        ->orderBy('sort', 'desc')
                        ->get();
                } else {
                    $catagory = NavBar::orderBy('sort', 'desc')
                        ->where('navi_display', 1)
                        ->where('is_super', 1)
                        ->get();
                }
                $result['data']['nav_bar'] = $catagory;
                $result['data']['stage'] = $stage;
                Admin::where('admin_id', $admin_info['admin_id'])->update(array('remember_token' => $result['data']['token']));

            } else {
                $result['code'] = 10005;
                $result['msg'] = '账号密码不正确';
            }

        } else {
            $result['code'] = 10006;
            $result['msg'] = '该账号不存在或已删除';
        }
        return $result;
    }

    #判断当前时间处于第几阶段
    public function timeStage($params)
    {
        $now = time();
        $time = SysTime::sysTimeNewOne($params);
        if ($now > $time['enroll_start'] && $now < $time['face_start']) {
            return 1;
        }
        #面试时间路由
        if ($now > $time['face_start'] && $now < $time['end_start']) {
            return 2;
        }
        #结束面试时间路由
        if ($now > $time['end_start']) {
            return 3;
        }
        return 4;
    }


    /**
     * 用户密码修改
     * @params int $admin_id 用户id
     * @params string $admin_password 用户密码
     * @params string $admin_password_change 用户修改后的密码
     * @return array
     */
    public function adminChangePassword($params)
    {
        if (!isset($params['admin_password_change'])) {
            return ['code' => 90002, 'msg' => '新密码不能为空'];
        }
        if (!isset($params['admin_password'])) {
            return ['code' => 90002, 'msg' => '旧密码不能为空'];
        }
        if (!isset($params['admin_id'])) {
            return ['code' => 90002, 'msg' => 'id必填'];
        }
        $admin = Admin::find($params['admin_id']);
        if (password_verify($params['admin_password'], $admin['admin_password'])) {
            $data = [
                'admin_id' => $params['admin_id'],
                'admin_password' => bcrypt($params['admin_password_change']),
            ];
            $res = Admin::adminPasswordEdit($data);
            if ($res) {
                return ['code' => 1, 'msg' => '修改成功'];
            } else {
                return ['code' => 10008, 'msg' => '修改密码失败'];
            }
        } else {
            return ['code' => 10005, 'msg' => '原密码输入错误'];
        }
    }

    /**
     * 所有用户-学生
     */
    public function adminListStu($params)
    {
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 20;
        $params['page'] = isset($params['page']) ? $params['page'] : 1;
        $params['id_card'] = isset($params['id_card']) ? $params['id_card'] : null;
        $params['answer'] = isset($params['answer']) ? $params['answer'] : null;
        $params['admin_nick'] = isset($params['admin_nick']) ? $params['admin_nick'] : null;
        $data = Admin::select('*')
            ->where('is_super', 2)
            ->where('admin_name', 'like', '%' . $params['id_card'] . '%')
            ->where('answer', 'like', '%' . $params['answer'] . '%')
            ->where('admin_nick', 'like', '%' . $params['admin_nick'] . '%')
            ->orderBy('admin_id', 'desc')
            ->get()->toArray();
        #数组分页
        $start = ($params['page'] - 1) * $params['limit'];
        $totals = count($data);
        $pagedata = array();
        $pagedata = array_slice($data, $start, $params['limit']);
        $list['list'] = $pagedata;
        $list['page'] = $params['page'];
        $list['limit'] = $params['limit'];
        $list['count'] = $totals;
        return ['code' => 1, 'data' => $list];
    }

    /**
     * 所有用户-老师
     */
    public function adminListTch($params)
    {
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 20;
        $params['page'] = isset($params['page']) ? $params['page'] : 1;
        $params['keyword'] = isset($params['keyword']) ? $params['keyword'] : null;
        $data = Admin::select('*')
            ->where('is_super', 1)
            ->where('admin_name', 'like', '%' . $params['id_card'] . '%')
            ->where('answer', 'like', '%' . $params['answer'] . '%')
            ->orderBy('admin_id', 'desc')
            ->get()->toArray();
        #数组分页
        $start = ($params['page'] - 1) * $params['limit'];
        $totals = count($data);
        $pagedata = array();
        $pagedata = array_slice($data, $start, $params['limit']);
        $list['list'] = $pagedata;
        $list['page'] = $params['page'];
        $list['limit'] = $params['limit'];
        $list['count'] = $totals;
        return ['code' => 1, 'data' => $list];
    }


    /**
     * 老师修改学生的密码
     */
    public function tchEditPwd($params)
    {
        if ($params['is_super'] == 1) {
            $validator = \Validator::make($params, [
                'admin_id' => 'required',
                'admin_password' => array('regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,16}$/', 'required'),
                'question' => 'required',
                'answer' => 'required',
            ], [
                'required' => ':attribute为必填项',
                'regex' => ':attribute不符合规定',
            ], [
                'admin_id' => 'admin_id必填',
                'admin_password' => '密码',
                'question' => '密保问题',
                'answer' => '密码答案'
            ]);
            if (!$validator->passes()) {
                return ['code' => 90002, 'msg' => $validator->messages()->first()];
            }
            $res = Admin::tchEditPwd($params);
            if ($res) {
                return ['code' => 1, 'msg' => '修改成功'];
            }
            return ['code' => 90002, 'msg' => '修改失败'];
        }
        return ['code' => 90002, 'msg' => '无权操作'];

    }
}
