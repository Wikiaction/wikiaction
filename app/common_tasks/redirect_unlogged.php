<?php
session_start();
if(!isset($_SESSION['logged'])){
	session_destroy();
	if(isset($_GET)){
		$str_get = "";
		foreach($_GET as $key => $value){
			$str_get .= $key . "=" . $value . "&";
		}
		header("Location: login.php?referer=get&url=".basename($_SERVER['PHP_SELF'])."&".$str_get);
		//header("Location: login.php?referer=".basename($_SERVER['PHP_SELF'])."?".http_build_query($_GET));
	} else {
		header("Location: login.php?referer=post&url".basename($_SERVER['PHP_SELF']));
	}
	exit();
}
?>
