<?php
/**
 * 设置系统时间
 * Author: CK
 * Date: 2017/7/27
 */

namespace Modules\Backend\Services;


use Modules\Backend\Models\SysTime;

class SysTimeService
{
    /**
     * 设置系统时间的添加
     * @return array
     */

    public function sysTimeAdd($params)
    {
        $validator = \Validator::make($params, [
            'enroll_start' => 'required',
            'face_start' => 'required',
            'end_start' => 'required',
        ], [
            'required' => ':attribute必填',
        ], [
            'enroll_start' => '报名开始时间',
            'face_start' => '面试开始时间',
            'end_start' => '结束时间',
        ]);
        if (!$validator->passes()) {
            return ['code' => 90002, 'msg' => $validator->messages()->first()];
        }
        if ($params['enroll_start'] < $params['face_start'] && $params['face_start'] < $params['end_start']) {
//            $params['enroll_start'] = date('Y-m-d H:i:s', $params['enroll_start']);
//            $params['face_start'] = date('Y-m-d H:i:s', $params['face_start']);
//            $params['end_start'] = date('Y-m-d H:i:s', $params['end_start']);
            $data = SysTime::sysTimeAdd($params);
            if ($data) {
                $result['code'] = 1;
                $result['msg'] = "设置成功";
            } else {
                $result['code'] = 90002;
                $result['msg'] = "设置失败";
            }
        } else {
            $result['code'] = 90002;
            $result['msg'] = "时间参数设置不正确";
        }
        return $result;
    }

    /**
     * 显示最新设置的时间（一条）
     * @return array
     */
    public function sysTimeNewOne()
    {
        $data['list'] = SysTime::sysTimeNewOne();
        return ['code' => 1, 'data' => $data];
    }

}
