<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
//no need to continue if there is no value in the POST username
//include('hyphenize.php');
if(!isset($_POST['email'])){
    exit;
}
include 'common/dbase_connect.php';
$sthandler = $dbhandler->prepare('SELECT * FROM comptes_utilisateurs WHERE email=:mail');
$sthandler->bindParam(':mail', $_POST['email']);
$sthandler->execute();
if($sthandler->rowCount() > 0){
	echo 0;
}else{
	echo 1;
}
$dbhandler = null;
?>