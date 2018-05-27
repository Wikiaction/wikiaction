<?php
include 'secretInfo.php';
$dbhandler = new PDO('mysql:host=wikiaction-db;dbname=dev-gael', USERNAME_DB, PASSWORD_DB);
$dbhandler -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
?>
