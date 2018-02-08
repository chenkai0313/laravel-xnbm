<?php
/**
 * 日志模块
 * Author: 叶帆
 * Date: 2017/8/14
 */
namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LogController
{
    /**
     * 日志列表
     * @param Request $request
     * @return array
     */
    public function logList(Request $request)
    {
        $params=$request->input();
        return \AdminLogService::adminLogList($params);
    }

    /**
     * 日志列表
     * @param Request $request
     * @return array
     */
    public function logDetail(Request $request)
    {
        $params=$request->input();
        return \AdminLogService::adminLogDetail($params);
    }

}