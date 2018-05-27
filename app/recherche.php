<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include 'common/dbase_connect.php';
$sthandler = $dbhandler->prepare('SELECT * FROM projet_base WHERE confirmed_by_author = :confirmed');
$sthandler->bindValue(':confirmed', 1);
$sthandler->execute();
$result = $sthandler->fetchAll();
$dbhandler = null;
?><!DOCTYPE html>

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

      <div id="top_space"></div>

			<div class="search__title">
          <h1>RECHERCHER</h1>
			</div>

<script type='text/javascript'>
    var SearchTable_array =
    <?php
    $temp_array = array();
    foreach($result as $record){
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
    ?>
    ;

  $(document).ready(function() {
    $('#SearchTable').DataTable( {
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
      data: SearchTable_array,
      columns: [
          { title: "Nom du projet" },
          { title: "Nombre d'engagés total" },
          //{ title: "Status par unité d'engagement" },
          { title: "Seuil global" },
        ]
    } );
  } );

</script>

    <div class="search__table">
      <table id="SearchTable" class="stripe" width="100%"></table>
    </div>
    <div class="push"></div>
	</div>



  <footer>
    <?php require_once "common/footer.php";?>
  </footer>

</body>

</html>
