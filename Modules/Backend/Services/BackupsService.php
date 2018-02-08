<?php

/**
 * 学生注册信息 报名信息的备份
 * Author: CK
 * Date: 2018/1/11
 */

namespace Modules\Backend\Services;

use Modules\Backend\Models\Apply;
use Modules\Backend\Models\Backups;

class BackupsService
{

    /**
     * 备份数据的添加
     * @return array
     */
    public function backupsAdd($params)
    {
        $data = Apply::leftJoin('admins', 'admins.admin_id', '=', 'apply.admin_id')
            ->select('apply.*', 'admins.admin_name')->get();
        try {
            $time = time();
            foreach ($data as $k => $v) {
                $v['family_info'] = unserialize($v['family_info']);
                $v['grade_info'] = unserialize($v['grade_info']);
                $apply_condition = explode(',', $v['apply_condition']);
                $v['apply_condition1'] = $apply_condition[0];
                $v['apply_condition2'] = $apply_condition[1];
                $v['apply_condition3'] = $apply_condition[2];
                switch ($v['area']) {
                    case 1:
                        $v['area_name'] = '海曙区';
                        break;
                    case
                    $v['area_name'] = '江北区';
                        break;
                    case 3:
                        $v['area_name'] = '高新区';
                        break;
                    case 4:
                        $v['area_name'] = '原江东区';
                        break;
                    case 5:
                        $v['area_name'] = '原鄞州区';
                        break;
                    case 6:
                        $v['area_name'] = '北仑区';
                        break;
                    case 7:
                        $v['area_name'] = '慈溪';
                        break;
                    case 8:
                        $v['area_name'] = '余姚';
                        break;
                    case 9:
                        $v['area_name'] = '宁海';
                        break;
                    case 10:
                        $v['area_name'] = '象山';
                        break;
                    case 11:
                        $v['area_name'] = '镇海';
                        break;
                    case 12:
                        $v['area_name'] = '奉化';
                        break;
                    case 13:
                        $v['area_name'] = '东钱湖';
                        break;
                    case 14:
                        $v['area_name'] = '其它';
                        break;
                    default:
                        break;
                }
                $params['content'] = serialize($v);
                $params['backup_time'] = $time;
                Backups::backupsAdd($params);
            }
            return ['code' => 1, 'msg' => '备份成功'];
        } catch (\Exception $e) {
            return ['code' => 90002, 'msg' => '备份成功失败'];
        }
    }

    /**
     * 备份数据的详情
     * @return array
     */
    public function backupsDetail($params)
    {
        if (!isset($params['id'])) {
            return ['code' => 90002, 'msg' => 'id必填'];
        }
        $data = Backups::backupsDeatil($params);
        $res['id'] = $data[0]['id'];
        $res['info'] = unserialize($data[0]['content']);
        if ($data) {
            return ['code' => 1, 'data' => $res];
        }
        return ['code' => 90002, 'msg' => '查询失败'];
    }

    /**
     * 备份数据的删除
     * @return array
     */
    public function backupsDelete($params)
    {
        if (!isset($params['id'])) {
            return ['code' => 90002, 'msg' => 'id必填'];
        }
        $id = explode(',', $params['id']);
        $res = Backups::backupsDelete($id);
        if ($res) {
            return ['code' => 1, 'msg' => '删除成功'];
        }
        return ['code' => 90002, 'msg' => '删除失败'];
    }

    /**
     * 备份记录的列表
     * @return array
     */
    public function backupsTimeList($params)
    {
        $params['star_time'] = isset($params['star_time']) ? $params['star_time'] : null;
        $params['end_time'] = isset($params['end_time']) ? $params['end_time'] : null;
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 20;
        $params['page'] = isset($params['page']) ? $params['page'] : 1;
        $data = Backups::backupsList($params);
        $result = [];
        foreach ($data as $k => $v) {
            $result[] = $v['backup_time'];
        }
        $now = [];
        foreach (array_unique($result) as $v) {
            $now[]['time'] = $v;
        }
        if (!empty($params['star_time']) && !empty($params['end_time'])) {
            $end = [];
            foreach ($now as $v) {
                if ($v['time'] <= $params['end_time'] && $v['time']>= $params['star_time']) {
                    $end[] = $v;
                }
            }
            return ['code' => 1, 'data' => $this->arrayPage($params, $end)];
        }
        return ['code' => 1, 'data' => $this->arrayPage($params, $now)];
    }


    /**
     * 备份数据的列表
     * @return array
     */
    public function backupsList($params)
    {
        if (!isset($params['backup_time'])) {
            return ['code' => 90002, 'msg' => '记录时间不能为空'];
        }
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 20;
        $params['page'] = isset($params['page']) ? $params['page'] : 1;
        $params['star_time'] = isset($params['star_time']) ? $params['star_time'] : null;
        $params['end_time'] = isset($params['end_time']) ? $params['end_time'] : null;
        $params['stu_sn'] = isset($params['stu_sn']) ? $params['stu_sn'] : null;
        $params['stu_name'] = isset($params['stu_name']) ? $params['stu_name'] : null;
        $params['admin_name'] = isset($params['admin_name']) ? $params['admin_name'] : null;
        $data = Backups::backupsListBackup($params);
        #处理数据
        $result = [];
        foreach ($data as $k => $v) {
            $result[$k][] = unserialize($v['content']);
            $result[$k][]['id'] = $v['id'];
        }
        $now_data = [];
        foreach ($result as $k => $v) {
            $v[0]['created_time'] = strtotime($v[0]['updated_at']);
            $v[0]['id_card'] = $v[0]['admin_name'];
            $v[0]['id'] = $v[1]['id'];
            $now_data[] = $v[0];
        }
        #筛选不为空的参数
        $time['star_time'] = $params['star_time'];
        $time['end_time'] = $params['end_time'];
        $key_name = ['stu_sn', 'stu_name', 'admin_name'];
        $filter = [];
        foreach ($key_name as $v) {
            if (!is_null($params[$v])) {
                $filter[$v] = $params[$v];
            }
        }
        $end = [];
        #判断是否设置开始时间和结束时间
        if (!empty($time['star_time']) || !empty($time['end_time'])) {
            foreach ($now_data as $v) {
                if ($v['created_time'] >= $time['star_time'] && $v['created_time'] <= $time['end_time']) {
                    #是否含有其他参数
                    if (isset($filter['stu_sn']) || isset($filter['stu_name']) || isset($filter['admin_name'])) {
                        $end[] = $this->regex($filter, $v);
                    } else {
                        $end[] = $v;
                    }
                }
            }
            return ['code' => 1, 'data' => $this->arrayPage($params, $this->sort(array_filter($end)))];
        } else {
            foreach ($now_data as $v) {
                if (isset($filter['stu_sn']) || isset($filter['stu_name']) || isset($filter['admin_name'])) {
                    $end[] = $this->regex($filter, $v);
                } else {
                    $end[] = $v;
                }
            }
            return ['code' => 1, 'data' => $this->arrayPage($params, $this->sort(array_filter($end)))];
        }
    }

    #正则
    public function regex($filter, $v)
    {
        if (isset($filter['stu_sn']) && !isset($filter['stu_name']) && !isset($filter['admin_name'])) {
            if (preg_match_all('/' . $filter['stu_sn'] . '/', $v['stu_sn'])) {
                return $v;
            }
        }
        if (!isset($filter['stu_sn']) && isset($filter['stu_name']) && !isset($filter['admin_name'])) {
            if (preg_match_all('/' . $filter['stu_name'] . '/', $v['stu_name'])) {
                return $v;
            }
        }
        if (!isset($filter['stu_sn']) && !isset($filter['stu_name']) && isset($filter['admin_name'])) {
            if (preg_match_all('/' . $filter['admin_name'] . '/', $v['admin_name'])) {
                return $v;
            }
        }
        if (isset($filter['stu_sn']) && isset($filter['stu_name']) && !isset($filter['admin_name'])) {
            if (preg_match_all('/' . $filter['stu_sn'] . '/', $v['stu_sn'])
                && preg_match_all('/' . $filter['stu_name'] . '/', $v['stu_name'])) {
                return $v;
            }
        }
        if (isset($filter['stu_sn']) && !isset($filter['stu_name']) && isset($filter['admin_name'])) {
            if (preg_match_all('/' . $filter['stu_sn'] . '/', $v['stu_sn'])
                && preg_match_all('/' . $filter['admin_name'] . '/', $v['admin_name'])) {
                return $v;
            }
        }
        if (!isset($filter['stu_sn']) && isset($filter['stu_name']) && isset($filter['admin_name'])) {
            if (preg_match_all('/' . $filter['stu_name'] . '/', $v['stu_name'])
                && preg_match_all('/' . $filter['admin_name'] . '/', $v['admin_name'])) {
                return $v;
            }
        }
        if (isset($filter['stu_sn']) && isset($filter['stu_name']) && isset($filter['admin_name'])) {
            if (preg_match_all('/' . $filter['stu_name'] . '/', $v['stu_name'])
                && preg_match_all('/' . $filter['admin_name'] . '/', $v['admin_name'])
                && preg_match_all('/' . $filter['stu_sn'] . '/', $v['stu_sn'])) {
                return $v;

            }
        }
        return [];
    }

    #排序
    public function sort($end)
    {
        $data = [];
        foreach ($end as $v) {
            $data[] = $v;
        }
        return $data;
    }

    #数组分页
    public function arrayPage($params, $data)
    {
        #数组分页
        $start = ($params['page'] - 1) * $params['limit'];
        $totals = count($data);
        $pagedata = array();
        $pagedata = array_slice($data, $start, $params['limit']);
        $list['list'] = $pagedata;
        $list['page'] = $params['page'];
        $list['limit'] = $params['limit'];
        $list['count'] = $totals;
        return $list;
    }

}
