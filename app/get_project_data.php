<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
if(!isset($_GET["project"])){
	echo "pas de projet choisit";
} else {
	include 'common/dbase_connect.php';
	$sthandler = $dbhandler->prepare('SELECT * FROM projet_base WHERE url_projet_name=:project');
	$sthandler->bindParam(':project',$_GET["project"]);
	$sthandler->execute();
	$project_data = $sthandler->fetchAll();
	$project_descr = $project_data[0]["project_descr"];
	/* $sthandler = $dbhandler->prepare('SELECT * FROM action_table WHERE url_project_name=:project');
	$sthandler->bindParam(':project',$_GET["project"]);
	$sthandler->execute();
	$action_data = $sthandler->fetchAll();
	$action_list = array();
	for($i=0;$i<count($action_data);$i++){
		$action_list[$i] = array('ref' => $action_data[$i]["act_ref"] , 'name' => $action_data[$i]["nom_act"]);
	}*/
}
echo $project_descr;
?>