<?php
/**
 * 后台日志管理模块
 * Author: 叶帆
 * Date: 2017/8/16
 */

namespace Modules\Backend\Services;

use Modules\Backend\Models\Permission;
use Modules\Backend\Models\AdminLog;
use Modules\Backend\Models\Admin;
use Illuminate\Support\Facades\DB;

class AdminLogService
{
    /**
     * 日志 列表
     * @params int $limit 每页显示数量
     * @params int $page 当前页数
     * @return array
     */
    public function adminLogList($params){
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 20;
        $res = AdminLog::adminLogList($params);
        foreach ($res['list'] as $key => $vo){
            $res['list'][$key]['operate_result'] = $vo['operate_status'] == 1 ? '操作成功' : '操作失败';
        }
        $result['data']['admin_list'] = $res['list'];
        $result['data']['total'] = $res['total'];
        $result['data']['pages'] = $res['pages'];
        $result['code'] = 1;
        return $result;
    }

    /**
     * 日志 列表
     * @params int $limit 每页显示数量
     * @params int $page 当前页数
     * @return array
     */
    public function adminLogDetail($params){
        if (empty($params['log_id'])) {
            return ['code' => 10200, 'msg' => 'log_id 必填'];
        }
        $res = AdminLog::adminLogDetail($params);
        if ($res) {
            $res['operate_result'] = $res['operate_status'] == 1 ? '操作成功' : '操作失败';
            if(isset($res['operate_content'])){
                unset($res['operate_content']);
            }
            $data = ['log_detail' => $res];
            return ['code' => 1, 'msg' => '查询成功', 'data' => $data];
        } else {
            return ['code' => 10201, 'msg' => '日志查询失败'];
        }
    }

    /**
     * 日志 添加
     * @params array $data 请求参数
     * @params string $routes 路由参数
     * @params string $ip 操作ip
     * @params array $result 操作结果
     */
    public function LogAdd($params){
        $routes = explode('@',$params['routes']['controller']);       // 访问地址
        $controller = $routes[0];
        $model = $routes[1];
        $log_data['remark'] = isset($params['result']['msg']) ? $params['result']['msg']:"无";

        //取消日志列表记录  防止字段过多无法显示-过滤
        $free = [
            'routes'=>$params['routes']['controller']
        ];
        if( $this->freeLogs($free) ){
            return ;
        }

        // 处理特殊操作-登录
        if($model == 'adminLogin'){
            if (empty($params['data']['admin_name'])){
                $log_data['admin_name'] = '未知';
                $log_data['admin_id'] = 0;
            } else {
                $log_data['admin_name'] = $params['data']['admin_name'];
                $adminDetail = Admin::adminInfo($params['data']['admin_name']);
                $log_data['admin_id'] = $adminDetail['admin_id'];
            }
        }else{
            $res1 = Permission::permissionDetailByName($model);
            if($res1 && $res1['level'] != 1){
                $model = $res1['display_name'];
                $res2 = Permission::permissionDetail($res1['pid']);
                if($res2){
                    $controller = $res2['display_name'];
                }
            }else{
                $log_data['remark'] = '记录日志出错：'.$model.'操作方法不存在于权限表中';
            }

            // 获取管理员id
            $log_data['admin_id'] = get_admin_id();
            // 管理员账号
            $adminDetail = Admin::adminDetail($log_data['admin_id']);
            $log_data['admin_name'] = $adminDetail['admin_name'];
        }
        // 操作ip地址
        $log_data['operate_ip'] = $params['ip'];
        $log_data['operate_time'] = date('Y-m-d H:i:s',time());
        $log_data['operate_target'] = strtolower($controller."/".$model) == 'admincontroller/adminlogin'?"用户登陆":$controller."/".$model;
        $log_data['operate_status'] = isset($params['result']['code']) && $params['result']['code'] == 1 ? 1 : 2;
        $log_data['operate_content'] = json_encode(['request'=>$params['data'], 'response'=>$params['result']]);
        $log_data['admin_id'] = is_null( $log_data['admin_id'])?0: $log_data['admin_id'];
        $log_data['admin_name']= is_null( $log_data['admin_name'])? $params['data']['admin_name']: $log_data['admin_name'];
        $operate_id = AdminLog::adminLogAdd($log_data);
        if(!$operate_id){
            \Log::error('后台日志');
        }
    }

    // 过滤免记录接口
    protected function freeLogs($params){
        $free = [
            'LogController@logList',
            'LogController@logDetail',
            'LogController@logDetail',
            'RbacController@permissionLeft',
            'UnfinishedController@unfinishReportCount',
            'InmailController@inmailUnreadCount',
            'InmailController@inmailSearchUser',
            'InmailController@inmailEditStatus',
            'AdminController@adminListAll',
            'ReportController@reportTimeRefresh',
            'ReportController@receiptRead',
        ];

        if(in_array($params['routes'],$free)){
            return true;
        }else{
            return false;
        }
    }

}