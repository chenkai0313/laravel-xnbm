<?php
/**
 * 导航栏
 * Author: CK
 * Date: 2018/1/3
 */

namespace Modules\Backend\Services;


use Modules\Backend\Models\NavBar;

class NavBarService
{
    /**
     * 导航栏的添加
     * @return array
     */
    public function navBarAdd($params)
    {
        $validator = \Validator::make($params, [
            'navi_name' => 'required',
            'navi_front_route' => 'required',
            'is_super' => 'required',
            'time_stage' => 'required',
            'navi_display' => 'required',
//            'pid' => 'required',
        ], [
            'required' => ':attribute必填',
        ], [
            'navi_name' => '导航栏名称',
            'navi_front_route' => '前端路由',
            'is_super' => '角色',
            'time_stage' => '时间段分配',
            'navi_display' => '是否展示',
//            'pid' => '父级ID'
        ]);
        if (!$validator->passes()) {
            return ['code' => 90002, 'msg' => $validator->messages()->first()];
        }
        $res = NavBar::navbarAdd($params);
        if ($res) {
            return ['code' => 1, 'msg' => '添加成功'];
        }
        return ['code' => 90002, 'msg' => '添加失败'];
    }

    /**
     * 导航栏的修改
     * @return array
     */
    public function navBarEdit($params)
    {
        if (!isset($params['navi_id'])) {
            return ['code' => 90002, 'msg' => 'id必填'];
        }
        $res = NavBar::navbarEdit($params);
        if ($res) {
            return ['code' => 1, 'msg' => '修改成功'];
        }
        return ['code' => 90002, 'msg' => '修改失败'];
    }

    /**
     * 导航栏的删除
     * @return array
     */
    public function navBarDelete($params)
    {
        if (!isset($params['navi_id'])) {
            return ['code' => 90002, 'msg' => 'id必填'];
        }
        $res = NavBar::navbarDelete($params);
        if ($res) {
            return ['code' => 1, 'msg' => '删除成功'];
        }
        return ['code' => 90002, 'msg' => '删除失败'];
    }

    /**
     * 导航栏的详情
     * @return array
     */
    public function navBarDetail($params)
    {
        if (!isset($params['navi_id'])) {
            return ['code' => 90002, 'msg' => 'id必填'];
        }
        $res = NavBar::navbarDetail($params);
        if ($res) {
            return ['code' => 1, 'data' => $res];
        }
        return ['code' => 90002, 'msg' => '查询失败'];
    }

    /**
     * 导航栏的列表
     * @return array
     */
    public function navBarList($params)
    {
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 20;
        $params['page'] = isset($params['page']) ? $params['page'] : 1;
        $params['keyword'] = isset($params['keyword']) ? $params['keyword'] : null;
        $data = NavBar::navbarList($params);
        return ['code' => 1, 'data' => $data];
    }


//
//    #转换为树形结构
//    protected function getTree($data, $pid)
//    {
//        $res = [];
//        foreach ($data as $v) {
//            if ($v['pid'] == $pid) {
//                $v['children'] = $this->getTree($data, $v['navi_id']);
//                if ($v['children'] == null) {
//                    unset($v['children']);
//                }
//                $res[] = $v;
//            }
//        }
//        return $res;
//    }
}
