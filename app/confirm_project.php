<?php
if(!isset($_SESSION)) {
	session_start(); 
}
require_once "common_tasks/redirect_unlogged.php";
if(!isset($_GET['email'])){
    exit;
} else if (!isset($_GET['ref']) or $_GET['ref'] == ""){
	exit;
}
include 'common/dbase_connect.php';
$sthandler = $dbhandler->prepare('SELECT * FROM projet_base WHERE createur=:mail AND hash_confirm =:hash');
$sthandler->bindParam(':mail', $_GET['email']);
$sthandler->bindParam(':hash', $_GET['ref']);
$sthandler->execute();
if($sthandler->rowCount() == 1){
	$project = $sthandler->fetchAll();
	#var_dump($project);
	if($project[0]["confirmed_by_author"] == 1){
		#echo 0;
		$dbhandler = null;
		header("Location: projet.php?project=".$project[0]["url_projet_name"]."&message=Projet déjà validé");
		#header("Location: projet.php");
		#echo "2";
	} else {
		#echo 1;
		$project_url_name = $project[0]["url_projet_name"];
		#echo $project_url_name;
		$sthandler = $dbhandler->prepare("UPDATE projet_base SET confirmed_by_author='1' WHERE createur=:mail AND hash_confirm =:hash");
		$sthandler->bindParam(':mail', $_GET['email']);
		$sthandler->bindParam(':hash', $_GET['ref']);
		$sthandler->execute();
		$dbhandler = null;
		header("Location: projet.php?project=".$project_url_name."&message=Votre projet a bien été confirmé");
	}
}else{
	$dbhandler = null;
	//echo "error, no project found for confirmation";
	header("Location: confirm.php?action=confirm_project&project=".$project_url_name."&status=project_not_found");
}


?>