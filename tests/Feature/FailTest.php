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

class FailTest extends TestCase
{
    public $data = ['Authorization'=>'Bearer ' . 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJmcm9tIjoidXNlciIsInVzZXJfaWQiOjE4LCJ1c2VyX21vYmlsZSI6IjE3NjgyNDUxMzk2Iiwic3ViIjoxOCwiaXNzIjoiaHR0cDovL2lkZWFidXkueGluLmNuL2FwaS91c2VyLWxvZ2luIiwiaWF0IjoxNTAyODY5NDQ4LCJleHAiOjE1MDQwNzkwNDgsIm5iZiI6MTUwMjg2OTQ0OCwianRpIjoiMElGYnMzVGtwejMyTlNubCJ9.Rkly1f0XUsXS5uZ3ng2SVmKDCWhdiksy7DzIZlHCQ04'];
    public $admin_token = ['Authorization'=>'Bearer ' . 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJmcm9tIjoiYWRtaW4iLCJhZG1pbl9pZCI6MSwiYWRtaW5fbmljayI6Ilx1NjYzNVx1NzlmMCIsInN1YiI6MSwiaXNzIjoiaHR0cDovL2lkZWFidXkueGluLmNuL2JhY2tlbmQvYWRtaW4tbG9naW4iLCJpYXQiOjE1MDI4NDYxNjAsImV4cCI6MTUwNDA1NTc2MCwibmJmIjoxNTAyODQ2MTYwLCJqdGkiOiJDWkJsZm5IQ085VkVobFBXIn0.W8FD4o-B8qdqKXaNPjQ_yWSKWHO4MRODXk-S8VzJZvE'];

    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    /*
*   测试用户管理添加
*   所需参数
*   $params 'admin_id','admin_password','admin_nick','admin_sex','admin_birthday','role_id'
*
*/
//    public function testuser_add()
//    {
//        $response = $this->post('http://ideabuy.xin.cn/backend/user-add',['user_mobile'=>18069731396,'user_password'=>'z12121211','user_idcard'=>330225199511222288,'real_name'=>'张小烦'],$this->admin_token)
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'新增成功',
//            ]);
//
//    }


    /*
*   测试管理员添加
*   所需参数
*   $params 'admin_name','admin_password','admin_nick','admin_sex','admin_birthday','role_id'
*
*/
//    public function testadmin_add()
//    {
//        $response = $this->post('http://ideabuy.xin.cn/backend/admin-add',['admin_name'=>'sfdfsssd111','admin_password'=>123123123,'admin_nick'=>'小sddsdsd烦','admin_sex'=>1,'admin_birthday'=>'1995-11-25','role_id'=>1],$this->admin_token)
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'添加成功',
//            ]);
//
//    }




    /*
*   测试内容管理-文章-删除文章 可以批量删除
*   所需参数
*   $params 'article_id','page'
*
*/
//    public function testarticle_delete()
//    {
//        $response = $this->post('http://ideabuy.xin.cn/backend/article-delete',['article_id'=>'121,122'],$this->admin_token)
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'删除成功',
//            ]);
//
//    }




    /*
*   测试广告的删除
*   所需参数
*   $params 'limit','page'
*
*/
//    public function testad_delete()
//    {
//        $response = $this->post('http://ideabuy.xin.cn/backend/ad-delete',['ad_id'=>1],$this->admin_token)
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'删除成功',
//            ]);
//
//    }
    /*
*   测试广告的新增
*   所需参数
*   $params 'limit','page'
*
*/
//    public function testad_add()
//    {
//        $response = $this->post('http://ideabuy.xin.cn/backend/ad-add',['type_id'=>1,'ad_img'=>'dasjhdasjhd','is_show'=>3],$this->admin_token)
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'新增成功',
//            ]);
//
//    }
//    public function testad_add()
//    {
//        $response = $this->post('http://ideabuy.xin.cn/backend/ad-add',['type_id'=>1,'ad_img'=>'dasjhdasjhd','is_show'=>3],$this->admin_token)
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'新增成功',
//            ]);
//
//    }

    /*
*   测试内容管理-文章-修改文章
*   所需参数
*   $params 'article_id'
*
*/
    public function testarticle_edit()
    {
        $response = $this->post('http://ideabuy.xin.cn/backend/article-edit',['article_id'=>35,'article_content'=>'come on'],$this->admin_token)
//        $this->assertEquals('ture',$response->getcontent());
            ->assertJsonFragment([
                'msg'=>'更新成功',
            ]);

    }


    /*
*   测试内容管理-类型-更新类型
*   所需参数
*   $params 'type_id','type_name','parent_id'
*
*/
//    public function testarticletype_edit()
//    {
//        $response = $this->post('http://ideabuy.xin.cn/backend/articletype-edit',['type_id'=>10,'type_name'=>'aaa','parent_id'=>6],$this->admin_token)
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'更新成功',
//            ]);
//
//    }
//    /*

//    /*
//       *   测试支付宝网页支付
//       *   所需参数
//       *   $params 'order_sn','return_url'
//       *   订单号必须在数据库里为token本人下的单，并且状态为未付款状态。
//      */
//
//    public function testaliPayWeb()
//    {
//        $response = $this->POST('http://ideabuy.xin.cn/api/aliPayWeb',['order_sn'=>'PT20130833040411111','return_url'=>'http://ideabuy.xin.cn/api/user-creditcode'],$this->data);
//        $this->assertEquals('ture',$response->getcontent());
////            ->assertJsonFragment([
////                'msg'=>'完善信息成功',
////            ]);
//
//    }

//*  测试找回密码功能
//*  所需参数
//*  $params 'user_mobile','user_password'
//*/
//
//    public function testuser_forgot()
//    {
//        // $this->withoutMiddleware('jwtUser');
//        $response = $this->call('POST', 'http://ideabuy.xin.cn/api/user-forgot',['user_mobile'=>'17682451396','user_password'=>'z123123123','confirm_password'=>'z123123123','code'=>'1212'])
//            ->assertJsonFragment([
//                'msg'=>'修改登录密码成功',
//            ]);
//
//
//
//    }

//    /*
//*   测试注册用户
//*   所需参数
//*   $params 'user_mobile','user_password','confirm_password','code'
//*  ---测试code需先获取-----
//*/
//
//    public function testregister()
//    {
//        $response = $this->POST('http://ideabuy.xin.cn/api/user-register',['user_mobile'=>'17711112222','user_password'=>'z123123123','confirm_password'=>'z123123123','code'=>'2751'])
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'注册成功',
//            ]);
//
//    }
//    /**
//     *
//     *   测试添加地址
//     *   所需参数
//     *   $params 'province','city','district','street','address'
//     *
//     */
//    public function testaddress_add()
//    {
//        $response = $this->post('http://ideabuy.xin.cn/api/user-addressadd',['province'=>11,'city'=>1101,'district'=>110101,'street'=>110101,'address'=>110101007], $this->data)
//            // $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'添加成功',
//            ]);
//
//    }
//
//    /**
//     *
//     *   测试缓存获取接口
//     *   所需参数
//     *   $params 'key','val'
//     *
//     */
//    public function testcache_obtain()
//    {
//        $response = $this->get('http://ideabuy.xin.cn/api/cache-obtain?key=15');
//        $this->assertEquals('ture',$response->getcontent());
////            ->assertJsonFragment([
////                'msg'=>'缓存更新成功!',
////            ]);
//
//    }
//
//    /**
//     *
//     *   测试短信发送(1:注册,2:找回密码，5：绑定新手机号)
//     *   所需参数
//     *   $params 'moblie','type'
//     *
//     */
//    public function testsms_send()
//    {
//        $response = $this->POST('http://ideabuy.xin.cn/api/sms-send',['mobile'=>'17682451396','type'=>'5'])
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'短信发送成功',
//            ]);
//
//    }
//
//
//    /*
//*   测试用户换绑手机号
//*   所需参数
//*   $params 'pay_password'，'confirm_pay_pwd'，'code'
//*
//*/
//    public function testuser_changemobile()
//    {
//
//        $response = $this->POST('http://ideabuy.xin.cn/api/user-changemobile',['user_mobile'=>17722221111,'code'=>4257],$this->data)
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'更换手机号成功',
//            ]);
//
//    }
//
//    /*
//*   测试用户修改交易密码
//*   所需参数
//*   $params 'pay_password'，'confirm_pay_pwd'，'code'
//*
//*/
//    public function testuser_editpaypwd()
//    {
//
//        $response = $this->POST('http://ideabuy.xin.cn/api/user-editpaypwd',['pay_password'=>121212,'confirm_pay_pwd'=>121212,'code' => '4169'],$this->data)
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'修改交易密码成功',
//            ]);
//
//    }
//
//    /*
//*   测试用户添加银行卡
//*   所需参数
//*   $params 'pay_password'，'confirm_pay_pwd'，'code'
//*
//*/
//    public function testuser_cardadd()
//    {
//
//        $response = $this->POST('http://ideabuy.xin.cn/api/user-cardadd',['card_number'=>62,'card_mobile'=>17722221111,'code'=>'0812'],$this->data)
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'银行卡添加成功',
//            ]);
//
//    }
//
//    /**
//     *   测试修改用户登录密码
//     *   所需参数
//     *   $params 'user_password','confirm_password','code'
//     *
//     */
//
//    public function testuserchangepwd()
//    {
//        $response = $this->POST('http://ideabuy.xin.cn/api/user-changepassword',['user_password'=>'z123123123','confirm_password'=>'z123123123','code'=>'7923'],$this->data)
////        $this->assertEquals('ture',$response->getcontent());
//            ->assertJsonFragment([
//                'msg'=>'修改登录密码成功',
//            ]);
//
//    }

}
