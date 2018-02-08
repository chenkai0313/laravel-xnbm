<?php

/**
 * 站点配置
 * Author: CK
 * Date: 2018/1/17
 */

namespace Modules\Backend\Models;


use Illuminate\Database\Eloquent\Model;

class Config extends Model
{

    protected $table = 'config';

    protected $primaryKey = 'config_id';

    protected $fillable = array('content', 'type');


    /**
     * 站点配置的添加
     * @return array
     */
    public static function configAdd($params)
    {
        $arr = ['content', 'type'];
        $data = array();
        foreach ($arr as $v)
            if (array_key_exists($v, $params))
                $data[$v] = $params[$v];
        return Config::create($data);
    }

    /**
     * 站点配置的更新
     * @return array
     */
    public static function configEdit($params)
    {
        $arr = ['content', 'type'];
        $data = array();
        foreach ($arr as $v)
            if (array_key_exists($v, $params))
                $data[$v] = $params[$v];
        return Config::where('type', $params['type'])->update($data);
    }

    /**
     * 站点配置的详情
     * @return array
     */
    public static function configDetail($params)
    {
        return Config::where('type', $params['type'])->first();
    }

}