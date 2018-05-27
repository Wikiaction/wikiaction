<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
//no need to continue if there is no value in the POST username
//include('hyphenize.php');
if(!isset($_POST['pseudo'])){
    exit;
}
if(preg_match('^[A-Za-z\d-]+$',$_POST['pseudo']) != 1){
  echo 0;
}
include 'common/dbase_connect.php';
$sthandler = $dbhandler->prepare('SELECT * FROM comptes_utilisateurs WHERE pseudo=:pseudo');
$sthandler->bindParam(':pseudo',$_POST['pseudo']);
$sthandler->execute();
if($sthandler->rowCount() > 0){
	echo 0;
}else{
	echo 1;
}
$dbhandler = null;
?>
