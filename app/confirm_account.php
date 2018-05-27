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
$sthandler = $dbhandler->prepare('SELECT * FROM comptes_utilisateurs WHERE email=:mail AND hash_confirm =:hash');
$sthandler->bindParam(':mail', $_GET['email']);
$sthandler->bindParam(':hash', $_GET['ref']);
$sthandler->execute();
$nb_accounts = $sthandler->rowCount();
if($nb_accounts == 1){
	$accounts = $sthandler->fetchAll();
	if($accounts[0]["confirmed"] == 1){
		$dbhandler = null;
		header("Location: confirm.php?action=conf_creation_account&status=already_confirmed");
	} else {
		$sthandler = $dbhandler->prepare("UPDATE comptes_utilisateurs SET confirmed=:one WHERE email=:mail AND hash_confirm =:hash");
		$sthandler->bindParam(':mail', $_GET['email']);
		$sthandler->bindParam(':hash', $_GET['ref']);
		$sthandler->bindValue(':one', 1);
		$sthandler->execute();
		$dbhandler = null;
		header("Location: confirm.php?action=confirm_create_account&status=valid");
	}
}else{
	header("Location: confirm.php?action=confirm_create_account&status=account_not_found");
}
?>