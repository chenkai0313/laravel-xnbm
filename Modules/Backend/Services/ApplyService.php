<?php
/**
 * 导航栏
 * Author: CK
 * Date: 2018/1/4
 */

namespace Modules\Backend\Services;


use Modules\Backend\Models\Admin;
use Modules\Backend\Models\Apply;

class ApplyService
{
    /**
     * 学生登陆获取到的详情详情
     * @return array
     */
    public function applyStuDetail($params)
    {
        if (!isset($params['admin_id'])) {
            return ['code' => 90002, 'msg' => '登陆id不能为空'];
        }
        $data = Apply::applyStuDetail($params);
        if(!$data){
            return ['code'=>1,'data'=>''];
        }
        $data['family_info'] = unserialize($data['family_info']);
        $data['grade_info'] = unserialize($data['grade_info']);
        $data['id_card'] = Admin::where('admin_id', $data['admin_id'])->first();
        $data['id_card'] = $data['id_card']['admin_name'];
        $apply_condition = explode(',', $data['apply_condition']);
        $data['apply_condition1'] = $apply_condition[0];
        $data['apply_condition2'] = $apply_condition[1];
        $data['apply_condition3'] = $apply_condition[2];
        switch ($data['area']) {
            case 1:
                $data['area_name'] = '海曙区';
                break;
            case
            $data['area_name'] = '江北区';
                break;
            case 3:
                $data['area_name'] = '高新区';
                break;
            case 4:
                $data['area_name'] = '原江东区';
                break;
            case 5:
                $data['area_name'] = '原鄞州区';
                break;
            case 6:
                $data['area_name'] = '北仑区';
                break;
            case 7:
                $data['area_name'] = '慈溪';
                break;
            case 8:
                $data['area_name'] = '余姚';
                break;
            case 9:
                $data['area_name'] = '宁海';
                break;
            case 10:
                $data['area_name'] = '象山';
                break;
            case 11:
                $data['area_name'] = '镇海';
                break;
            case 12:
                $data['area_name'] = '奉化';
                break;
            case 13:
                $data['area_name'] = '东钱湖';
                break;
            case 14:
                $data['area_name'] = '其它';
                break;
            default:
                break;
        }
        if ($data) {
            return ['code' => 1, 'data' => $data];
        }
        return ['code' => 1, 'data' => ''];
    }


    /**
     * 报名信息的添加
     * @return array
     */
    public function applyAdd($params)
    {

        if (!isset($params['id_card'])) {
            return ['code' => 90002, 'msg' => '身份证号不能为空'];
        }
        $admin_id = Admin::select('admin_id', 'admin_name')->where('admin_name', $params['id_card'])->first();
        if (empty($admin_id)) {
            return ['code' => 90002, 'msg' => '您所输入的身份证号码不存在，请先注册'];
        }
        $params['admin_id'] = $admin_id['admin_id'];
        $validator = \Validator::make($params, [
            'admin_id' => 'required|unique:apply',
            'stu_name' => 'required',
            'area' => 'required',
            'class' => 'required',
            'register' => 'required',
            'sex' => 'required',
            'graduated_school' => 'required',
            'family_info' => 'required',
            'grade_info' => 'required',
            'apply_condition' => 'required',
            'honor' => 'required',
            'point' => 'required',
        ], [
            'required' => ':attribute必填',
            'unique' => ':attribute重复'
        ], [
            'admin_id' => '学生id',
            'family_info' => '家庭信息',
            'grade_info' => '文化素质信息',
            'apply_condition' => '申请条件',
            'honor' => '荣誉',
            'point' => '特长',
            'area' => '区域',
            'class' => '班级',
            'register' => '户籍',
            'sex' => '性别',
            'graduated_school' => '毕业学校',
            'stu_name' => '姓名',
        ]);
        if (!$validator->passes()) {
            return ['code' => 90002, 'msg' => $validator->messages()->first()];
        }
        $params['family_info'] = serialize($params['family_info']);
        $params['grade_info'] = serialize($params['grade_info']);
        return $params;
    }


    /**
     * 报名信息的详情
     * @return array
     */
    public function applyDetail($params)
    {
        if (!isset($params['apply_id'])) {
            return ['code' => 90002, 'msg' => '报名信息ID必填'];
        }
        $data = Apply::applyDetail($params);
        $data['family_info'] = unserialize($data['family_info']);
        $data['grade_info'] = unserialize($data['grade_info']);
        $data['id_card'] = Admin::where('admin_id', $data['admin_id'])->first();
        $data['id_card'] = $data['id_card']['admin_name'];
        $apply_condition = explode(',', $data['apply_condition']);
        $data['apply_condition1'] = $apply_condition[0];
        $data['apply_condition2'] = $apply_condition[1];
        $data['apply_condition3'] = $apply_condition[2];
        switch ($data['area']) {
            case 1:
                $data['area_name'] = '海曙区';
                break;
            case
            $data['area_name'] = '江北区';
                break;
            case 3:
                $data['area_name'] = '高新区';
                break;
            case 4:
                $data['area_name'] = '原江东区';
                break;
            case 5:
                $data['area_name'] = '原鄞州区';
                break;
            case 6:
                $data['area_name'] = '北仑区';
                break;
            case 7:
                $data['area_name'] = '慈溪';
                break;
            case 8:
                $data['area_name'] = '余姚';
                break;
            case 9:
                $data['area_name'] = '宁海';
                break;
            case 10:
                $data['area_name'] = '象山';
                break;
            case 11:
                $data['area_name'] = '镇海';
                break;
            case 12:
                $data['area_name'] = '奉化';
                break;
            case 13:
                $data['area_name'] = '东钱湖';
                break;
            case 14:
                $data['area_name'] = '其它';
                break;
            default:
                break;
        }
        if ($data) {
            return ['code' => 1, 'data' => $data];
        }
        return ['code' => 90002, 'msg' => '查询失败'];
    }

    /**
     * 报名信息的修改
     * @return array
     */
    public function applyEdit($params)
    {
        if (!isset($params['apply_id'])) {
            return ['code' => 90002, 'msg' => '报名信息ID必填'];
        }
//        if (isset($params['id_card'])) {
//            return ['code' => 90002, 'msg' => '身份证号不能修改'];
//        }
        $validator = \Validator::make($params, [
            'admin_id' => 'required',
            'stu_name' => 'required',
            'area' => 'required',
            'class' => 'required',
            'register' => 'required',
            'sex' => 'required',
            'graduated_school' => 'required',
            'family_info' => 'required',
            'grade_info' => 'required',
            'apply_condition' => 'required',
            'honor' => 'required',
            'point' => 'required',
        ], [
            'required' => ':attribute必填',
            'unique' => ':attribute重复'
        ], [
            'admin_id' => '学生id',
            'family_info' => '家庭信息',
            'grade_info' => '文化素质信息',
            'apply_condition' => '申请条件',
            'honor' => '荣誉',
            'point' => '特长',
            'area' => '区域',
            'class' => '班级',
            'register' => '户籍',
            'sex' => '性别',
            'graduated_school' => '毕业学校',
            'stu_name' => '姓名',
        ]);
        if (!$validator->passes()) {
            return ['code' => 90002, 'msg' => $validator->messages()->first()];
        }
        $params['family_info'] = serialize($params['family_info']);
        $params['grade_info'] = serialize($params['grade_info']);
        $res = Apply::applyEdit($params);
        if ($res) {
            return ['code' => 1, 'msg' => '修改成功'];
        }
        return ['code' => 90002, 'msg' => '修改失败'];
    }

    /**
     * 报名信息的删除
     * @return array
     */
    public function applyDelete($params)
    {
        if (!isset($params['apply_id'])) {
            return ['code' => 90002, 'msg' => '报名信息ID必填'];
        }
        $res = Apply::applyDelete($params['apply_id']);
        if ($res) {
            return ['code' => 1, 'msg' => '删除成功'];
        }
        return ['code' => 90002, 'msg' => '删除失败'];
    }

    /**
     * 报名信息的列表
     * @return array
     */
    public function applyList($params)
    {
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 10;
        $params['page'] = isset($params['page']) ? $params['page'] : 1;
        $params['stu_sn'] = isset($params['stu_sn']) ? $params['stu_sn'] : null;
        $params['id_card'] = isset($params['id_card']) ? $params['id_card'] : null;
        $params['stu_name'] = isset($params['stu_name']) ? $params['stu_name'] : null;
        $params['area'] = isset($params['area']) ? $params['area'] : null;
        $params['graduated_school'] = isset($params['graduated_school']) ? $params['graduated_school'] : null;
        $data['list'] = Apply::applyList($params);
        $data['count'] = Apply::applyListCount($params);
        $data['limit'] = $params['limit'];
        $data['page'] = $params['page'];
        return ['code' => 1, 'data' => $data];
    }

    /**
     * 报名结果路由
     * @return array
     */
    public function applyStuRes($params)
    {
        $data = Apply::applyStuRes($params);
        return ['code' => 1, 'data' => $data];
    }

    /**
     * 面试结果路由
     * @return array
     */
    public function applyStuFaceRes($params)
    {
        $data = Apply::applyStuFaceRes($params);
        return ['code' => 1, 'data' => $data];
    }

    /**
     * 清除所有报名信息
     * @return array
     */
    public function applyDelAll($params)
    {
        if ($params['is_super'] !== 1) {
            return ['code' => 90002, 'msg' => '无权操作'];
        }
        $res = Apply::truncate();
        if ($res) {
            return ['code' => 1, 'msg' => '删除成功'];
        }
        return ['code' => 90002, 'msg' => '删除失败'];
    }

    /**
     * 是否打印过
     * @return array
     */
    public function applyPrint($params)
    {
        if (!isset($params['apply_id'])) {
            return ['code' => 90002, 'msg' => '报名信息ID必填'];
        }
        $res = Apply::applyPrint($params);
        if ($res) {
            return ['code' => 1, 'msg' => ''];
        }
        return ['code' => 1, 'msg' => '打印失败'];
    }
}
