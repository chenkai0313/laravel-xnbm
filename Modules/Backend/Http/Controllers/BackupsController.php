<?php
/**
 * 学生注册信息 报名信息的备份
 * Author: CK
 * Date: 2018/1/11
 */

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;

class BackupsController
{
    /**
     * 备份数据的添加
     * @return array
     */
    public function backupsAdd(Request $request)
    {
        $params = $request->all();
        $result = \BackupsService::backupsAdd($params);
        return $result;
    }

    /**
     * 备份数据的详情
     * @return array
     */
    public function backupsDetail(Request $request)
    {
        $params = $request->all();
        $result = \BackupsService::backupsDetail($params);
        return $result;
    }

    /**
     * 备份数据的删除
     * @return array
     */
    public function backupsDelete(Request $request)
    {
        $params = $request->all();
        $result = \BackupsService::backupsDelete($params);
        return $result;
    }

    /**
     * 备份数据的列表
     * @return array
     */
    public function backupsList(Request $request)
    {
        $params = $request->all();
        $result = \BackupsService::backupsList($params);
        return $result;
    }


    /**
     * 备份记录的列表
     * @return array
     */
    public function backupsTimeList(Request $request)
    {
        $params = $request->all();
        $result = \BackupsService::backupsTimeList($params);
        return $result;
    }



}