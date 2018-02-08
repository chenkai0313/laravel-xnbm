<?php

namespace Modules\Backend\HTTP\Middleware;

use Closure;
use Modules\Backend\Http\Controllers\SysTimeController;
use JWTAuth;
use Exception;
use Modules\Backend\Models\Admin;
use Session;

class sysTimeStart
{
    /**
     * 系统时间段路由设置
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routes = $request->route()->getAction();// 路由
        if (in_array($routes['uri'], $this->filterRoute())) {
            try {
                $data = new SysTimeController();
                $sysTime = $data->sysTimeNewOne();
                #报名时间段路由
                if (time() > strtotime($sysTime['data']['list']['enroll_start']) && time() < strtotime($sysTime['data']['list']['face_start'])) {
                    if (in_array($routes['uri'], $this->enrollRoute())) {
                        return $next($request);
                    } else {
                        return ['code' => 90002, 'msg' => '当前时间段不允许访问'];
                    }
                }

            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        #导出路由通过token验证
        if (in_array($routes['uri'], $this->excelExport())) {
            try {
                $user = Admin::where('admin_id', $_GET['d'])->first();
                if ($user['remember_token'] == $_GET['t']) {
                    return $next($request);
                } else {
                    return ['code' => 90002, 'msg' => '访问路由错误'];
                }
            } catch (Exception $e) {
                return ['code' => 90002, 'msg' => '访问路由错误'];
            }
        }
        return $next($request);
    }

    #导出路由
    public function excelExport()
    {
        $route = ['/backend/apply-excel-export'];
        return $route;
    }

    #需要时间过滤的所有接口
    public function filterRoute()
    {
        $route = [
            '/backend/school-add-stu',
        ];
        return $route;
    }

    #需要时间过滤的报名相关接口
    public function enrollRoute()
    {
        $route = [
            '/backend/school-add-stu'
        ];
        return $route;
    }

    #需要时间过滤的面试相关接口
    public function faceRoute()
    {
        $route = [
        ];
        return $route;
    }

    #需要时间过滤的面试结果相关接口
    public function endRoute()
    {
        $route = [
        ];
        return $route;
    }
}