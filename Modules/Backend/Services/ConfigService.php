<?php

/**
 * 站点配置
 * Author: CK
 * Date: 2018/1/17
 */

namespace Modules\Backend\Services;

use Modules\Backend\Models\Config;

class ConfigService
{
    /**
     * 站点配置的添加
     * @return array
     */
    public function configAdd($params)
    {
        if (!isset($params['content'])) {
            return ['code' => 90002, 'msg' => '内容不能位空'];
        }
        $data['content'] = serialize($params['content']);
        $data['type'] = $params['type'];
        $res = Config::configAdd($data);
        if ($res) {
            return ['code' => 1, 'msg' => '添加成功'];
        }
        return ['code' => 90002, 'msg' => '添加失败'];
    }

    /**
     * 站点配置的添加
     * @return array
     */
    public function configEdit($params)
    {
        if (!isset($params['content'])) {
            return ['code' => 90002, 'msg' => '内容不能位空'];
        }
        $data['type'] = isset($params['type']) ? $params['type'] : 1;
        $data['content'] = serialize($params['content']);
        $res = Config::configEdit($data);
        if ($res) {
            return ['code' => 1, 'msg' => '修改成功'];
        }
        return ['code' => 90002, 'msg' => '修改失败'];
    }

    /**
     * 站点配置的详情
     * @return array
     */
    public function configDetail($params)
    {
        $params['type'] = isset($params['type']) ? $params['type'] : 1;
        $res = Config::configDetail($params);
        if ($res) {
            return ['code' => 1, 'data' => unserialize($res['content'])];
        }
        return ['code' => 1, 'msg' => '查询失败'];
    }
}
