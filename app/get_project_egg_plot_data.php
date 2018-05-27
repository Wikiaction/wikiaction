<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include 'common/dbase_connect.php';
$sthandler = $dbhandler->prepare('SELECT nb_engage,seuil_unit_engagement FROM projet_base WHERE url_projet_name=:project');
$sthandler->bindParam(':project',$_GET["project"]);
$sthandler->execute();
$result = $sthandler->fetchAll();
echo json_encode($result);
?>