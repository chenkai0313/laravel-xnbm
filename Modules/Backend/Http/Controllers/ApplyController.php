<?php
/**
 * 报名信息
 * Author: CK
 * Date: 2017/1/3
 */

namespace Modules\Backend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Modules\Backend\Jobs\SendData;
use Modules\Backend\Models\Apply;
use PHPExcel;
use Illuminate\Support\Facades\DB;


class ApplyController extends Controller
{
    /**
     * 报名信息的添加
     * @return array
     */
    public function applyAdd(Request $request)
    {
        $params = $request->all();
        $result = \ApplyService::applyAdd($params);
        if (isset($result['code'])) {
            return $result;
        }
        try {
            $data = Apply::applyAdd($result);
            if ($data) {
                return ['code' => 1, 'msg' => '添加成功','data'=>$data];
            }
            //todo 队列暂时弃用
//            $job = new SendData($result);
//            #过滤可能因为参数出现的数据库错误
////            $job->failed();
//            $this->dispatch($job);

        } catch (\Exception $e) {
            return ['code' => 90002, 'msg' => '添加失败'];
        }
    }

    /**
     * 是否打印过
     * @return array
     */
    public function applyPrint(Request $request)
    {
        $params = $request->all();
        $result = \ApplyService::applyPrint($params);
        return $result;
    }

    /**
     * 报名信息的修改
     * @return array
     */
    public function applyEdit(Request $request)
    {
        $params = $request->all();
        $result = \ApplyService::applyEdit($params);
        return $result;
    }

    /**
     * 报名信息的删除
     * @return array
     */
    public function applyDelete(Request $request)
    {
        $params = $request->all();
        $result = \ApplyService::applyDelete($params);
        return $result;
    }

    /**
     * 报名信息的详情
     * @return array
     */
    public function applyDetail(Request $request)
    {
        $params = $request->all();
        $result = \ApplyService::applyDetail($params);
        return $result;
    }

    /**
     * 学生登陆获取到的详情详情
     * @return array
     */
    public function applyStuDetail(Request $request)
    {
        $params = $request->all();
        $result = \ApplyService::applyStuDetail($params);
        return $result;
    }

    /**
     * 报名信息的列表
     * @return array
     */
    public function applyList(Request $request)
    {
        $params = $request->all();
        $result = \ApplyService::applyList($params);
        return $result;
    }

    /**
     * 报名结果路由
     * @return array
     */
    public function applyStuRes(Request $request)
    {
        $params = $request->all();
        $params['admin_id'] = get_admin_id();
        $result = \ApplyService::applyStuRes($params);
        return $result;
    }

    /**
     * 清除所有报名信息
     * @return array
     */
    public function applyDelAll(Request $request)
    {
        $params = $request->all();
        $params['is_super'] = get_is_super();
        $result = \ApplyService::applyDelAll($params);
        return $result;
    }


    /**
     * 面试结果路由
     * @return array
     */
    public function applyStuFaceRes(Request $request)
    {
        $params = $request->all();
        $params['admin_id'] = get_admin_id();
        $result = \ApplyService::applyStuFaceRes($params);
        return $result;
    }


    /**
     * 报名信息的导出
     * @return array
     */
    public function applyExcelExport()
    {
        $key_name = ['apply_id', 'admin_name', 'stu_name', 'stu_sn', 'register', 'area', 'sex', 'class', 'graduated_school',
            'father_name', 'father_work', 'father_tel', 'mother_name', 'mother_work', 'mother_tel', 'five_first_chinese', 'five_first_math',
            'five_first_english', 'five_first_science', 'five_first_sports', 'five_second_chinese', 'five_second_math', 'five_second_english',
            'five_second_science', 'five_second_sports', 'six_first_chinese', 'six_first_math', 'six_first_english', 'six_first_science',
            'six_first_sports', 'apply_condition1', 'apply_condition2', 'apply_condition3', 'honor', 'point', 'updated_at', 'apply_res', 'face_time',
            'print_res', 'admission_res'];
        $content = Apply::leftJoin('admins', 'admins.admin_id', '=', 'apply.admin_id')
            ->select('apply.*', 'admins.admin_name')
            ->get()->toArray();
        $data = [];
        foreach ($key_name as $item) {
            foreach ($content as $m => $v) {
                if (isset($v[$item])) {
                    $data[$m][$item] = $v[$item];
                } else {
                    $data[$m][$item] = null;
                }
            }
        }
        #处理序列化数据
        $family = [];
        foreach ($content as $v) {
            $family[$v['apply_id']] = unserialize($v['family_info']);
        }

        $grade = [];
        foreach ($content as $v) {
            $grade[$v['apply_id']] = unserialize($v['grade_info']);
        }
        $apply_condition = [];
        foreach ($content as $v) {
            $apply_condition[$v['apply_id']] = explode(',', $v['apply_condition']);
        }
        #将处理的数据加入$data
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['father_name'] = $family[$data[$i]['apply_id']]['father_name'];
            $data[$i]['father_work'] = $family[$data[$i]['apply_id']]['father_work'];
            $data[$i]['father_tel'] = $family[$data[$i]['apply_id']]['father_tel'];
            $data[$i]['mother_name'] = $family[$data[$i]['apply_id']]['mother_name'];
            $data[$i]['mother_work'] = $family[$data[$i]['apply_id']]['mother_work'];
            $data[$i]['mother_tel'] = $family[$data[$i]['apply_id']]['mother_tel'];
            $data[$i]['five_first_chinese'] = $grade[$data[$i]['apply_id']]['five_first_chinese'];
            $data[$i]['five_first_math'] = $grade[$data[$i]['apply_id']]['five_first_math'];
            $data[$i]['five_first_english'] = $grade[$data[$i]['apply_id']]['five_first_english'];
            $data[$i]['five_first_science'] = $grade[$data[$i]['apply_id']]['five_first_science'];
            $data[$i]['five_first_sports'] = $grade[$data[$i]['apply_id']]['five_first_sports'];
            $data[$i]['five_second_chinese'] = $grade[$data[$i]['apply_id']]['five_second_chinese'];
            $data[$i]['five_second_math'] = $grade[$data[$i]['apply_id']]['five_second_math'];
            $data[$i]['five_second_english'] = $grade[$data[$i]['apply_id']]['five_second_english'];
            $data[$i]['five_second_science'] = $grade[$data[$i]['apply_id']]['five_second_science'];
            $data[$i]['five_second_sports'] = $grade[$data[$i]['apply_id']]['five_second_sports'];
            $data[$i]['six_first_chinese'] = $grade[$data[$i]['apply_id']]['six_first_chinese'];
            $data[$i]['six_first_math'] = $grade[$data[$i]['apply_id']]['six_first_math'];
            $data[$i]['six_first_english'] = $grade[$data[$i]['apply_id']]['six_first_english'];
            $data[$i]['six_first_science'] = $grade[$data[$i]['apply_id']]['six_first_science'];
            $data[$i]['six_first_sports'] = $grade[$data[$i]['apply_id']]['six_first_sports'];
            $data[$i]['apply_condition1'] = $apply_condition[$data[$i]['apply_id']][0];
            $data[$i]['apply_condition2'] = $apply_condition[$data[$i]['apply_id']][1];
            $data[$i]['apply_condition3'] = $apply_condition[$data[$i]['apply_id']][2];
            switch ($data[$i]['area']) {
                case 1:
                    $data[$i]['area'] = '海曙区';
                    break;
                case 2:
                    $data[$i]['area'] = '江北区';
                    break;
                case 3:
                    $data[$i]['area'] = '高新区';
                    break;
                case 4:
                    $data[$i]['area'] = '原江东区';
                    break;
                case 5:
                    $data[$i]['area'] = '原鄞州区';
                    break;
                case 6:
                    $data[$i]['area'] = '北仑区';
                    break;
                case 7:
                    $data[$i]['area'] = '慈溪';
                    break;
                case 8:
                    $data[$i]['area'] = '余姚';
                    break;
                case 9:
                    $data[$i]['area'] = '宁海';
                    break;
                case 10:
                    $data[$i]['area'] = '象山';
                    break;
                case 11:
                    $data[$i]['area'] = '镇海';
                    break;
                case 12:
                    $data[$i]['area'] = '奉化';
                    break;
                case 13:
                    $data[$i]['area'] = '东钱湖';
                    break;
                case 14:
                    $data[$i]['area'] = '其它';
                    break;
                default:
                    break;
            }
            switch ($data[$i]['print_res']) {
                case 0;
                    $data[$i]['print_res'] = '无';
                    break;
                case 1;
                    $data[$i]['print_res'] = '有';
                    break;
            }
            switch ($data[$i]['sex']) {
                case 0;
                    $data[$i]['sex'] = '女';
                    break;
                case 1;
                    $data[$i]['sex'] = '男';
                    break;
                case 2;
                    $data[$i]['sex'] = '未知';
                    break;
            }
        }
        $title = ['apply_id' => '序号', 'admin_name' => '身份证号码', 'stu_name' => '学生姓名', 'stu_sn' => '学生编号', 'register' => '户籍',
            'area' => '区域', 'sex' => '性别', 'class' => '班级', 'graduated_school' => '毕业学校', 'father_name' => '父亲姓名',
            'father_work' => '父亲工作单位', 'father_tel' => '父亲联系电话', 'mother_name' => '母亲姓名', 'mother_work' => '母亲工作单位',
            'mother_tel' => '母亲联系电话', 'five_first_chinese' => '五年级上语文', 'five_first_math' => '五年级上数学',
            'five_first_english' => '五年级上英语', 'five_first_science' => '五年级上科学', 'five_first_sports' => '五年级上体育',
            'five_second_chinese' => '五年级下语文', 'five_second_math' => '五年级下数学', 'five_second_english' => '五年级下英语',
            'five_second_science' => '五年级下科学', 'five_second_sports' => '五年级下体育', 'six_first_chinese' => '六年级上语文',
            'six_first_math' => '六年级上数学', 'six_first_english' => '六年级上英语', 'six_first_science' => '六年级上科学',
            'six_first_sports' => '六年级上体育', 'apply_condition1' => '五、六年级主要学科(语文、数学、外语、科学)学业成绩达到优秀等第；并在五、六年级期间，至少一次获得以下其中一项校级及以上荣誉称号：
            三好学生、优秀学生干部（优秀少先队员）、学习积极分子、优秀毕业生、道德标兵，或等同上述称号的荣誉', 'apply_condition2' => '热爱体育运动，身体素质好，在田径项目、乒
            乓球项目或射击项目等比赛中获得区级第一名或素质出众者', 'apply_condition3' => '在科技创新大赛、天文、航空、航天、航海、车辆模型比赛或电脑机器人比赛中获宁波市一等奖及以上',
            'honor' => '五六年级所获校级及以上荣誉', 'point' => '本人特长', 'updated_at' => '报名时间', 'apply_res' => '报名结果', 'face_time' => '面试时间',
            'print_res' => '是否打印过', 'admission_res' => '最终结果'];
        $name = [];
        foreach ($title as $v) {
            $name[] = $v;
        }
        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("兴宁中学")
            ->setLastModifiedBy("兴宁中学")
            ->setTitle("数据EXCEL导出")
            ->setSubject("数据EXCEL导出")
            ->setDescription("备份数据")
            ->setKeywords("excel")
            ->setCategory("result file");
        $letter = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN'];
        for ($i = 0; $i < count($letter); $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($letter[$i] . '1', $name[$i]);
        }
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < 40; $j++) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($letter[$j] . ($i + 2), $data[$i][$key_name[$j]]);
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle('兴宁中学-学生报名名单');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . '学生报名'.date('Y/m/d/H/i/s',time()) . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    /**
     * 报名结果导入
     * @return array
     */
    public function applyExcelImport(Request $request)
    {
        $params = $request->all();
        if (!isset($params['file_path']) && !empty($params['file_path'])) {
            return ['code' => 90002, 'msg' => '文件路径必传'];
        }
        $url = storage_path() . '/app/' . $params['file_path'];
        header("Content-type: text/html; charset=utf-8");
        date_default_timezone_set('PRC');
        $type = 'Excel5';//设置为Excel5代表支持2003或以下版本，Excel2007代表2007版
        $xlsReader = \PHPExcel_IOFactory::createReader($type);
        $xlsReader->setReadDataOnly(true);
        $xlsReader->setLoadSheetsOnly(true);
        $Sheets = $xlsReader->load($url);
        //开始读取上传到服务器中的Excel文件，返回一个二维数组
        $dataArray = $Sheets->getSheet(0)->toArray();
        try {
            for ($j = 1; $j <= count($dataArray); $j++) {
                $apply_res = $Sheets->getActiveSheet()->getCell("AK" . $j)->getValue();//获取报名结果
                $face_time = $Sheets->getActiveSheet()->getCell("AL" . $j)->getValue();//获取报名时间
                $stu_sn = $Sheets->getActiveSheet()->getCell("D" . $j)->getValue();//获取学生编号
                Apply::where('stu_sn', $stu_sn)->update(array('apply_res' => $apply_res, 'face_time' => $face_time));
            }
            return ['code' => 1, 'msg' => '导入成功'];
        } catch (\Exception $e) {
            return ['code' => 90002, 'msg' => '导入失败，请查看内容是否符合模板'];
        }
    }

    /**
     * 报名面试结果导入
     * @return array
     */
    public function applyExcelFaceImport(Request $request)
    {
        $params = $request->all();
        if (!isset($params['file_path'])) {
            return ['code' => 90002, 'msg' => '文件路径必传'];
        }
        $url = storage_path() . '/app/' . $params['file_path'];
        header("Content-type: text/html; charset=utf-8");
        date_default_timezone_set('PRC');
        $type = 'Excel5';//设置为Excel5代表支持2003或以下版本，Excel2007代表2007版
        $xlsReader = \PHPExcel_IOFactory::createReader($type);
        $xlsReader->setReadDataOnly(true);
        $xlsReader->setLoadSheetsOnly(true);
        $Sheets = $xlsReader->load($url);
        //开始读取上传到服务器中的Excel文件，返回一个二维数组
        $dataArray = $Sheets->getSheet(0)->toArray();
        try {
            for ($j = 1; $j <= count($dataArray); $j++) {
                $admission_res = $Sheets->getActiveSheet()->getCell("AN" . $j)->getValue();//获取面试结果
                $stu_sn = $Sheets->getActiveSheet()->getCell("D" . $j)->getValue();//获取学生编号
                Apply::where('stu_sn', $stu_sn)->update(array('admission_res' => $admission_res));
            }
            return ['code' => 1, 'msg' => '导入成功'];
        } catch (\Exception $e) {
            return ['code' => 90002, 'msg' => '导入失败，请查看内容是否符合模板'];
        }
    }

}
