<?php

//var_dump($_POST);
error_reporting(E_ALL);
if(!isset($_SESSION)) {
	session_start();
}
require_once "common_tasks/redirect_unlogged.php";

require_once 'common/dbase_connect.php';

		$sthandler = $dbhandler->prepare('CALL sp_Vote(:user_id,:post_id,:value)');
		$sthandler->bindParam(':user_id', $_SESSION['userID']);
		// $sthandler->bindParam(':user_id', $_POST['user_id']);
		$sthandler->bindParam(':post_id',$_POST['post_id']);
		$sthandler->bindParam(':value',$_POST['value']);
		$sthandler-> execute();
	// }
// }
// header("Location: sandbox.php");
// header("Location: debate.php?project=" . $_GET['project']);
?>
