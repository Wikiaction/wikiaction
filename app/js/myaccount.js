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
    //{ title: "Status par unité d'engagement" },
    { title: "Seuil global" },
  ]
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
