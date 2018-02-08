<?php
/**
 * RBAC  权限-角色表
 * Author: 葛宏华
 * Date: 2017/7/27
 */
namespace Modules\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $table      = 'permission_role';

    protected $fillable = array('permission_id','role_id');

    public    $timestamps = false;
    /**
     * 角色-权限 列表
     * @param int $limit 每页显示数量
     * @param int $page 当前页数
     * @param string $keyword 关键词
     * @return array
     */
    public static function permissionRoleList($params)
    {
        $result = PermissionRole::select(['permission_id','role_id'])->get();
        return $result;
    }
    /**
     * 角色-权限  添加
     * @params int $permission_id 权限ID
     * @params int $role_id 角色ID
     * @return array
     */
    public static function permissionRoleAdd($params){
        $permission_ids = explode(',',$params['permission_id']);

        // 过滤重复数据
        $same = array_count_values($permission_ids);
        foreach ($permission_ids as $k=>$v){
            if($same[$permission_ids[$k]] > 1){
                $same[$permission_ids[$k]] -= 1;
                unset($permission_ids[$k]);
            }
        }

        foreach($permission_ids as $k=>$v){
            if(!empty($v)){
                $data['role_id'] = $params['role_id'];
                $data['permission_id'] = $v;
                $result = PermissionRole::Create($data);
            }
        }
        return $result;
    }
    /**
     * 角色-权限  删除
     * @param int $role_id 角色ID
     * @return array
     */
    public static function permissionRoleDelete($role_id){
        $result = PermissionRole::where('role_id',$role_id)->delete();
        return $result;
    }
    /**
     * 角色-权限  详情
     * @param int $role_id 角色ID
     * @return array
     */
    public static function permissionRoleDetail($role_id){
        $result = PermissionRole::where('role_id',$role_id)->get();
        return $result;
    }
    /**
     * 角色-权限  账号是否唯一
     * @param int $permission_id 权限ID
     * @param int $role_id 角色ID
     * @return array
     */
    public static function permissionRoleExist($params){
        $role_id = explode(',',$params['role_id']);
        $result = PermissionRole::where('permission_id',$params['permission_id'])->whereIn('role_id',$role_id)->count();
        return $result;
    }
    /**
     * 角色-权限  获取角色的权限ID
     * @param int $role_id 用户ID
     * @return array
     */
    public static function permissionRoleID($role_id){
        $result = PermissionRole::where('role_id',$role_id)->pluck("permission_id");
        return $result;
    }

}