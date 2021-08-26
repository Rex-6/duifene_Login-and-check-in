<?php
namespace duifenyi;
use phpbrower/Phpbrower;

class Duifenyi
{

	private $brower;

	function __construct()
	{
		$this->brower = new Phpbrower();
	}

	function login($userid,$passwd){
		$strs = "QWERTYUIOPASDFGHJKLZXCVBNM1234567890";
		$guid = substr(str_shuffle($strs),mt_rand(0,strlen($strs)-17),16);
		$url = 'https://www.duifene.com/AppCode/LoginInfo.ashx';
		$data = [
			'action' => 'login',
			'loginname'=> $userid,
			'password'=> $passwd,
			'issave'=> 'false',
			'guid'=> $guid,
		];
		$result = json_decode($this->brower->post($url,$data),true);
		if($result['msg'] == '1'){
			return true;
		}else{
			return $result['msgbox'];
		}
	}

	function checkin($checkincode,$studentid){
		$url = 'https://www.duifene.com/_CheckIn/CheckIn.ashx';
		$data = [
			'action' => 'studentcheckin',
			'studentid'=> $studentid,
			'checkincode'=> $checkincode,
		];
		$result = $this->brower->post($url,$data);
		$result = json_decode($this->brower->post($url,$data),true);
		return $result;
	}

	// function qrcheckin($classid,$state){
	// 	$url = 'https://www.duifene.com/_CheckIn/MB/QrCodeCheckOK.aspx';
	// 	$code = md5($classid.$state);
	// 	$data = [
	// 		'classid' => $classid,
	// 		'code' => $code,
	// 		'state' => $state,
	// 	];
	// 	$result = $this->brower->get($url,$data);
	// 	echo($result);
	// 	@$dom->loadHTML($result);		
	// 	$dom->normalize();
	// 	$xpath = new DOMXPath($dom);
	// 	$value = $xpath->query('//span/text()');
	// 	$value = $value->item(0)->nodeValue;
	// 	echo($value);
	// 	if($value == '您已经签到成功！' or $value == '签到成功！'){
	// 		return true;
	// 	}else{
	// 		return false;
	// 	}
	// }

	function getstudenid(){
		$url = 'https://www.duifene.com/_CheckIn/MB/CheckInStudent.aspx';
		$result = $this->brower->get($url);	
		$dom = new DOMDocument();
		@$dom->loadHTML($result);		
		$dom->normalize();
		$xpath = new DOMXPath($dom);
		$value = $xpath->query('//input[@id="StudentId"]/@value');
		$value = $value->item(0)->nodeValue;
		return $value;
	}
}

// $phone = '13800000000';
// $passwd = '123456';
// $classid = '123456';
// $state = '1234';
// $duifenyi = new duifenyi();
// $duifenyi->login($phone,$passwd);
// // $duifenyi->checkin($checkincode,$studentid);
// // $duifenyi->getstudenid();
// $duifenyi->qrcheckin($classid,$state)

?>