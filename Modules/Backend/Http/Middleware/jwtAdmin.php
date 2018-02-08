<?php

namespace Modules\Backend\HTTP\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Entrust;

class jwtAdmin
{
    public function handle($request, Closure $next)
    {

        $this->registerJWTConfig();
        #获取当前路由器信息
        $request_info = request()->route()->getAction();
        $arr = explode('@', $request_info['controller']);
        #若非登录页面，则验证JWT与RBAC
        if ($arr['1'] != 'adminLogin') {
            #验证登录   JWT
            try {
                $payload = JWTAuth::parseToken()->getPayload();
                $from = $payload->get('from');
                if (!$from == 'admin' || !$user = JWTAuth::parseToken()->authenticate()) {
                    return ['code' => 10094, 'msg' => '找不到该管理员'];
                }
                $is_super = $payload->get('is_super');
                #清空表过滤的接口（只有管理员操作）
                if (in_array($request_info['uri'], $this->filterRouteAdmin())) {
                    if ($is_super !== 0) {
                        return ['code' => 90002, 'msg' => '无权操作'];
                    }
                }
                #只能老师能操作的接口
                if(in_array($request_info['uri'],$this->filterRouteTch())){
                    if ($is_super == 2) {
                        return ['code' => 90002, 'msg' => '无权操作'];
                    }
                }
            } catch (Exception $e) {
                if ($e instanceof TokenInvalidException)
                    return ['code' => 10091, 'msg' => 'token信息不合法'];
                else if ($e instanceof TokenExpiredException) {
                    return ['code' => 10092, 'msg' => '登录信息过期'];
                } else {
                    return ['code' => 10093, 'msg' => '登录验证失败'];
                }
            }
        }
        return $next($request);
    }

    #清空表过滤的接口（只有管理员操作）
    public function filterRouteAdmin()
    {
        $route = [
//            '/backend/school-del-all'
        ];
        return $route;
    }

    #只能老师能操作的接口
    public function filterRouteTch()
    {
        $route = [
//            '/backend/school-del-all'
        ];
        return $route;
    }

    protected function registerJWTConfig()
    {
        \Config::set('jwt.user', 'Modules\Backend\Models\Admin');
        \Config::set('auth.providers.users.table', 'admins');
        \Config::set('auth.providers.users.model', \Modules\Backend\Models\Admin::class);
        \Config::set('jwt.identifier', 'admin_id');
        \Config::set('cache.default', 'array');//RBAC
    }

}
