<?php
/**
 * 公共函数类
 */

/**
 * 生成订单唯一编号
 * @return  string
 */
function get_sn($prefix = '')
{
    /* 选择一个随机的方案 */
    mt_srand((double)microtime() * 1000000);
    return $prefix . date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}


/**
 * 获取jwt信息
 * $params array|string 参数名
 * @return  string
 */
function get_jwt($params = null)
{
    $payload = \JWTAuth::parseToken()->getPayload();
    return $payload->get($params);
}

/**
 * 获取jwt信息中的user_id
 * @return  string
 */
function get_r_level()
{
    $payload = \JWTAuth::parseToken()->getPayload();
    return $payload->get('r_level');
}

/**
 * 获取月初，下月初
 * @return mixed
 */
function get_month($time = null)
{
    if (is_null($time)) {
        $time = time();
    }
    $year = date('Y', $time);
    $month = date('m', $time);
    $return['this_month'] = date("Y-m-d H:i:s", mktime(0, 0, 0, $month - 1, 1, $year));
    $return['next_month'] = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, 1, $year));
    return $return;
}

/**
 * 获取传过来的时间的月初，下月初
 * @return mixed
 */
function get_month_time()
{
    $time = time();
    $year = date('Y', $time);
    $month = date('m', $time);
    $return['this_month'] = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, 1, $year));
    $return['next_month'] = date("Y-m-d H:i:s", mktime(0, 0, 0, $month + 1, 1, $year));
    return $return;
}

/**
 * 获取jwt信息中的admin_id
 * @return  string
 */
function get_admin_id()
{
    $payload = \JWTAuth::parseToken()->getPayload();
    return $payload->get('admin_id');
}


/**
 * 获取jwt信息中的is_super
 * @return  string
 */
function get_is_super()
{
    $payload = \JWTAuth::parseToken()->getPayload();
    return $payload->get('is_super');
}


/**
 * get请求
 * @return  array
 */
function vget($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    $response = curl_exec($ch);
    curl_close($ch);
    //-------请求为空
    if (empty($response)) {
        return null;
    }
    return $response;
}

/**
 * post请求
 * @return  array
 */
function vpost($url, $data)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    $res = curl_exec($curl);
    curl_close($curl);
    return $res;
}

/**
 * 随机生成一个字符串
 * @param $length 长度
 * @return string
 */
function getRandomkeys($length = 8)
{
    $key = "";
    $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXY';    //字符池
    for ($i = 0; $i < $length; $i++) {
        $key .= $pattern{mt_rand(0, 60)};    //生成php随机数
    }
    return $key;
}

function getRandom($length = 4)
{
    $key = "";
    $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';    //字符池
    for ($i = 0; $i < $length; $i++) {
        $key .= $pattern{mt_rand(0, 35)};    //生成php随机数
    }
    return $key;
}


/**
 * 获取常量的缓存
 * @param $key
 * @param $type
 * $key包含['statement_date','repayment_date']
 * $type包含['credit']
 * @return mixed
 */
function get_constant_cache($key, $type)
{
    return BackendConstantService::getConstantCache($key, $type);
}

/**
 * 批量插入SQL拼接
 * @param $field
 * @param $params
 * @return array
 */
function sql_batch_str($field, $params)
{
    $data = [];
    foreach ($params as $key => $value) {
        $data_info = [];
        foreach ($value as $k1 => $v1) {
            foreach ($field as $k2 => $v2) {
                if ($k1 == $k2) {
                    $data_info[$v2] = $v1;
                    continue;
                }
            }
        }
        $data[] = $data_info;
    }
    return $data;
}

/**
 * 默认记录日志公共方法
 * @params $file_name string 文件名
 * @params $message string 消息内容
 * @params $data array 访问参数
 * @params $returns array 返回结果
 * @params $level string 日志等级
 */
function common_log($file_name, $message, $data, $returns, $level = 'info')
{
    // 拼接文件名
    $file_name = $file_name . '-' . date('Y-m-d') . '-' . $level;
    // 访问生成日志文件
    \Log::useFiles(storage_path() . '/logs/' . $file_name . '.log', $level);
    // 传参数据写入
    if (!empty($data)) {
        \Log::log($level, '传入参数', $data);
    }
    // 返回日志写入
    \Log::log($level, $message, $returns);
    return true;
}

/**
 * 判断是否是时间格式
 * @params $dateTime string 时间字符
 */
function isDateTime($dateTime)
{
    $ret = strtotime($dateTime);
    return $ret !== FALSE && $ret != -1;
}

/**
 * 判断时间是星期几（周几）
 * @params $dateTime string 时间字符
 */
function isWeek($dateTime)
{
    $week = array(
        "0" => "星期日",
        "1" => "星期一",
        "2" => "星期二",
        "3" => "星期三",
        "4" => "星期四",
        "5" => "星期五",
        "6" => "星期六"
    );
    $date = date("w", strtotime($dateTime));
    return ['data' => $date, 'week' => $week[$date]];
}

#单文件
function uploadFiles($files)
{
    $params['file_name'] = "";
    $params['file_path'] = "";
    $params['host_url'] = config('system.files_domain');
    //上传文件
    if (!empty($files)) {
        //文件原名
        foreach ($files as $key => $value) {
            $originalName = $value->getClientOriginalName();
            #windows
//            $tempname = iconv('UTF-8', 'gb2312', $originalName);
            $time = time();
//            $temPath = 'files/' . $time. '/' . $originalName;
            $path = $value->storeAs('files/' . $time, $originalName);
            $params['file_name'] = $originalName;
            $params['file_path'] = $path;
        }
    }
    return $params;
}

#多文件
function uploadFilesAll($files)
{
    $params['file_name'] = "";
    $params['file_path'] = "";
    $params['host_url'] = config('system.files_domain');
    //上传文件
    if (!empty($files)) {
        //文件原名
        foreach ($files as $key => $value) {
            $originalName = $value->getClientOriginalName();
            $path = $value->storeAs('files/' . time(), $originalName);
            $params['file_name'] .= $originalName . "|";
            $params['file_path'] .= $path . "|";
        }
    }
    return $params;
}