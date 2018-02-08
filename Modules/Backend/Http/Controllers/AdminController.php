<?php
/**
 * 管理员模块
 * Author: 葛宏华
 * Date: 2017/7/25
 */

namespace Modules\Backend\Http\Controllers;

use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Crypt;
use Session;
use Cache;

class AdminController extends Controller
{

    /**
     * 列表-学生
     */
    public function adminListStu(Request $request)
    {
        $params = $request->all();
        $params['is_super'] = get_is_super();
        $result = \AdminService::adminListStu($params);
        return $result;
    }

    /**
     * 列表-老师
     */
    public function adminListTch(Request $request)
    {
        $params = $request->all();
        $params['is_super'] = get_is_super();
        $result = \AdminService::adminListTch($params);
        return $result;
    }

    /**
     * 学生的添加
     */
    public function adminAdd(Request $request)
    {
        $params = $request->all();
        $params['captcha'] = $request->session()->pull('captcha' . $params['time'], null);
        $result = \AdminService::adminAdd($params);
        return $result;
    }

    /**
     * 老师的添加
     */
    public function adminAddTch(Request $request)
    {
        $params = $request->all();
        $params['is_super'] = 1;
        $result = \AdminService::adminAdd($params);
        return $result;
    }

    /**
     * 管理员编辑
     */
    public function adminEdit(Request $request)
    {
        $params = $request->all();
        $result = \AdminService::adminEdit($params);
        return $result;
    }

    /**
     * 清除所有注册学生信息
     */
    public function adminDelAll(Request $request)
    {
        $params = $request->all();
        $params['is_super'] = get_is_super();
        $result = \AdminService::adminDelAll($params);
        return $result;
    }

    /**
     * 修改密码
     */
    public function adminUpdatedPwd(Request $request)
    {
        $params = $request->all();
        $result = \AdminService::adminUpdatedPwd($params);
        return $result;
    }

    /**
     * 管理员删除
     */
    public function adminDelete(Request $request)
    {
        $params = $request->all();
        $result = \AdminService::adminDelete($params);
        return $result;
    }

    /**                                                                                                 Í
     * 管理员详细
     */
    public function adminDetail(Request $request)
    {
        $params = $request->all();
        $result = \AdminService::adminDetail($params);
        return $result;
    }

    /**
     * 管理员登录
     */
    public function adminLogin(Request $request)
    {
        $params = $request->all();
//        \Log::info('adminLogin');
//        \Log::info($request->session()->all());
        #取出session,并删除
        $params['captcha'] = $request->session()->pull('captcha' . $params['time'], null);
        $result = \AdminService::adminLogin($params);
        return $result;
    }

    /**
     * 用户修改password
     */
    public function adminChangePassword(Request $request)
    {
        $params = $request->input();
        $params['admin_id'] = get_admin_id();
        $result = \AdminService::adminChangePassword($params);
        return $result;
    }

    /**
     * 验证码生成
     * @params  [type] $tmp [description]
     */
    public function qrcode($tmp)
    {
        //生成验证码图片的Builder对象，配置相应属性
        $data=getRandom(4);
        $builder = new CaptchaBuilder($data);
        //可以设置图片宽高及字体
        $builder->build($width = 150, $height = 50, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();
        //把内容存入session
        $key = $tmp;
        $key = 'captcha' . $key;
        session([$key => $phrase]);
        ob_clean();
        return response($builder->output())->header('Content-type', 'image/jpeg'); //把验证码数据以jpeg图片的格式输出
    }

    /**
     * 老师修改学生的密码
     */
    public function tchEditPwd(Request $request)
    {
        $params = $request->all();
        $params['is_super'] = get_is_super();
        $result = \AdminService::tchEditPwd($params);
        return $result;
    }

    /**
     * 当前时间处于的时间段
     */
    public function timeStageNow(Request $request)
    {
        $params = $request->all();
        $result = \AdminService::timeStageNow($params);
        return $result;
    }
}
