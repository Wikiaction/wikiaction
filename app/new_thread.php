<?php

//var_dump($_POST);
error_reporting(E_ALL);
// if(!isset($_SESSION)) {
// 	session_start();
// }
require_once "common_tasks/redirect_unlogged.php";

require_once 'common/dbase_connect.php';
require_once 'common/Parsedown.php';

$Parsedown = new Parsedown();
$contentParsed = $Parsedown->text($_GET['content']);
echo $contentParsed;


$sthandler = $dbhandler->prepare('CALL sp_Post(:ReplyToID,:content,:contentHTML,:creator,:topic)');
$sthandler->bindParam(':ReplyToID', $_GET['reply_id']);
$sthandler->bindParam(':content',$_GET['content']);
$sthandler->bindParam(':contentHTML',$contentParsed);
$sthandler->bindParam(':creator',$_SESSION['userID']);
$sthandler->bindParam(':topic',$_GET['project']);
$sthandler-> execute();


header("Location: debate.php?project=" . $_GET['project'] . "&sort=" . $_GET['sorting']);
?>
