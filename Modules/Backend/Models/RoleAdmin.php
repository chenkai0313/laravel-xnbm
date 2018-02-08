<?php
/**
 * RBAC  角色-管理员表
 * Author: 葛宏华
 * Date: 2017/7/27
 */
namespace Modules\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleAdmin extends Model
{
    protected $table      = 'role_admin';

    protected $fillable = array('admin_id','role_id');

    public    $timestamps = false;
    /**
     * 角色-用户 列表
     * @params int $limit 每页显示数量
     * @params int $page 当前页数
     * @return array
     */
    public static function roleAdminList($params)
    {
        #参数
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 10;
        #获取数据
        $total = RoleAdmin::count();
        $pages = ceil($total/$params['limit']);
        $list = RoleAdmin::select(['admin_id','role_id'])->paginate($params['limit'])->toArray()['data'];
        #返回
        $result['list'] = $list;
        $result['total'] = $total;
        $result['pages'] = $pages;
        return $result;
    }
    /**
     * 角色-用户  添加
     * @params int $admin_id 用户ID
     * @params string $role_id 角色ID
     * @return array
     */
    public static function roleAdminAdd($params){
        $role_ids = explode(',',$params['role_id']);
        foreach($role_ids as $k=>$v){
            $data['admin_id'] = $params['admin_id'];
            $data['role_id'] = $v;
            $result = RoleAdmin::Create($data);
        }
        return $result;
    }
    /**
     * 角色-用户  删除
     * @param int $admin_id 用户ID
     * @return array
     */
    public static function roleAdminDelete($admin_id){
        $result = RoleAdmin::where('admin_id',$admin_id)->delete();
        return $result;
    }
    /**
     * 角色-用户  详情
     * @param int $admin_id 用户ID
     * @return array
     */
    public static function roleAdminDetail($admin_id){
        $result = RoleAdmin::where('admin_id',$admin_id)->get();
        return $result;
    }
    /**
     * 角色-用户  账号是否唯一
     * @params int $admin_id 用户ID
     * @params string $role_id 角色ID
     * @return array
     */
    public static function roleAdminExist($params){
        $role_ids = explode(',',$params['role_id']);
        $result = RoleAdmin::where('admin_id',$params['admin_id'])->whereIn('role_id',$role_ids)->count();
        return $result;
    }
    /**
     * 角色-用户  获取角色ID
     * @param int $admin_id 用户ID
     * @return array
     */
    public static function adminRoleID($admin_id){
        $result = RoleAdmin::where('admin_id',$admin_id)->pluck("role_id");
        return $result;
    }
}