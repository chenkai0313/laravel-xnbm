<?php

/**
 * 设置系统时间
 * Author: CK
 * Date: 2017/12/27
 */

namespace Modules\Backend\Models;


use Illuminate\Database\Eloquent\Model;

class SysTime extends Model
{

    protected $table = 'sys_time';

    protected $primaryKey = 'sys_id';

    protected $fillable = array('enroll_start', 'face_start', 'end_start');


    /**
     * 设置系统时间的添加
     * @return array
     */
    public static function sysTimeAdd($params)
    {
        $arr = ['enroll_start', 'face_start', 'end_start'];
        $data = array();
        foreach ($arr as $v)
            if (array_key_exists($v, $params))
                $data[$v] = $params[$v];
        return SysTime::create($data);
    }

    /**
     * 显示最新设置的时间（一条）
     * @return array
     */
    public static function sysTimeNewOne()
    {
      return   SysTime::select('*')->orderBy('created_at', 'asc')->get()->last();
    }


}