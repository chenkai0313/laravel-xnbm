<?php
/**
 * Created by PhpStorm.
 * User: pc16
 * Date: 2017/8/1
 * Time: 14:42
 */
namespace Modules\System\Services;

use Modules\System\Models\Region;

class RegionService
{
    public function regionGet($params)
    {
        $region=Region::regionGet($params);
        $data['province']=$region[0];
        $data['city']=$region[1];
        $data['area']=$region[2];
        return ['code'=>1,'data'=>$data];
    }

    public function regionByLevel($params)
    {
        $level = range(1, $params['level']);
        $region = Region::regionByLevel($level)->toArray();
        return ['code' => 1, 'data' => $region];
    }
}