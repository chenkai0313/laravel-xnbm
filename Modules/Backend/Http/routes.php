<?php
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    #无需身份验证
    $api->group(['namespace' => 'Modules\Backend\Http\Controllers', 'prefix' => 'backend', 'middleware' => ['sysTime_start', 'session_start']], function ($api) {
        // 验证码调试接口
        $api->get('check', 'AdminController@check_code');
        // 验证码正式接口
        $api->get('code/{tmp}', 'AdminController@qrcode');
        $api->get('test', 'AdminController@test');
        #注册
        $api->get('time-stage', 'AdminController@timeStageNow');//当前时间处于的时间段
        $api->post('school-add', 'AdminController@adminAdd');//学生老师注册
        $api->post('school-add-stu', 'AdminController@adminAdd');//学生自己注册
        $api->get('apply-excel-export', 'ApplyController@applyExcelExport');//学生报名信息的导出
        $api->post('school-updated-pwd', 'AdminController@adminUpdatedPwd');//取回密码
        $api->get('config-detail', 'ConfigController@configDetail');
    });
    #需要身份验证
    $api->group(['namespace' => 'Modules\Backend\Http\Controllers', 'prefix' => 'backend', 'middleware' => ['sysTime_start', 'jwt-admin', 'log-admin', 'session_start']], function ($api) {

        #账户管理
        $api->post('school-add-tch', 'AdminController@adminAddTch');//老师注册
        $api->post('school-login', 'AdminController@adminLogin');
        $api->get('school-list-stu', 'AdminController@adminListStu'); //学生信息列表
        $api->get('school-list-tch', 'AdminController@adminListTch'); //老师信息列表
        $api->get('school-detail', 'AdminController@adminDetail');
        $api->post('school-edit', 'AdminController@adminEdit');
        $api->post('school-delete', 'AdminController@adminDelete');
        $api->post('school-change-pwd', 'AdminController@adminChangePassword');
        $api->post('school-del-all', 'AdminController@adminDelAll');
        $api->post('tch-edit-pwd', 'AdminController@tchEditPwd');//老师修改学生的密码
        #RBAC-角色
        $api->get('role-list', 'RbacController@roleList');
        $api->get('role-list-all', 'RbacController@roleListAll');
        $api->get('role-detail', 'RbacController@roleDetail');
        $api->post('role-delete', 'RbacController@roleDelete');
        $api->post('role-add', 'RbacController@roleAdd');
        $api->post('role-edit', 'RbacController@roleEdit');
        #RBAC-权限
        $api->get('permission-type', 'RbacController@permissionType');
        $api->get('permission-list', 'RbacController@permissionList');
        $api->get('permission-detail', 'RbacController@permissionDetail');
        $api->post('permission-delete', 'RbacController@permissionDelete');
        $api->post('permission-add', 'RbacController@permissionAdd');
        $api->post('permission-edit', 'RbacController@permissionEdit');
        #RBAC-用户角色权限
        $api->get('role-account-list', 'RbacController@roleAdminList');
        $api->get('role-account-detail', 'RbacController@roleAdminDetail');
        $api->post('role-account-add', 'RbacController@roleAdminAdd');
        $api->get('permission-role-list', 'RbacController@permissionRoleList');
        $api->get('permission-role-detail', 'RbacController@permissionRoleDetail');
        $api->post('permission-role-add', 'RbacController@permissionRoleAdd');
        $api->get('permission-left', 'RbacController@permissionLeft');
        #操作日志管理
        $api->get('log-list', 'LogController@logList');
        $api->get('log-detail', 'LogController@logDetail');
        #用户列表
        $api->get('user-list', 'AdminController@userList');
        #文件上传
        $api->post('file-upload-all', 'FileUploadController@fileUpLoadAll');    //多文件上传
        #设置系统时间
        $api->post('systime-add', 'SysTimeController@sysTimeAdd');
        $api->get('systime-new-one', 'SysTimeController@sysTimeNewOne');
        #导航栏
        $api->post('navbar-add', 'NavBarController@navBarAdd');
        $api->post('navbar-edit', 'NavBarController@navBarEdit');
        $api->post('navbar-delete', 'NavBarController@navBarDelete');
        $api->get('navbar-detail', 'NavBarController@navBarDetail');
        $api->get('navbar-list', 'NavBarController@navBarList');
        #学生报名信息
        $api->post('apply-edit', 'ApplyController@applyEdit');
        $api->post('apply-delete', 'ApplyController@applyDelete');
        $api->get('apply-detail', 'ApplyController@applyDetail');
        $api->get('apply-stu-detail', 'ApplyController@applyStuDetail');
        $api->get('apply-list', 'ApplyController@applyList');
        $api->post('apply-add', 'ApplyController@applyAdd');
        $api->get('apply-stu-res', 'ApplyController@applyStuRes');//报名结果路由
        $api->get('apply-stu-face-res', 'ApplyController@applyStuFaceRes');//面试结果路由
        $api->post('apply-del-all', 'ApplyController@applyDelAll');//清除所有报名信息
        $api->post('apply-print', 'ApplyController@applyPrint');//是否打印

        #信息的导入导出
        $api->get('apply-excel-import', 'ApplyController@applyExcelImport');//报名结果导入
        $api->get('apply-excel-face-import', 'ApplyController@applyExcelFaceImport');//面试结果导入
        $api->post('file-upload', 'FileUploadController@fileUpLoad');    //单文件上传
        #学生报名信息的备份
        $api->post('backups-add', 'BackupsController@backupsAdd');//备份的添加
        $api->get('backups-time-list', 'BackupsController@backupsTimeList');//备份记录列表
        $api->get('backups-list', 'BackupsController@backupsList');    //当前备份记录详细的列表
        $api->get('backups-detail', 'BackupsController@backupsDetail');    //备份的详情
        $api->post('backups-delete', 'BackupsController@backupsDelete');    //备份的删除

        #站点配置
        $api->post('config-add', 'ConfigController@configAdd');
        $api->post('config-edit', 'ConfigController@configEdit');


    });


});

