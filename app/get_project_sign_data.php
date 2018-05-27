<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include 'common/dbase_connect.php';
$sthandler = $dbhandler->prepare('SELECT nom_act,seuil_act FROM action_table WHERE url_project_name=:project');
$sthandler->bindParam(':project',$_GET["project"]);
$sthandler->execute();
$action_data = $sthandler->fetchAll();
$sthandler = $dbhandler->prepare('SELECT nom_act,date_creation FROM engagement_base WHERE url_project_name=:project');
$sthandler->bindParam(':project',$_GET["project"]);
$sthandler->execute();
$signature_data = $sthandler->fetchAll();
$actions = ['x' =>["x"]];
$count = 0;
$current_date = "";
foreach($action_data as $a){
	if(in_array($a["nom_act"],$actions)){
		continue;
	} else {
		$actions[$a["nom_act"]] = [$a["nom_act"]];
	}
}
//echo json_encode($signature_data);
//echo "</br>";
function date_compare($a, $b)
{
    $t1 = strtotime($a['date_creation']);
    $t2 = strtotime($b['date_creation']);
    return $t1 - $t2;
}    
usort($signature_data, 'date_compare');
//foreach ($signature_data as $key => $row){
//	$signature_data[$key]["date_creation"] = explode(" ", $signature_data[$key]["date_creation"])[0];
//	$wek[$key]  = $row['date_creation'];
//}
//rray_multisort($signature_data,SORT_ASC,$wek);
//echo json_encode($signature_data);
//echo "</br>";
foreach($signature_data as $b){
	$b["date_creation"] = explode(" ", $b["date_creation"])[0];
	if($current_date!=$b["date_creation"]){
		$current_date=$b["date_creation"];
		$count ++;
		foreach($actions as $key => $value){
			if($key == "x"){
				$actions[$key][] = $current_date;
				continue;
			}
			if($count == 1){
				$actions[$key][] = 0;
			} else {
				$actions[$key][] = $actions[$key][$count - 1];
			}
		}
	}
	$actions[$b["nom_act"]][$count] ++;
}
//echo json_encode($signature_data);
//echo json_encode([$actions,$signature_sorted]);
echo json_encode($actions);
?>