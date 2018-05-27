<?php

//var_dump($_POST);
error_reporting(E_ALL);
if(!isset($_SESSION)) {
	session_start();
}
require_once "common_tasks/redirect_unlogged.php";
require_once 'common/dbase_connect.php';
$sthandler = $dbhandler->prepare('SELECT * FROM projet_base WHERE url_projet_name=:name');
$sthandler->bindParam(':name', $_GET['project']);
$sthandler->execute();
$result = $sthandler->fetchAll();
$title = $result[0]["titre_projet"];
$descr_prob = $result[0]["descr_prob"];
$descr_sol = $result[0]["descr_sol"];
$debut_period_projet = $result[0]["debut_period_project"];
$fin_period_projet = $result[0]["fin_period_project"];
$seuil_unit_engagement = $result[0]["seuil_unit_engagement"];
$date_creation = $result[0]["date_creation"];
$creator = $result[0]["createur"];
if($_SESSION['userID'] == $creator){
	if(isset($_GET['new_title_1'])){
		$sthandler = $dbhandler->prepare('UPDATE projet_base SET title_project_page_pb =:value WHERE url_projet_name=:name');
		$sthandler->bindParam(':value', $_GET['new_title_1']);
		$sthandler->bindParam(':name', $_GET['project']);
		$sthandler->execute();
	}
	if(isset($_GET['new_title_2'])){
		$sthandler = $dbhandler->prepare('UPDATE projet_base SET title_project_page_sol =:value WHERE url_projet_name=:name');
		$sthandler->bindParam(':value', $_GET['new_title_2']);
		$sthandler->bindParam(':name', $_GET['project']);
		$sthandler->execute();
	}
}
header("Location: projet.php?project=" . $_GET['project']);
?>
