<?php
//获取session内字符串
session_start();
if ($_POST){
	$method = $_POST['method'];
	
	if ($method == 'session_basecode'){
		$base_code = json_decode($_SESSION['base_code'], true);
		echo $base_code;
	}elseif ($method == 'session_code'){
		$code = json_decode($_SESSION['code'], true);
		echo $code;
	}
	exit;
}