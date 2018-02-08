<?php
/**
 * Created by PhpStorm.
 * User: pc16
 * Date: 2017/8/1
 * Time: 13:39
 */
namespace Modules\System\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    #表名
    protected $table = 'system_region';
    #主键
    protected $primaryKey='region_id';

    /**
     *
     * @param $params
     * @return \Illuminate\Support\Collection
     */
    public static function regionGet($params)
    {
        return Region::whereIn('region_code',$params)->pluck('region_name');
    }
    public static function region()
    {
        $region= Region::select('region_code as value','region_name as name','parent_id as parent')->whereIn('region_level',[1,2,3])->orderBy('region_level')->orderBy('region_id')->get();
        foreach ($region as $key=>$vo){
            if($vo['parent'] == 0){
                unset($vo['parent']);
            }
        }
        return $region;
    }

    public static function regionByLevel($params)
    {
        $results = Region::select(['region_code', 'region_name', 'region_level', 'parent_id'])
            ->whereIn('region_level', $params)
            ->get();
        return $results;
    }
}