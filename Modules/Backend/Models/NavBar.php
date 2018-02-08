<?php

/**
 * 导航栏
 * Author: CK
 * Date: 2017/12/27
 */

namespace Modules\Backend\Models;


use Illuminate\Database\Eloquent\Model;

class NavBar extends Model
{

    protected $table = 'navbar';

    protected $primaryKey = 'navi_id';

    protected $fillable = array('navi_name', 'navi_front_route', 'navi_back_route', 'time_stage', 'navi_display', 'sort', 'pid','is_super');


    /**
     * 导航栏的添加
     * @return array
     */
    public static function navbarAdd($params)
    {
        $arr = ['navi_name', 'navi_front_route', 'navi_back_route', 'time_stage', 'navi_display', 'sort', 'pid','is_super'];
        $data = array();
        foreach ($arr as $v)
            if (array_key_exists($v, $params))
                $data[$v] = $params[$v];
        return NavBar::create($data);
    }

    /**
     * 导航栏的修改
     * @return array
     */
    public static function navbarEdit($params)
    {
        $arr = ['navi_name', 'navi_front_route', 'navi_back_route', 'time_stage', 'navi_display', 'sort', 'pid','is_super'];
        $data = array();
        foreach ($arr as $v)
            if (array_key_exists($v, $params))
                $data[$v] = $params[$v];
        return NavBar::where('navi_id', $params['navi_id'])->update($data);
    }

    /**
     * 导航栏的删除
     * @return array
     */
    public static function navbarDelete($params)
    {
        $navi_id=explode(',',$params['navi_id']);
        return NavBar::whereIn('navi_id',$navi_id)->delete();
    }

    /**
     * 导航栏的详情
     * @return array
     */
    public static function navbarDetail($params)
    {
        return NavBar::where('navi_id', $params['navi_id'])->first();
    }

    /**
     * 导航栏的列表
     * @return array
     */
    public static function navbarList($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $data = NavBar::select('*')
            ->orderBy('sort', 'desc')
            ->where(function ($query) use ($params) {
                if (!empty($params['keyword'])) {
                    return $query->where('navi_name', 'like', '%' . $params['keyword'] . '%');
                }
                return true;
            })
            ->skip($offset)
            ->take($params['limit'])
            ->get()
            ->toArray();
        return $data;
    }

}