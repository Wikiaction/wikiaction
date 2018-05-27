<?php
//echo "test";
if(!isset($_SESSION)) {
	session_start(); 
}
require_once "common_tasks/redirect_unlogged.php";
error_reporting(E_ALL);
if(!isset($_GET['email'])){
    exit;
} else if (!isset($_GET['ref']) or $_GET['ref'] == ""){
	exit;
}
include 'common/dbase_connect.php';
$sthandler = $dbhandler->prepare('SELECT * FROM engagement_base WHERE mail=:mail AND hash_valid =:hash AND need_valid=:one');
$sthandler->bindParam(':mail', $_GET['email']);
$sthandler->bindParam(':hash', $_GET['ref']);
$sthandler->bindValue(':one', 1);
$sthandler->execute();
$data_sign_need_valid= $sthandler->fetchAll();
$nb_sign = count($data_sign_need_valid);
if($nb_sign == 1){
	$project_url_name = $data_sign_need_valid[0]["url_project_name"];
	if($data_sign_need_valid[0]["need_valid"] == 0){
		$dbhandler = null;
		header("Location: confirm.php?action=conf_sign&project=".$project_url_name."&status=already_confirmed");
	} else {
		$sthandler = $dbhandler->prepare("UPDATE engagement_base SET need_valid='0' WHERE mail=:mail AND hash_valid =:hash AND need_valid=:one");
		$sthandler->bindParam(':mail', $_GET['email']);
		$sthandler->bindParam(':hash', $_GET['ref']);
		$sthandler->bindValue(':one', 1);
		$sthandler->execute();
		$sthandler = $dbhandler->prepare("SELECT seuil_act,nb_subscribed FROM action_table WHERE act_ref=:act_ref");
		$sthandler->bindParam(':act_ref', $data_sign_need_valid[0]["ref_act"]);
		$sthandler->execute();
		$data= $sthandler->fetchAll();
		$sthandler = $dbhandler->prepare("UPDATE action_table SET nb_subscribed = nb_subscribed + 1 WHERE act_ref=:act_ref");
		$sthandler->bindParam(':act_ref', $data_sign_need_valid[0]["ref_act"]);
		$sthandler->execute();
		//print_r($data);
		if($data[0]["nb_subscribed"] < $data[0]["seuil_act"]){
			$sthandler = $dbhandler->prepare("UPDATE projet_base SET nb_engage=nb_engage + 1 WHERE url_projet_name=:url");
			$sthandler->bindParam(':url', $project_url_name);
			$sthandler->execute();
			//echo "added 1";
		}
		$dbhandler = null;
		header("Location: projet.php?project=".$project_url_name."&message=signed_conf");
	}
}else if ($nb_sign == 0){
	$sthandler = $dbhandler->prepare('SELECT * FROM engagement_base WHERE mail=:mail AND hash_valid =:hash AND need_valid=:zero');$sthandler->bindParam(':mail', $_GET['email']);
	$sthandler->bindParam(':hash', $_GET['ref']);
	$sthandler->bindValue(':zero', 0);
	$sthandler->execute();
	$nb_sign_already_valid = $sthandler->rowCount();
	$valid_signatures = $sthandler->fetchAll();
	$project_url_name = $valid_signatures[0]["url_project_name"];
	$dbhandler = null;
	if($nb_sign_already_valid > 0){
		header("Location: projet.php?project=".$project_url_name."&message=signed_already");
	} else {
		header("Location: projet.php?project=".$project_url_name."&message=signed_not_found");
	}
}else if ($nb_sign > 1){
	$project_url_name = $data_sign_need_valid[0]["url_project_name"];
	$sthandler = $dbhandler->prepare("UPDATE engagement_base SET need_valid='0' WHERE mail=:mail AND hash_valid =:hash AND need_valid=:one");
	$sthandler->bindParam(':mail', $_GET['email']);
	$sthandler->bindParam(':hash', $_GET['ref']);
	$sthandler->bindValue(':one', 1);
	$sthandler->execute();
	$increment_project_sign = 0;
	for ($i = 0; $i < $nb_sign; $i++){
		$sthandler = $dbhandler->prepare("SELECT seuil_act,nb_subscribed FROM action_table WHERE act_ref=:act_ref");
		$sthandler->bindParam(':act_ref', $data_sign_need_valid[$i]["ref_act"]);
		$sthandler->execute();
		$data= $sthandler->fetchAll();
		$sthandler = $dbhandler->prepare("UPDATE action_table SET nb_subscribed = nb_subscribed + 1 WHERE act_ref=:act_ref");
		$sthandler->bindParam(':act_ref', $data_sign_need_valid[$i]["ref_act"]);
		$sthandler->execute();
		//print_r($data);
		if($data[$i]["nb_subscribed"] < $data[$i]["seuil_act"]){
			$increment_project_sign += 1;
		}
	$sthandler = $dbhandler->prepare("UPDATE projet_base SET nb_engage=nb_engage + :increment WHERE url_projet_name=:url");
	$sthandler->bindParam(':url', $project_url_name);
	$sthandler->bindParam(':increment', $increment_project_sign);
	$sthandler->execute();
	//echo "added multiple";
		}
	$dbhandler = null;
	header("Location: projet.php?project=".$project_url_name."&message=signed_conf");
}
?>