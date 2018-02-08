<?php
/**
 * 设置系统时间
 * Author: CK
 * Date: 2017/12/27
 */

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;

class SysTimeController
{
    /**
     * 设置系统时间的添加
     * @return array
     */
    public function sysTimeAdd(Request $request)
    {
        $params = $request->all();
        $result = \SysTimeService::sysTimeAdd($params);
        return $result;
    }

    /**
     * 显示最新设置的时间（一条）
     * @return array
     */
    public function sysTimeNewOne()
    {
        $result = \SysTimeService::sysTimeNewOne();
        return $result;
    }


}
