<?php
/**
 * 站点配置
 * Author: CK
 * Date: 2018/1/17
 */

namespace Modules\Backend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ConfigController extends Controller
{
    /**
     * 站点配置的添加
     * @return array
     */
    public function configAdd(Request $request)
    {
        $params = $request->all();
        $result = \ConfigService::configAdd($params);
        return $result;
    }

    /**
     * 站点配置的修改
     * @return array
     */
    public function configEdit(Request $request)
    {
        $params = $request->all();
        $result = \ConfigService::configEdit($params);
        return $result;
    }

    /**
     * 站点配置的详情
     * @return array
     */
    public function configDetail(Request $request)
    {
        $params = $request->all();
        $result = \ConfigService::configDetail($params);
        return $result;
    }
}
