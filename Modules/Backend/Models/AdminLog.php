<?php
/**
 * adminlog  操作日志表
 * Author: 叶帆
 * Date: 2017/8/16
 */
namespace Modules\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    protected $table      = 'admin_log';

    protected $primaryKey = 'log_id';

    protected $fillable = ['admin_name','admin_id', 'operate_target', 'operate_ip', 'operate_content', 'operate_time',
        'operate_status', 'remark'];

    public    $timestamps = false;

    /**
     * 日志 列表
     * @params int $limit 每页显示数量
     * @params int $page 当前页数
     * @params string $keyword 关键词
     * @return array
     */
    public static function adminLogList($params)
    {
        $list = AdminLog::select(['log_id', 'admin_name', 'admin_id', 'operate_target', 'operate_ip', 'operate_time', 'operate_status', 'remark'])
            ->Search($params)
            ->orderBy('log_id', 'desc')
            ->paginate($params['limit'])
            ->toArray();
        $result['list'] = $list['data'];
        $result['total'] = $list['total'];
        $result['pages'] = ceil($list['total']/$params['limit']);
        return $result;
    }

    public static function adminLogDetail($params)
    {
        $result = AdminLog::find($params['log_id']);
        return $result;
    }

    #查询构造器 Like
    public function scopeSearch($query, $keyword){
        return $query->where(function($query) use($keyword) {
            // 管理员名称
            if ( isset($keyword['admin_name']) && $keyword['admin_name'] ) {
                $query->where('admin_name', 'like', '%' . strip_tags($keyword['admin_name']) . '%');
            }
            // ip
            if ( isset($keyword['operate_ip']) ) {
                $query->where('operate_ip', '=', $keyword['operate_ip'] );
            }
            // 操作内容
            if ( isset($keyword['operate_target']) ) {
                $query->where('operate_target', 'like', '%' . strip_tags($keyword['operate_target']) . '%' );
            }
        });
    }

    /**
     * 日志 添加
     * @param string $admin_name 管理员名称
     * @param int $admin_id 管理员id
     * @param int $operate_type 数据操作类型(1增加 2删除 3修改 4查看 5登录)
     * @param string $operate_module 操作模块
     * @param string $operate_name 操作名称
     * @param string $operate_ip 操作ip
     * @param string $operate_content 日志记录内容（不能记录sql）
     * @param string $operate_time 操作时间
     * @param int $operate_status 操作状态：1成功，2失败
     * @param string $remark 备注
     * @return bool
     */
    public static function adminLogAdd($params){
        $res = AdminLog::create($params);
        return $res->log_id;
    }

    /**
     * 日志 修改-仅限操作状态与备注
     * @params string $log_id 日志id
     * @params int $operate_status 操作状态：1成功，2失败
     * @params string $remark 备注
     * @return bool
     */
    public static function adminLogEdit($params){
        $adminLog = AdminLog::find($params['log_id']);
        $adminLog->operate_status = $params['operate_status'];
        $adminLog->remark = $params['remark'];
        $result = $adminLog->save();
        return $result;
    }
}