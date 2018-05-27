<?php
error_reporting(E_ALL);
if(!isset($_SESSION)) {
	session_start();
}
require_once "common_tasks/redirect_unlogged.php";
include 'common/dbase_connect.php';
$sthandler = $dbhandler->prepare('SELECT * FROM projet_base WHERE createur=:creator');
$sthandler->bindParam(':creator', $_SESSION['userID']);
$sthandler->execute();
$projects = $sthandler->fetchAll();
// $dbhandler = null;

$sthandler = $dbhandler->prepare('SELECT * FROM engagement_base WHERE mail=:creator AND need_valid=:zero');
$sthandler->bindParam(':creator', $_SESSION['mail']);
$sthandler->bindValue(':zero', 0);
$sthandler->execute();
$contracts = $sthandler->fetchAll();

?><!DOCTYPE html>

<html>

	<head>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
		<title>Wikiaction.org</title>
		<link rel="icon" type="image/png" href="favicon.png" />
		<link rel="stylesheet" type="text/css" href="temp/styles/styles.css"/>
		<link rel="stylesheet" type="text/css" href="scripts/DataTables-1.10.9/css/jquery.dataTables.min.css"/>
		<script type="text/javascript" src="scripts/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="scripts/DataTables-1.10.9/js/jquery.dataTables.min.js"></script>
	</head>

	<body>
	<?php require_once "common/css_menu.php";?>

		<div class="container">

			<div class="myaccount__container2">
				<div id="tab_myaccount">
					<ul class="myaccount__tab">
						<li><a href="javascript:void(0)" class="tablinks" onclick="openTab(event, 'Projects')" id="defaultOpen">Mes Projets</a></li>
						<li><a href="javascript:void(0)" class="tablinks" onclick="openTab(event, 'Actions')">Mes Actions</a></li>
					</ul>
				</div>
			<div id="Projects" class="tabcontent">
				<br>
			  <table id="my_project" class="stripe" width="100%"></table>
			</div>

			<div id="Actions" class="tabcontent">
				<br>
			  <table id="my_actions" class="stripe" width="100%"></table>
			</div>


				<script type='text/javascript'>
						var js_array =
						<?php
						$temp_array = array();
						foreach($projects as $record){
							$nb_engaged = $record["nb_engage"];
							$nb_engage = $record["nb_engage"];
							$seuil_unit_engagement = $record["seuil_unit_engagement"];
							//$titre_unit = $record["unit_engagement"];
							//$txt_unit ='';
							//for($i=0;$i<$nb_unit;$i++){
									//$txt_unit .= $titre_unit[$i].': '.$nb_engage[$i].' / '.$seuil_unit_engagement[$i];
									//$txt_unit .= 'Unité '.$i.': '.unserialize($record["nb_engage"])[$i].unserialize($record["seuil_unit_engagement"])[$i];
									//if($i<$nb_unit - 1){
										//$txt_unit = $txt_unit.'</br>';
									//}
							//}
							$temp_array[] = array("<a href='projet.php?project=".html_entity_decode($record['url_projet_name'],$flags = ENT_QUOTES,"UTF-8")."'>".html_entity_decode($record['titre_projet'],$flags = ENT_QUOTES,"UTF-8")."</a>",
							$record["nb_engage"],
							//$txt_unit,
							$record["seuil_unit_engagement"]);
						}
						echo(json_encode($temp_array));
						?>;
						$(document).ready(function() {
						$('#my_project').DataTable( {
							"language": {
				        "sProcessing":     "Traitement en cours...",
				        "sSearch":         "Rechercher&nbsp;:",
				        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
				        "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
				        "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
				        "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
				        "sInfoPostFix":    "",
				        "sLoadingRecords": "Chargement en cours...",
				        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
				        "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
				        "oPaginate": {
				            "sFirst":      "Premier",
				            "sPrevious":   "Pr&eacute;c&eacute;dent",
				            "sNext":       "Suivant",
				            "sLast":       "Dernier"
				        },
				        "oAria": {
				            "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
				            "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
				        }
				      },
							data: js_array,
							columns: [
								{ title: "Nom du projet" },
								{ title: "Nombre d'engagés total" },
								{ title: "Seuil global" },
							]
						} );
					} );


					var js_array2 =
					<?php
					$temp_array2 = array();
					foreach($contracts as $record){
						$sthandler = $dbhandler->prepare('SELECT * FROM action_table WHERE act_ref=:ref_act');
						$sthandler->bindParam(':ref_act', $record['ref_act']);
						$sthandler->execute();
						$action = $sthandler->fetchAll();
						$nb_engaged = $action[0]["nb_subscribed"];
						$seuil_action = $action[0]["seuil_act"];
						$sthandler = $dbhandler->prepare('SELECT * FROM projet_base WHERE url_projet_name=:url_project_name');
						$sthandler->bindParam(':url_project_name', $record['url_project_name']);
						$sthandler->execute();
						$projet = $sthandler->fetchAll();
						$temp_array2[] = array("<a href='projet.php?project=".html_entity_decode($projet[0]['url_projet_name'],$flags = ENT_QUOTES,"UTF-8")."'>".html_entity_decode($projet[0]['titre_projet'],$flags = ENT_QUOTES,"UTF-8")."</a>",
						html_entity_decode($action[0]['nom_act'],$flags = ENT_QUOTES,"UTF-8"),
						$nb_engaged,
						$seuil_action);
					}
					echo(json_encode($temp_array2));
					$dbhandler = null;
					?>;
					$(document).ready(function() {
					$('#my_actions').DataTable( {
						"language": {
			        "sProcessing":     "Traitement en cours...",
			        "sSearch":         "Rechercher&nbsp;:",
			        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
			        "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
			        "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
			        "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
			        "sInfoPostFix":    "",
			        "sLoadingRecords": "Chargement en cours...",
			        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
			        "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
			        "oPaginate": {
			            "sFirst":      "Premier",
			            "sPrevious":   "Pr&eacute;c&eacute;dent",
			            "sNext":       "Suivant",
			            "sLast":       "Dernier"
			        },
			        "oAria": {
			            "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
			            "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
			        },
			      },
						data: js_array2,
						columns: [
							{ "width": "500px", title: "Nom du projet" },
							{ title: "Nom de l'action" },
							{ title: "Nombre d'engagés" },
							{ title: "Seuil" }
						],
						// "columnDefs": [
						// 	{ "width": "200" , "target": 0 }
						// ]
					} );
				} );


					function openTab(evt, TabName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the link that opened the tab
    document.getElementById(TabName).style.display = "block";
    evt.currentTarget.className += " active";
}

		document.getElementById("defaultOpen").click();

					</script>

					<table id="my_project" class="stripe" width="100%"></table>

				</div>
				<div class="push"></div>
		</div>

		<footer>
			<?php require_once "common/footer.php";?>
		</footer>

	</body>

</html>
