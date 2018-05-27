<?php
error_reporting(E_ALL);
include 'common/dbase_connect.php';
$sthandler = $dbhandler->prepare('SELECT url_projet_name,titre_projet,nb_engage,seuil_unit_engagement FROM projet_base WHERE confirmed_by_author = :one');
$sthandler->bindValue(':one', 1);
$sthandler->execute();
$result = $sthandler->fetchAll();
echo json_encode($result);
?>