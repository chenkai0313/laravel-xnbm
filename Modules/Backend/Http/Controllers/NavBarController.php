<?php
/**
 * 导航栏
 * Author: CK
 * Date: 2017/1/3
 */

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;

class NavBarController
{
    /**
     * 导航栏的添加
     * @return array
     */
    public function navBarAdd(Request $request)
    {
        $params = $request->all();
        $result = \NavBarService::navBarAdd($params);
        return $result;
    }

    /**
     * 导航栏的修改
     * @return array
     */
    public function navBarEdit(Request $request)
    {
        $params = $request->all();
        $result = \NavBarService::navBarEdit($params);
        return $result;
    }

    /**
     * 导航栏的删除
     * @return array
     */
    public function navBarDelete(Request $request)
    {
        $params = $request->all();
        $result = \NavBarService::navBarDelete($params);
        return $result;
    }

    /**
     * 导航栏的详情
     * @return array
     */
    public function navBarDetail(Request $request)
    {
        $params = $request->all();
        $result = \NavBarService::navBarDetail($params);
        return $result;
    }

    /**
     * 导航栏的列表
     * @return array
     */
    public function navBarList(Request $request)
    {
        $params = $request->all();
        $result = \NavBarService::navBarList($params);
        return $result;
    }



}
