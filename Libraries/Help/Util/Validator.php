<?php
/**
 * Author: cuidongming
 * CreateTime: 2016/6/2 9:40
 * Description:
 */

namespace Libraries\Help\Util;

class Validator
{
	/**
	 * 身份证号验证（格式、性别）
	 * @param string $card
	 * @return bool
	 */
	public static function vdCard($card = '')
	{
        $len=strlen($card);
        if($len!=18){
            return ['code'=>90001,'msg'=>'身份证格式错误'];
        }
        $card=strtoupper($card);
        $a=str_split($card,1);
        $w=[7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2];
        $c=[1,0,'X',9,8,7,6,5,4,3,2];
        $sum=0;
        for($i=0;$i<17;$i++){
            $sum=$sum+$a[$i]*$w[$i];
        }
        $r=$sum%11;
        $res=$c[$r];
        if($res==$a[17]){
//            $area=$a[4].$a[5]=='24'?'83':$a[4].$a[5];
//            $params=[
//                $a[0].$a[1],
//                $a[0].$a[1].$a[2].$a[3],
//                $a[0].$a[1].$a[2].$a[3].$area,
//            ];
//            $region=\RegionService::regionGet($params);
//            $data['region']=$region['data'];
//            if($a[16]%2 == 0 && $a[16] !=1){
//                $data['sex']='女';
//            }else{
//                $data['sex']='男';
//            }
            return ['code'=>1,'msg'=>'成功'];
        }else{
            return ['code'=>90001,'msg'=>'身份证格式错误'];
        }
	}
	/**
	 * 检查手机号码格式
	 * @param string $mobile
	 * @return int
	 */
	public static function validateMobile($mobile = '')
	{
		preg_match('/^1[3|4|5|7|8][0-9]\d{4,11}$/', $mobile, $result);

		if (!$result) {
			return false;
		}
		return true;
	}

	/**
	 * 检查邮箱格式
	 * @param string $email
	 * @return int
	 */
	public static function validateEmail($email = '')
	{
		preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $email, $result);

		if (!$result) {
			return false;
		}

		return true;
	}
}