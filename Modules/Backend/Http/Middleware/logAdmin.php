<?php

namespace Modules\Backend\HTTP\Middleware;

use Closure;

class logAdmin
{
    /**
     * 后台操作日志记录过滤
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data = $request->all();            // 请求数据
        $routes = $request->route()->getAction();       // 路由
        $ip = $request->getClientIp();      // 获取ip
        $response = $next($request);        // 返回结果
        $result = $response->original;
        $params['data'] = $data;
        $params['routes'] = $routes;
        $params['ip'] = $ip;
        $params['result'] = $result;
        \AdminLogService::LogAdd($params);
        return $response;
    }

}