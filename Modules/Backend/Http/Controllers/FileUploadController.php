<?php
/**
 * Created by PhpStorm.
 * User: CK
 * Date: 2017/11/16
 * Time: 14:43
 */

namespace Modules\Backend\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FileUploadController extends Controller
{
    /**
     * 单文件上传
     */
    public function fileUpLoad(Request $request)
    {
        $files = is_null($request->file('files')) ? '' : $request->file('files');
        $upload = uploadFiles($files);//上传文件
        $data['file_name'] = $upload['file_name'];
        $data['file_path'] = $upload['file_path'];
        $data['host_url'] = $upload['host_url'];
        return ['code' => 1, 'data' => $data];
    }

    /**
     * 多文件上传
     */
    public function fileUpLoadAll(Request $request)
    {
        $files = is_null($request->file('files')) ? '' : $request->file('files');
        $upload = uploadFilesAll($files);//上传文件
        $data['file_name'] = $upload['file_name'];
        $data['file_path'] = $upload['file_path'];
        $data['host_url'] = $upload['host_url'];
        return ['code' => 1, 'data' => $data];
    }
}