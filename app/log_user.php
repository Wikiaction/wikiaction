<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include 'pass_functions.php';
if(!isset($_POST["pseudo"])){
	echo "0";
	exit;
} else if (!isset($_POST["psswd"])){
	echo "0";
	exit;
}

include 'common/dbase_connect.php';
$dbhandler -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
$sthandler = $dbhandler->prepare('SELECT * FROM comptes_utilisateurs WHERE pseudo=:pseudo');
$sthandler->bindParam(':pseudo',$_POST['pseudo']);
$sthandler->execute();
$rst_count = $sthandler->rowCount();
if($rst_count == 0){
	echo "1";
}else if ($rst_count > 1){
	echo "2";
} else {
	$data = $sthandler->fetchAll();
	if(is_pass_valid($_POST["psswd"],$data[0]["hash"])){
		if($data[0]["confirmed"] == 0){
			echo "5";
			exit;
		}
		if(!isset($_SESSION)) {
			session_start();
		}
		$_SESSION['logged'] = True;
		$_SESSION['mail'] = $data[0]["email"];
		$_SESSION['pseudo'] = $data[0]["pseudo"];
		$_SESSION['userID'] = $data[0]["userID"];
		echo "3";
	} else {
		echo "4";
	}
}
?>
