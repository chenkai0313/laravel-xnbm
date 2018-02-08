<?php

/**
 * 学生注册信息 报名信息的备份
 * Author: CK
 * Date: 2018/1/11
 */

namespace Modules\Backend\Models;


use Illuminate\Database\Eloquent\Model;

class Backups extends Model
{

    protected $table = 'backups';

    protected $primaryKey = 'id';

    protected $fillable = array('content', 'backup_time');

    /**
     * 备份的添加
     * @return array
     */
    public static function backupsAdd($params)
    {
        return Backups::create($params);
    }

    /**
     * 备份的详情
     * @return array
     */
    public static function backupsDeatil($params)
    {
        return Backups::where('id', $params['id'])->get();
    }

    /**
     * 备份的删除
     * @return array
     */
    public static function backupsDelete($id)
    {
        return Backups::whereIn('id', $id)->delete();
    }

    /**
     * 备份的列表
     * @return array
     */
    public static function backupsList($params)
    {
        return Backups::get()->toArray();
    }

    /**
     * 对应备份时间的列表
     * @return array
     */
    public static function backupsListBackup($params)
    {
        return Backups::where('backup_time', $params['backup_time'])->get()->toArray();
    }

}