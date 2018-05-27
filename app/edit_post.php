<?php

//var_dump($_POST);
error_reporting(E_ALL);
// if(!isset($_SESSION)) {
// 	session_start();
// }
// require_once "common_tasks/redirect_unlogged.php";
require_once 'common/dbase_connect.php';
$edited = 1;
	if(isset($_GET['new_post'])){
		// $sthandler = $dbhandler->prepare('UPDATE posts SET post_content =:value WHERE post_id=:id');
		$sthandler = $dbhandler->prepare('UPDATE posts SET post_content=:value , post_edited=:edited WHERE post_id=:id');
		$sthandler->bindParam(':value', $_GET['new_post']);
		$sthandler->bindParam(':edited', $edited);
		$sthandler->bindParam(':id', $_GET['id']);
		$sthandler->execute();
	}

header("Location: debate.php?project=" . $_GET['project']. "&sort=" . $_GET['sorting']);

?>
