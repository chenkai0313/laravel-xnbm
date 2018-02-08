<?php

/**
 * 报名信息
 * Author: CK
 * Date: 2018/1/4
 */

namespace Modules\Backend\Models;


use Illuminate\Database\Eloquent\Model;

class Apply extends Model
{


    protected $table = 'apply';


    protected $primaryKey = 'apply_id';

    protected $fillable = array('admin_id', 'family_info', 'grade_info', 'apply_condition', 'honor', 'point',
        'apply_res', 'face_time', 'print_res', 'admission_res', 'stu_sn', 'area', 'sex', 'class', 'register', 'graduated_school', 'stu_name');


    /**
     * 报名的添加
     * @return array
     */
    public static function applyAdd($params)
    {
        $arr = ['admin_id', 'family_info', 'grade_info', 'apply_condition', 'honor', 'point', 'apply_res', 'face_time',
            'print_res', 'admission_res', 'stu_sn', 'area', 'sex', 'class', 'register', 'graduated_school', 'stu_name'];
        $data = array();
        $params['stu_sn'] = static::randSn(0);
        foreach ($arr as $v)
            if (array_key_exists($v, $params))
                $data[$v] = $params[$v];
        return Apply::create($data);
    }


    #生成唯一学生编号
    public static function randSn($k)
    {
        try {
            $data = static::countSn();
            $res = $data['str'][$k] . sprintf("%03d", rand(1, 999));
            if (isset($data['key'][$k])) {
                if ($data['count'][$data['key'][$k]] < 300) {
                    if (!in_array($res, $data['data'][$data['key'][$k]])) {
                        return $res;
                    } else {
                        return static::randSn($k);
                    }
                    return static::randSn($k + 1);
                } else {
                    return static::randSn($k + 1);
                }
            } else {
                return $res;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    #统计当前编号
    public static function countSn()
    {
        $first = ['A', 'B', 'C', 'D', 'E', 'F'];
        $data = Apply::select('stu_sn')->get()->toArray();
        $now_data = [];
        $all = [];
        foreach ($first as $k) {
            foreach ($data as $v) {
                if (!preg_match("/^((?!" . $k . ").)*$/is", $v['stu_sn'])) {
                    $now_data[$k][] = $v['stu_sn'];
                    $all[] = $v['stu_sn'];
                }
            }
        }
        $count = [];
        $key = [];
        foreach ($now_data as $k => $v) {
            $count[$k] = count($v);
            $key[] = $k;
        }
        $res['data'] = $now_data;
        $res['count'] = $count;
        $res['key'] = $key;
        $res['str'] = $first;
        return $res;
    }

    /**
     * 报名的修改
     * @return array
     */
    public static function applyEdit($params)
    {
        $arr = ['admin_id', 'family_info', 'grade_info', 'apply_condition', 'honor', 'point', 'apply_res',
            'face_time', 'print_res', 'admission_res', 'stu_sn', 'area', 'sex', 'class', 'register', 'graduated_school', 'stu_name'];
        $data = array();
        foreach ($arr as $v)
            if (array_key_exists($v, $params))
                $data[$v] = $params[$v];
        return Apply::where('apply_id', $params['apply_id'])->update($data);
    }

    /**
     * 报名的删除
     * @return array
     */
    public static function applyDelete($apply_id)
    {
        return Apply::destroy($apply_id);
    }

    /**
     * 报名的详情
     * @return array
     */
    public static function applyDetail($params)
    {
        return Apply::where('apply_id', $params['apply_id'])->first();
    }

    /**
     * 学生登陆获取到的详情详情
     * @return array
     */
    public static function applyStuDetail($params)
    {
        return Apply::where('admin_id', $params['admin_id'])->first();
    }

    /**
     * 报名的列表
     * @return array
     */
    public static function applyList($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $data = Apply::leftJoin('admins', 'admins.admin_id', '=', 'apply.admin_id')
            ->where('apply.stu_sn', 'like', '%' . $params['stu_sn'] . '%')
            ->where('apply.stu_name', 'like', '%' . $params['stu_name'] . '%')
            ->where('apply.area', 'like', '%' . $params['area'] . '%')
            ->where('apply.graduated_school', 'like', '%' . $params['graduated_school'] . '%')
            ->where('admins.admin_name', 'like', '%' . $params['id_card'] . '%')
            ->skip($offset)
            ->take($params['limit'])
            ->get();
        foreach ($data as $v) {
            if (trim($v['admission_res']) == 'A+') {
                $v['admission_res'] = 1;
            } else {
                $v['admission_res'] = 0;
            }
        }
        return $data;
    }

    public static function applyListCount($params)
    {
        $data = Apply::leftJoin('admins', 'admins.admin_id', '=', 'apply.admin_id')
            ->where('apply.stu_sn', 'like', '%' . $params['stu_sn'] . '%')
            ->where('apply.stu_name', 'like', '%' . $params['stu_name'] . '%')
            ->where('apply.area', 'like', '%' . $params['area'] . '%')
            ->where('apply.graduated_school', 'like', '%' . $params['graduated_school'] . '%')
            ->where('admins.admin_name', 'like', '%' . $params['id_card'] . '%')
            ->take($params['limit'])
            ->get();
        return count($data);
    }

    /**
     * 报名结果路由
     * @return array
     */
    public static function applyStuRes($params)
    {
        return Apply::select('stu_name','stu_sn','apply_res', 'face_time')->where('admin_id', $params['admin_id'])->get();
    }

    /**
     * 面试结果路由
     * @return array
     */
    public static function applyStuFaceRes($params)
    {
        return Apply::select('admission_res','stu_name','stu_sn')->where('admin_id', $params['admin_id'])->get();
    }

    /**
     * 是否打印过
     * @return array
     */
    public static function applyPrint($parmas)
    {
        return Apply::where('apply_id', $parmas['apply_id'])->update(array('print_res' => 1));
    }


}