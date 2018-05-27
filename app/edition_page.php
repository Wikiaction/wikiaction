<?php
error_reporting(E_ALL);
if(!isset($_SESSION)) {
	session_start();
}
require_once "common_tasks/redirect_unlogged.php";
if(!isset($_GET["project"])){
	echo "pas de projet choisit";
} else {
	include 'common/dbase_connect.php';
	$sthandler = $dbhandler->prepare('SELECT * FROM projet_base WHERE url_projet_name=:project');
	$sthandler->bindParam(':project',$_GET["project"]);
	$sthandler->execute();
	$project_data = $sthandler->fetchAll();
	$project_descr = $project_data[0]["project_descr"];
	$actions_descr = $project_data[0]["actions_descr"];
	$sthandler = $dbhandler->prepare('SELECT * FROM action_table WHERE url_project_name=:project');
	$sthandler->bindParam(':project',$_GET["project"]);
	$sthandler->execute();
	$action_data = $sthandler->fetchAll();
	$action_list = array();
	for($i=0;$i<count($action_data);$i++){
		$action_list[$i] = array('ref' => $action_data[$i]["act_ref"] , 'name' => $action_data[$i]["nom_act"]);
	}
}
?><!DOCTYPE html>

<html>

<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="css/background.css"/>
	<link rel="stylesheet" type="text/css" href="css/creation-page.css"/>
	<link rel="stylesheet" type="text/css" href="css/progressbar.css"/>
	<link rel="icon" type="image/png" href="favicon.png" />
	<script type="text/javascript"><?php echo 'var form_target = "project-update.php";';?></script>
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<script type ="text/javascript" src='js/tinymce/tinymce.min.js'></script>
	<script type="text/javascript"><?php echo 'var today_date = "' . date("Y-m-d") . '";';?></script>
	<script type="text/javascript">var editing = 1;var oReq = new XMLHttpRequest(); //New request object
	var position = 0;
	var position_list = [1];
	var count_action = 0;
	var position_action = 0;
	var projet_or_action = 0;
	var next_q = 0;
	var import_data = '';
	var projet_descr = [];
	var actions_descr = [];
	oReq.onload = function() {
		import_data = JSON.parse(this.responseText);
		//alert(this.responseText);
		projet_descr = import_data["proj_descr"];
		actions_descr = import_data["act_descr"];
		position_list = projet_descr['position_list'];
		count_action = projet_descr['nbre_act'];
		projet_descr['init_name'] = <?php echo '"'. $_GET["project"] . '"' ;?>;
		projet_descr['init_act_nbr'] = projet_descr['nbre_act'];
		// TEST OF OTHER SET UP
		<?php for($i=0;$i < count($action_data);$i++){
			echo "actions_descr[". $i ."]['init_name'] = actions_descr[". $i ."]['nom_act'];";
			echo "projet_descr['action_name_". $i . "'] = '". $action_list[$i]['name'] . "';";
			echo "projet_descr['action_ref_". $i . "'] = '". $action_list[$i]['ref'] . "';";
			echo "actions_descr[". $i ."]['ref'] = '" . $action_list[$i]['ref'] . "';";
		}?>
	// END OF TEST
	};
	oReq.open("get", "get_project_data.php?project=" + <?php echo '"'.$_GET["project"].'"'; ?>, false);
	oReq.send();
	</script>
	<script type="text/javascript" src="js/creation-wizard.js"></script>
</head>

	<body onload="show_step(); refresh_links();">
			<?php require_once "common/css_menu.php";?>

		<div class="container">

			<div id="question">
				<h2></h2>
			</div>

			<div id="container2">

				<!-- <div style="display:table;width:100%;">
	  		<div style="display:table-cell;vertical-align:middle;">
	    <div style="margin-left:auto;margin-right:auto;"></div>
	  </div>
	</div> -->

				<div id="prev">
						<!-- <a id="nav-prev" onclick="prev_step();wa_Progress_bar()" class="button prev" style="visibility:hidden"></a> -->
						<a id="nav-prev" onclick="prev_step();wa_Progress_bar()" class="arrow"></a>
				</div>

				<div id="answer_div" class="form text"></div>

				<div id="next">
						<a id="nav-next" onclick="next_step();wa_Progress_bar()" class="arrow"></a>
				</div>

			</div>

			<div id="waProgress">
				 <div id="waBar"></div>
			</div>

			<div id="waProgressAction">
				 <div id="waBarAction"></div>
			</div>

			<div id="table_div">

					<table>
							<tr>
								<th>Projet</th>
								<td><p onclick="edit_project()" style="font-color: blue; text-decoration: underline; cursor: pointer;">Éditer</p></td>
							</tr>
					</table>

					<table>
						<thead>
							<tr>
							<th>Actions   <button type="button" onclick="save_data();add_action();show_step();refresh_links();">Ajouter une action</button></th>
							</tr>
						</thead>
						<tbody id="case_lien_actions">
						</tbody>
					</table>

			</div>

	</div>

		<footer>
			<?php require_once "common/footer.php";?>
		</footer>

	</body>
</html>
