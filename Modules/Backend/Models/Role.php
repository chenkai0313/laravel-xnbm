<?php
/**
 * RBAC   角色表
 * Author: 葛宏华
 * Date: 2017/7/27
 */
namespace Modules\Backend\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $table      = 'roles';

    protected $primaryKey = 'id';

    /**
     * 角色 列表
     * @return array
     */
    public static function roleList()
    {
        #参数
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 10;
        #获取数据
        $total = Role::count();
        $pages = ceil($total/$params['limit']);
        $list = Role::select(['id','name','display_name','description','r_level','created_at'])->orderBy("id")->paginate($params['limit'])->toArray()['data'];
        $result['list'] = $list;
        $result['total'] = $total;
        $result['pages'] = $pages;
        return $result;
    }
    /**
     * 角色 列表
     * @return array
     */
    public static function roleListAll()
    {
        $result = Role::select(['id','name','display_name','description','r_level','created_at'])
            ->orderBy("id")->get()->toArray();
        return $result;
    }
    /**
     * 角色  添加
     * @param string $name 名称
     * @param string $display_name 可读名称
     * @param string $description 描述
     * @return array
     */
    public static function roleAdd($params){
        $role = new Role();
        $role->name = $params['name'];
        $role->display_name = $params['display_name'];
        $role->r_level = $params['r_level'];
        $role->description = $params['description'];
        $result = $role->save();
        return $result;
    }
    /**
     * 角色  编辑
     * @params string $name 名称
     * @params string $display_name 可读名称
     * @params string $description 描述
     * @return array
     */
    public static function roleEdit($params){
        $role =  Role::find($params['role_id']);
        $role->name = $params['name'];
        $role->display_name = $params['display_name'];
        if(isset($params['r_level'])){
            $role->r_level = $params['r_level'];
        }
        $role->description = $params['description'];
        $result = $role->save();
        return $result;
    }
    /**
     * 角色  详情
     * @param int $role_id 角色ID
     * @return array
     */
    public static function roleDetail($role_id){
        $result = Role::where('id',$role_id)->first();
        return $result;
    }
    /**
     * 角色  删除
     * @param int $role_id 角色ID
     * @return array
     */
    public static function roleDelete($role_id){
        $role_ids = explode(',',$role_id);
        $result = Role::whereIn('id',$role_ids)->where('id','!=',1)->delete();
        return $result;
    }
    /**
     * 角色  账号是否唯一
     * @params int $role_id 角色ID
     * @return array
     */
    public static function roleExist($name,$id=''){
        $result = Role::where('name',$name)->where(function($query) use($id) {  
                        $query->where('id', '!=',$id);
                   })->count();
        return $result;
    }
}