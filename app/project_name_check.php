<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
//no need to continue if there is no value in the POST username
include('hyphenize.php');
if(!isset($_POST['project_name'])){
	exit;
}
if(isset($_POST['init_name'])){
	if(hyphenize($_POST['project_name']) == $_POST['init_name']){
		echo 1;
		exit;
	}
}
include 'common/dbase_connect.php';
$sthandler = $dbhandler->prepare('SELECT 1 FROM projet_base WHERE url_projet_name=:name');
$sthandler->bindParam(':name', hyphenize($_POST['project_name']));
$sthandler->execute();
if($sthandler->rowCount() > 0){
	echo 0;
}else{
	echo 1;
}
$dbhandler = null;
?>