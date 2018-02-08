<?php
/**
 * 角色模块
 * Author: 葛宏华
 * Date: 2017/7/27
 */
namespace Modules\Backend\Services;

use Modules\Backend\Models\Role;
use Modules\Backend\Models\Permission;
use Modules\Backend\Models\PermissionRole;
use Modules\Backend\Models\RoleAdmin;
use Illuminate\Support\Facades\DB; 

class RbacService
{
    /**
     * 角色 列表
     * @params int $limit 每页显示数量
     * @params int $page 当前页数
     * @return array
     */
    public function roleListAll(){
        $role_list = Role::roleListAll();
        $result['data']['role_list'] = $role_list;
        $result['code'] = 1;
        return $result;
    }
    /**
     * 角色 列表
     * @params int $limit 每页显示数量
     * @params int $page 当前页数
     * @return array
     */
    public function roleList($params){
        $res = Role::roleList($params);
        $result['data']['role_list'] = $res['list'];
        $result['data']['total'] = $res['total'];
        $result['data']['pages'] = $res['pages'];
        $result['code'] = 1;
        return $result;
    }
    /**
     * 角色  添加
     * @params string $name 名称
     * @params string $display_name 可读名称
     * @params string $description 描述
     * @return array
     */
    public function roleAdd($params){
        $validator = \Validator::make(
            $params,
            \Config::get('validator.rbac.rbac.rbac-add'),
            \Config::get('validator.rbac.rbac.rbac-key'),
            \Config::get('validator.rbac.rbac.rbac-val')
        );
        if (!$validator->passes()) {
            return ['code' => 90001, 'msg' => $validator->messages()->first()];
        }

        if(!Role::roleExist($params['name'])){
            $res = Role::roleAdd($params);
            if($res){
                $result['code'] = 1;
                $result['msg'] = '添加成功';
            }else{
                $result['code'] = 10011;
                $result['msg'] = '添加失败';
            }
        }else{
            $result['code'] = 10014;
            $result['msg'] = '该角色名称已存在';
        }

        return $result;
    }
    /**
     * 角色  编辑
     * @params int $role_id 角色ID
     * @params string $role_password 密码
     * @return array
     */
    public function roleEdit($params){
        $res = Role::roleEdit($params);
        if($res!=false){
            $result['code'] = 1;
            $result['msg'] = '编辑成功';
        }else {
            $result['code'] = 10012;
            $result['msg'] = '编辑失败';
        }

        return $result;
    }
    /**
     * 角色  详情
     * @param int $role_id 角色ID
     * @return array
     */
    public function roleDetail($role_id){
        $res = Role::roleDetail($role_id);
        $result['data']['role_info'] = $res;
        $result['code'] = 1;
        return $result;
    }
    /**
     * 角色  删除
     * @params int $role_id 角色ID
     * @return array
     */
    public function roleDelete($params){
        $res = Role::roleDelete($params['role_id']);
        if($res){
            $result['code'] = 1;
            $result['msg'] = '删除成功';
        }else{
            $result['code'] = 10013;
            $result['msg'] = '删除失败';
        }

        return $result;
    }
    /**
     * 权限层级 列表
     * @return array
     */
    public function permissionType(){
        $res = Permission::permissionType();
        $result['data']['permission_type_list'] = $res;
        $result['code'] = 1;
        return $result;
    }
    /**
     * 权限 列表
     * @params int limit 每页显示数量
     * @params int page 当前页数
     * @return array
     */
    public function permissionList($params){
        $res = Permission::permissionList();
        $result['data']['permission_list'] = $res;
        $result['code'] = 1;
        return $result;
    }
    /**
     * 权限  添加
     * @params string name 名称
     * @params string display_name 可读名称
     * @params string description 描述
     * @params int pid 父级ID
     * @params int level 等级
     * @return array
     */
    public function permissionAdd($params){
        $params['path'] = is_null($params['path'])?"":$params['path'];
        if(!Permission::permissionExist($params['name'])){
            $res = Permission::permissionAdd($params);
            if($res){
                $result['code'] = 1;
                $result['msg'] = '添加成功';
            }else{
                $result['code'] = 10011;
                $result['msg'] = '添加失败';
            }
        }else{
            $result['code'] = 10014;
            $result['msg'] = '该权限名称已存在';
        }
        return $result;
    }
    /**
     * 权限  编辑
     * @params int permission_id 权限ID
     * @params string name 名称
     * @params string display_name 可读名称
     * @params string description 描述
     * @params int pid 父级ID
     * @params int level 等级
     * @return array
     */
    public function permissionEdit($params){
        $params['path'] = is_null($params['path'])?"":$params['path'];
        if(!Permission::permissionExist($params['name'],$params['permission_id'])){
            $res = Permission::permissionEdit($params);
            if($res!=false){
                $result['code'] = 1;
                $result['msg'] = '编辑成功';
            }else{
                $result['code'] = 10012;
                $result['msg'] = '编辑失败';
            }
        }else{
            $result['code'] = 10014;
            $result['msg'] = '该权限名称已存在';
        }
        return $result;
    }
    /**
     * 权限  详情
     * @params int permission_id 权限ID
     * @return array
     */
    public function permissionDetail($permission_id){
        $res = Permission::permissionDetail($permission_id);
        $result['data']['permission_info'] = $res;
        $result['code'] = 1;
        return $result;
    }
    /**
     * 权限  删除
     * @params int permission_id 权限ID
     * @return array
     */
    public function permissionDelete($params){
        $res = Permission::permissionDelete($params['permission_id']);
        if($res){
            $result['code'] = 1;
            $result['msg'] = '删除成功';
        }else{
            $result['code'] = 10013;
            $result['msg'] = '删除失败';
        }
        return $result;
    }
    /**
     * 角色-用户 列表
     * @params int limit 每页显示数量
     * @params int page 当前页数
     * @return array
     */
    public function roleAdminList($params){
        $res = RoleAdmin::roleAdminList($params);
        $result['data']['role_admin_list'] = $res['list'];
        $result['data']['total'] = $res['total'];
        $result['data']['pages'] = $res['pages'];
        $result['code'] = 1;
        return $result;
    }
    /**
     * 角色-用户  添加/编辑
     * @params int $admin_id 用户ID
     * @params int $role_id 角色ID
     * @return array
     */
    public function roleAdminAdd($params){
        if($params['admin_id'] && $params['role_id']){
            #先删除该用户的所有角色
            DB::beginTransaction();
            $res1 = RoleAdmin::roleAdminDelete($params['admin_id']);
            #再重新插入
            $res2 = RoleAdmin::roleAdminAdd($params);
            if($res1 && $res2){
                DB::commit();
                $result['code'] = 1;
                $result['msg'] = '添加成功';
            }else{
                DB::rollback();
                $result['code'] = 10021;
                $result['msg'] = '添加失败';
            }
        }else{
            $result['code'] = 90001;
            $result['msg'] = '传参错误';
        }
        return $result;
    }
    /**
     * 角色-用户  详情
     * @params int admin_id 角色ID
     * @return array
     */
    public function roleAdminDetail($admin_id){
        $res = RoleAdmin::roleAdminDetail($admin_id);
        $result['data']['role_admin_info'] = $res;
        $result['code'] = 1;
        return $result;
    }
    /**
     * 权限-角色 列表
     * @params int limit 每页显示数量
     * @params int page 当前页数
     * @return array
     */
    public function permissionRoleList($params){
        $res = PermissionRole::permissionRoleList($params);
        $result['data']['permission_role_list'] = $res;
        $result['code'] = 1;
        return $result;
    }
    /**
     * 权限-角色  添加/编辑
     * @params int permission_id 权限ID
     * @params int role_id 角色ID
     * @return array
     */
    public function permissionRoleAdd($params){
        if($params['permission_id'] && $params['role_id']){
            #先删除该角色的所有权限
            DB::beginTransaction();
            $res1 = PermissionRole::permissionRoleDelete($params['role_id']);
            #再重新插入
            $res2 = PermissionRole::permissionRoleAdd($params);
            if($res1!==false && $res2!==false){
                DB::commit();
                $result['code'] = 1;
                $result['msg'] = '编辑成功';
            }else{
                DB::rollback();
                $result['code'] = 10031;
                $result['msg'] = '编辑失败';
            }
        }else{
            $result['code'] = 90001;
            $result['msg'] = '传参错误';
        }
        return $result;
    }
    /**
     * 权限-角色  详情
     * @params int role_id 角色ID
     * @return array
     */
    public function permissionRoleDetail($role_id){
        #已有权限
        $has_permission_list = PermissionRole::permissionRoleID($role_id);
        #所有权限(分3个层级)
        $permission_list = Permission::permissionList();
        #该角色的权限
        $result['data']['has_permission_list'] = $has_permission_list;
        $result['data']['permission_list'] = $permission_list;
        $result['code'] = 1;
        return $result;
    }

    /**
     * 左侧菜单
     * @return array
     */
    public function permissionLeft() {
        $result = ['code'=>1,'msg'=>'查询成功'];
        $result['data']['menu'] = Permission::permissionLeft(get_admin_id());
        return $result;
    }

}
