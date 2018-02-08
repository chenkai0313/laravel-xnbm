<?php
/**
 * RBAC  模块
 * Author: 葛宏华
 * Date: 2017/7/27
 */
namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseApiController;

class RbacController extends BaseApiController
{
    /**
     * 所有角色列表
     */
    public  function roleListAll(Request $request)
    {
        $params = $request->all();
        $result = \RbacService::roleListAll($params);
        return $result;
    }
    /**
     * 角色列表
     */
    public  function roleList(Request $request)
    {
        $params = $request->all();
        $result = \RbacService::roleList($params);
        return $result;
    }
    /**
     * 角色添加
     */
    public function roleAdd(Request $request)
    {
        $params = $request->all();
        $result = \RbacService::roleAdd($params);
        return $result;
    }
    /**
     * 角色编辑
     */
    public function roleEdit(Request $request)
    {
        $params = $request->all();
        $result = \RbacService::roleEdit($params);
        return $result;
    }
    /**
     * 角色删除
     */
    public function roleDelete(Request $request)
    {
        $params = $request->all();
        $result = \RbacService::roleDelete($params);
        return $result;
    }
    /**                                                                                               
     * 角色详细
     */
    public function roleDetail(Request $request)
    {
        $params = $request->all();
        $role_id = $params['role_id'];
        $result = \RbacService::roleDetail($role_id);
        return $result;
    }
    /**
     * 权限层级列表
     */
    public  function permissionType()
    {
        $result = \RbacService::permissionType();
        return $result;
    }
    /**
     * 权限列表
     */
    public  function permissionList(Request $request)
    {
        $params = $request->all();
        $result = \RbacService::permissionList($params);
        return $result;
    }
    /**
     * 权限添加
     */
    public function permissionAdd(Request $request)
    {
        $params = $request->all();
        $result = \RbacService::permissionAdd($params);
        return $result;
    }
    /**
     * 权限编辑
     */
    public function permissionEdit(Request $request)
    {
        $params = $request->all();
        $result = \RbacService::permissionEdit($params);
        return $result;
    }
    /**
     * 权限删除
     */
    public function permissionDelete(Request $request)
    {
        $params = $request->all();
        $result = \RbacService::permissionDelete($params);
        return $result;
    }
    /**
     * 权限详细
     */
    public function permissionDetail(Request $request)
    {
        $params = $request->all();
        $permission_id = $params['permission_id'];
        $result = \RbacService::permissionDetail($permission_id);
        return $result;
    }
    /**
     * 角色-用户列表
     */
    public  function roleAdminList(Request $request)
    {
        $params = $request->all();
        $result = \RbacService::roleAdminList($params);
        return $result;
    }
    /**
     * 角色-用户添加
     */
    public function roleAdminAdd(Request $request)
    {
        $params = $request->all();
        $result = \RbacService::roleAdminAdd($params);
        return $result;
    }
    /**                                                                                               
     * 角色-用户详细
     */
    public function roleAdminDetail(Request $request)
    {
        $params = $request->all();
        $admin_id = $params['admin_id'];
        $result = \RbacService::roleAdminDetail($admin_id);
        return $result;
    }
    /**
     * 角色-权限列表
     */
    public  function permissionRoleList(Request $request)
    {
        $params = $request->all();
        $result = \RbacService::permissionRoleList($params);
        return $result;
    }
    /**
     * 角色-权限添加/编辑
     */
    public function permissionRoleAdd(Request $request)
    {
        $params = $request->all();
        $result = \RbacService::permissionRoleAdd($params);
        return $result;
    }
    /**                                                                                               
     * 角色-权限详细
     */
    public function permissionRoleDetail(Request $request)
    {
        $params = $request->all();
        $role_id = $params['role_id'];
        $result = \RbacService::permissionRoleDetail($role_id);
        return $result;
    }
    /**
     * ideabuy左侧菜单
     * @return array
     */
    public function permissionLeft(Request $request) {
        $result = \RbacService::permissionLeft();
        return $result;
    }
}
