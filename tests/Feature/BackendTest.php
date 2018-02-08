<?php
/**
 * Created by PhpStorm.
 * User: 张燕
 * Date: 2017/8/14
 * Time: 9:56
 */
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BackendTest extends TestCase
{
//
    public $data = ['Authorization'=>'Bearer ' . 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJmcm9tIjoidXNlciIsInVzZXJfaWQiOjE4LCJ1c2VyX21vYmlsZSI6IjE3NjgyNDUxMzk2Iiwic3ViIjoxOCwiaXNzIjoiaHR0cDovL2lkZWFidXkueGluLmNuL2FwaS91c2VyLWxvZ2luIiwiaWF0IjoxNTAyODY5NDQ4LCJleHAiOjE1MDQwNzkwNDgsIm5iZiI6MTUwMjg2OTQ0OCwianRpIjoiMElGYnMzVGtwejMyTlNubCJ9.Rkly1f0XUsXS5uZ3ng2SVmKDCWhdiksy7DzIZlHCQ04'];
    public $admin_token = ['Authorization'=>'Bearer ' . 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJmcm9tIjoiYWRtaW4iLCJhZG1pbl9pZCI6MSwiYWRtaW5fbmljayI6Ilx1NjYzNVx1NzlmMCIsInN1YiI6MSwiaXNzIjoiaHR0cDovL2lkZWFidXkueGluLmNuL2JhY2tlbmQvYWRtaW4tbG9naW4iLCJpYXQiOjE1MDI4NDYxNjAsImV4cCI6MTUwNDA1NTc2MCwibmJmIjoxNTAyODQ2MTYwLCJqdGkiOiJDWkJsZm5IQ085VkVobFBXIn0.W8FD4o-B8qdqKXaNPjQ_yWSKWHO4MRODXk-S8VzJZvE'];



    /*
   *   测试广告分类修改
   *   所需参数
   *   $params 'type_id','type_name','img_size'
   *
   */

    public function testadtype_edit()
    {
        $response = $this->post('http://ideabuy.xin.cn/backend/adtype-edit',['type_id'=>5,'type_name'=>'xx','img_size'=>'100*500'],$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonFragment([
                'msg'=>'修改成功',
            ]);

    }



//    /*
//*   测试广告分类新增
//*   所需参数
//*   $params 'type_id','type_name',
//*
//*/
//
    public function testadtype_add()
    {
        $response = $this->post('http://ideabuy.xin.cn/backend/adtype-add',['type_name'=>'muji','img_size'=>'100*500'],$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonFragment([
                'msg'=>'新增成功',
            ]);

    }

    /*
*   测试内容管理-类型-类型添加
*   所需参数
*   $params 'type_id','type_name','parent_id'
*
*/
    public function testarticletype_add()
    {
        $response = $this->post('http://ideabuy.xin.cn/backend/articletype-add',['type_name'=>'aaa','parent_id'=>6],$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonFragment([
                'msg'=>'添加成功',
            ]);

    }

    /*
*   测试内容管理-类型-类型添加
*   所需参数
*   $params 'type_id','type_name','parent_id'
*
*/
    public function testadtype_detail()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/adtype-detail?type_id=18',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }

    /*
*   测试内容管理-类型-添加文章
*   所需参数
*   $params 'type_id','article_content','admin_id',article_title
*
*/
    public function testarticle_add()
    {
        $response = $this->post('http://ideabuy.xin.cn/backend/article-add',['type_id'=>18,'article_content'=>'测试文章内容1','article_title'=>'测试文章题目1'],$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonFragment([
                'msg'=>'添加成功',
            ]);

    }


    /*
*   测试广告分类的列表
*   所需参数
*   $params 'page','limit','keyword'
*
*/
    public function testadtype_list()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/adtype-list?page=10&limit=1',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }

    /*
*   测试内容管理-公用-查询所有类型 下拉框用
*/
    public function testarticletype_select()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/articletype-select',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }


    /*
*   测试内容管理-类型-单个类型详情
*   所需参数
*   $params 'type_id'
*
*/
    public function testarticletype_detail()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/articletype-detail?type_id=1',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }

    /*
*   测试内容管理-类型-显示所有的类型
*   所需参数
*   $params 'type_id','limit','page'
*
*/
    public function testarticletype_list()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/articletype-list?keyword=1&limit=9&page=1',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }

    /*
*   测试广告分类的获取全部
*   所需参数
*   $params 'pic'
*
*/
    public function testadtype_spinner()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/adtype-spinner',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }


    /*
*   测试广告列表
*   所需参数
*   $params 'page','limit'
*
*/
    public function testad_list()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/ad-list?page=1&limit=5',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }

    /*
*   测试广告详情接口
*   所需参数
*   $params 'ad_id'
*
*/
    public function testad_detail()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/ad-detail?ad_id=2',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }

    /*
*   测试内容管理-文章-单个查询文章
*   所需参数
*   $params 'article_id'
*
*/
    public function testarticle_detail()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/article-detail?article_id=5',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }

    /*
*   测试内容管理-文章-查询所有（可以筛选）
*   所需参数
*   $params 'limit','page'
*
*/
    public function testarticle_list()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/article-list?limit=5&page=1',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }

    /*
*   测试查询管理员-详细
*   所需参数
*   $params 'limit','page'
*
*/
    public function testadmin_detail()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/admin-detail?admin_id=2',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }

    /*
*   测试管理员编辑
*   所需参数
*   $params 'admin_id','admin_password','admin_nick','admin_sex','admin_birthday','role_id'
*
*/
    public function testadmin_edit()
    {
        $response = $this->post('http://ideabuy.xin.cn/backend/admin-edit',['admin_id'=>'112','admin_password'=>321321321,'admin_nick'=>'小烦','admin_sex'=>1,'admin_birthday'=>'1995-11-25','role_id'=>1],$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonFragment([
                'msg'=>'编辑成功',
            ]);

    }

    /*
*   测试查询常量分类的列表
*/
    public function testconstype_list()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/constype-list',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }


    /*
*   测试常量分类的新增(权限很高,最好只能程序猿操作)
*    所需参数
*   $params 'type','name'
*/
//    public function testconstype_add()
//    {
//        $response = $this->post('http://ideabuy.xin.cn/backend/constype-add',['type'=>'xiaofan','name'=>'张小烦'],$this->admin_token)
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'新增成功',
//            ]);
//
//    }



    /*
*   常量的删除
*    所需参数
*   $params 'constant_id'
*/
//    public function testcons_delete()
//    {
//        $response = $this->post('http://ideabuy.xin.cn/backend/cons-delete',['constant_id'=>11])
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'常量删除成功',
//            ]);
//
//    }

    /*
*   测试查询常量详情接口
*/
    public function testcons_detail()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/cons-detail?constant_id=>1')
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }


    /*
*   测试获取权限分类
*/
    public function testpermission_type()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/permission-type',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }


    /*
    *   测试获取角色-权限 详细
    *    所需参数
    *   $params 'role_id'
    */
    public function testpermission_role_detail()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/permission-role-detail?role_id=1',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }

    /*
*   测试获取权限列表
*/
    public function testpermission_list()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/permission-list',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }


    /*
*   测试权限添加
*    所需参数
*   $params 'name','display_name','description','pid','level'
*/
//    public function testpermission_add()
//    {
//        $response = $this->post('http://ideabuy.xin.cn/backend/permission-add',['name'=>'test1','display_name'=>'testzy1','description'=>'test zyxiaofan1','pid'=>2,'level'=>3],$this->admin_token)
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'添加成功',
//            ]);
//
//    }


    /*
*   测试权限编辑
*    所需参数
*   $params 'permission_id','name','display_name','description','pid','level'
*/
    public function testpermission_edit()
    {
        $response = $this->post('http://ideabuy.xin.cn/backend/permission-edit',['permission_id'=>53,'name'=>11,'display_name'=>11,'description'=>11,'pid'=>1,'level'=>1],$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonFragment([
                'msg'=>'编辑成功',
            ]);

    }

    /*
    *   测试获取角色详情
    *    所需参数
    *   $params 'role_id'
    */
    public function testrole_detail()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/role-detail?role_id=1',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }



    /*
*   测试角色添加
*    所需参数
*   $params 'name','display_name','description'
*/
    public function testrole_add()
    {
        $response = $this->post('http://ideabuy.xin.cn/backend/role-add',['name'=>'test1','display_name'=>'testzy1','description'=>'test zyxiaofan1'],$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonFragment([
                'msg'=>'添加成功',
            ]);

    }


    /*
*   测试角色编辑
*    所需参数
*   $params 'role_id','name','display_name','description'
*/
//    public function testrole_edit()
//    {
//        $response = $this->post('http://ideabuy.xin.cn/backend/role-edit',['role_id'=>41,'name'=>112,'display_name'=>112,'description'=>112],$this->admin_token)
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'编辑成功',
//            ]);
//
//    }


    /*
*   测试角色删除
*    所需参数
*   $params 'role_id'
*/
//    public function testrole_delete()
//    {
//        $response = $this->post('http://ideabuy.xin.cn/backend/role-delete',['role_id'=>37],$this->admin_token)
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'删除成功',
//            ]);
//
//    }

    /*
    *   测试获取用户详情
    *    所需参数
    *   $params 'user_id'
    */
//    public function testuser_detail()
//    {
//        $response = $this->get('http://ideabuy.xin.cn/backend/user-detail?user_id=2',$this->admin_token);
//        $this->assertEquals('ture',$response->getcontent());
////            ->assertJsonStructure([
////                'data'=>[],
////            ]);
//
//    }

    /*
   *   测试后台用户审核操作
   *   所需参数
   *   $params 'user_id'，'status'，'reason'
   *
   */
    public function testuserapply_edit()
    {

        $response = $this->POST('http://ideabuy.xin.cn/backend/userapply-edit',['user_id'=>18,'status'=>2,'reason'=>'no'],$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonFragment([
                'msg'=>'审核成功',
            ]);

    }

    /*
*   测试管理员-删除
*    所需参数
*   $params 'admin_id'
*/
//    public function testadmin_delete()
//    {
//        $response = $this->post('http://ideabuy.xin.cn/backend/admin-delete',['admin_id'=>111],$this->admin_token)
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'删除成功',
//            ]);
//
//    }

    /*
*   测试后台管理员登录
*   所需参数
*   $params 'admin_name','admin_password'
*
*/

    public function testadmin_login()
    {
        $response = $this->POST('http://ideabuy.xin.cn/backend/admin-login',['admin_name'=>'admin','admin_password'=>'111111'])
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonFragment([
                'msg'=>'登录成功',
            ]);

    }

    /*
*   测试用户审核详情
*    所需参数
*   $params 'user_id'
*/
    public function testuserapply_detail()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/userapply-detail?user_id=18',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }

    /*
*   测试用户审核列表
*    所需参数
*   $params 'user_id'
*/
    public function testuserapply_list()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/userapply-list',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }

    /*
*   测试订单详情
*    所需参数
*   $params 'order_id'
*/
    public function testorder_detail()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/order-detail?order_id=1',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }

    /*
*   测试权限详细
*    所需参数
*   $params 'permission_id'
*/
    public function testpermission_detail()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/permission-detail?permission_id=1',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }


    /*
*   测试角色-权限 添加/编辑
*    所需参数
*   $params 'role_id','permission_id'
*/
//    public function testpermission_role_add()
//    {
//        $response = $this->post('http://ideabuy.xin.cn/backend/permission-role-add',['role_id'=>1,'permission_id'=>2],$this->admin_token)
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'编辑成功',
//            ]);
//
//    }


    /*
*   测试角色列表
*    所需参数
*   $params 'page'
*/
    public function testrole_list()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/role-list?page=1',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }


    /*
*   测试后台操作日志列表
*    所需参数
*   $params 'limit','page','pay_id','order_sn','trade_no'
*/
    public function testlog_list()
    {
        $response = $this->get('http://ideabuy.xin.cn/backend/log-list?page=1&limit=5',$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonStructure([
                'data'=>[],
            ]);

    }

}
