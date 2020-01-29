<?php
class Ajax{
	const ACT_REDIR = 'redir';
	const ACT_RESULT = 'result';
	const ACT_MSG = 'msg';
	
	public static function isAjax(){
		return(isset($_REQUEST['ajax']));
	}
	public static function json(){
		header("Content-type: application/json; charset=utf-8");
	}
	public static function redir($url='./'){
		if(self::isAjax()){
			self::json();
			exit(json_encode(array(self::ACT_REDIR=>$url)));
		}
		header('location: '.$url);
		exit();		
	}
	public static function msg($msg){
		self::json();
		exit(json_encode(array(self::ACT_MSG=>$msg)));
	}
}
?>