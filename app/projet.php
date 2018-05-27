<?php
error_reporting(E_ALL);
if(!isset($_SESSION)) {
	session_start();
}
if(!isset($_SESSION['logged'])){
	session_destroy();
}
//var_dump($_POST)
include 'common/dbase_connect.php';
$sthandler = $dbhandler->prepare('SELECT * FROM projet_base WHERE url_projet_name=:name');
$sthandler->bindParam(':name', $_GET['project']);
$sthandler->execute();
$result = $sthandler->fetchAll();
//$dbhandler = null;
$project_id = $result[0]["ID"];
$title = $result[0]["titre_projet"];
$descr_prob = $result[0]["descr_prob"];
$descr_sol = $result[0]["descr_sol"];
$debut_period_projet = $result[0]["debut_period_project"];
$fin_period_projet = $result[0]["fin_period_project"];
$seuil_unit_engagement = $result[0]["seuil_unit_engagement"];
$date_creation = $result[0]["date_creation"];
$creator = $result[0]["createur"];
$title_1 = $result[0]["title_project_page_pb"];
$title_2 = $result[0]["title_project_page_sol"];
$sthandler = $dbhandler->prepare('SELECT * FROM action_table WHERE url_project_name=:name');
$sthandler->bindParam(':name', $_GET['project']);
$sthandler->execute();
$action = $sthandler->fetchAll();
$dbhandler = null;
//var_dump($action);
?><!DOCTYPE html>

<html>

	<head>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
		<title>Wikiaction.org</title>
		<link rel="icon" type="image/png" href="favicon.png" />
		<link rel="stylesheet" type="text/css" href="temp/styles/styles.css"/>
		<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="js/d3.v3.min.js"></script>
		<script type="text/javascript">var project_url = "<?php echo $_GET['project'] ?>";</script>
		<?php if(isset($_SESSION['userID'])){
				if($_SESSION['userID'] == $creator){
					echo "<script type='text/javascript' src='js/projet.js'></script>";
				}
			}
		?>
	</head>



<body
	 <?php
	if(isset($_GET["message"])){
		if($_GET["message"] == "created"){
			echo "onload='$(document).ready(function(){
			alert(\"Votre projet a bien été créé! un courriel de confirmation vous a été envoyé\");
			});'";
		} elseif($_GET["message"] == "modif"){
			echo "onload='$(document).ready(function(){
			alert(\"Votre projet a bien été modifié! Un courriel de confirmation vient de vous être envoyé\");
			});'";
		} elseif($_GET["message"] == "signed"){
			echo "onload='$(document).ready(function(){
			alert(\"Un courriel vient de vous être envoyé pour vous permettre de confirmer votre signature... à tout de suite!\");
			});'";
		} elseif($_GET["message"] == "signed_no_action"){
			echo "onload='$(document).ready(function(){
			alert(\"Vous n&apos;avez pas sélectionné d&apos;action lors de la signature du contrat.\");
			});'";
		} elseif($_GET["message"] == "signed_already"){
			echo "onload='$(document).ready(function(){
			alert(\"Un contrat existe déjà pour les action sélectionnées avec cette adresse mail.\");
			});'";
		} elseif($_GET["message"] == "signed_conf"){
			echo "onload='$(document).ready(function(){
			alert(\"La signature de votre contrat est confirmée.\");
			});'";
		} elseif($_GET["message"] == "signed_not_found"){
			echo "onload='$(document).ready(function(){
			alert(\"Désolé, mais nous ne trouvons pas votre contrat. Vérifiez que vous avez cliqué sur le lien le plus récent si vous avez signé plusieurs fois la même action. Sinon, vous pouvez signer un nouveau contrat.\");
			});'";
		}
	}
	echo">";
	require_once "common/css_menu.php";?>

	<div class="container">
		<div id="top_space"></div>
		<div class="project-container">

			<div class="project__title">
				<h1><center><?php echo $title  ?><center/></h1>
			</div>

			<div id="header1" class="project__header1">
					<?php
						if($title_1 == NULL){
							echo "PROBLEME";
						} else {
							$upperTitle_1 = mb_strtoupper($title_1, 'UTF-8');
							echo "<span>$upperTitle_1</span>";
						}
						if(isset($_SESSION['userID'])){
							if($_SESSION['userID'] == $creator){
								echo "<button type='button' onclick='change_title_1();' class='button small'>MODIFIER</button>";
							}
						}
					?>
					<br><hr class="style1">
			</div>

			<div id="header2" class="project__header2">
					<?php
						if($title_2 == NULL){
							echo "LA MÉTHODE";
						} else {
							echo mb_strtoupper($title_2, 'UTF-8');
						}
						if(isset($_SESSION['userID'])){
							if($_SESSION['userID'] == $creator){
								echo "<button type='button' onclick='change_title_2();' class='button small'>MODIFIER</button>";
							}
						}
					?>
					<br><hr class="style1">
			</div>
			<div class="project__probleme">
					<p><?php echo $descr_prob ?></p>
			</div>

			<div class="project__solution">
				<p><?php echo $descr_sol ?></p>
			</div>

			<div class="project__graph">
				<div id="oeuf"><script type="text/javascript" src="js/egg_plot.js"></script></div>
				<div id="debat"><a href="<?php echo "debate.php?project=".$project_id."&sort=c"; ?>" class="button">PAGE DE DÉBAT</a></div>
			</div>

			<div id="header3" class="project__header-action">
				CE QUE VOUS POUVEZ FAIRE
				<br><hr class="style2">
			</div>

		<div class="grid-actions">
				<?php
				for($i = 0 ; $i < count($action) ; $i++){
					echo "
					<div id='action' class='action-card'>

						<div id='titleaction' class='action-card__title'>
							<input id='checkbox-" .$i ."'  name='checkbox-" .$i ."' type='checkbox'>
							<label for='checkbox-" .$i ."' '>".$action[$i]["nom_act"]." (".$action[$i]["nb_subscribed"]."/".$action[$i]["seuil_act"].")</label>
						</div>

						<div id='contentaction' class='action-card__content'>
							<p>Description:</p>
							<p>".$action[$i]["descr_act"]."</p>";
					if($action[$i]["temporalite_action"] == "0"){
						if($action[$i]["start_period_action"] == '2010-01-01'){
							if($action[$i]["end_period_action"] == '2010-01-01'){
								echo "<p>Action continue tout au long du projet</p>";
							} else {
								echo "<p>Action ponctuelle</p>
								<p>Période d'action:</p>
								<p>Du début du projet au ".$action[$i]["end_period_action"]."</p>";
							}
						} else {
							if($action[$i]["end_period_action"] == '2010-01-01'){
								echo "<p>Action ponctuelle</p>
								<p>Période d'action:</p>
								<p>Du ".$action[$i]["start_period_action"]." à la fin du projet</p>";
							} else {
								echo "<p>Action ponctuelle</p>
								<p>Période d'action:</p>
								<p>Du ".$action[$i]["start_period_action"]." au ".$action[$i]["end_period_action"]."</p>";
							}
						}
					} elseif($action[$i]["temporalite_action"] == "1"){
						$chaine_jours = "";
						$list_jours = array("0"=> "lundi","1"=> "mardi","2"=> "mercredi","3"=> "jeudi","4"=> "vendredi","5"=> "samedi","6"=> "dimanche");
						if(strpos($action[$i]["list_jours_actions"] , '&') !== false){
							$choix_jours = explode("&",$action[$i]["list_jours_actions"]);
						} else {
							$choix_jours = array($action[$i]["list_jours_actions"]);
						}
						$chaine_jours = "";
						for($j=0;$j<count($choix_jours);$j++){
							$ref = explode("=",$choix_jours[$j]);
							$chaine_jours = $chaine_jours . $list_jours[$ref[0]];
							if(count($choix_jours) > 1){
								if($j==count($choix_jours) - 2){
									$chaine_jours = $chaine_jours . " et ";
								} elseif($j<count($choix_jours) - 2){
									$chaine_jours = $chaine_jours . ", ";
								}
							}
						}
						echo "<p>Action répétée tout au long du projet</p>
						<p>L'action est réalisée tous les ".$chaine_jours;
					} else {
						echo "<p>Action continue tout au long du projet</p>";
					}
					echo "</div>
					</div>";
				} ?>
			</div>
		<div id="signer" class="project__signature">
			<a href="<?php echo "contract.php?project=" . $_GET['project']; ?>" class="button big">SIGNER</a>
			<?php if(isset($_SESSION['userID'])){
					if($_SESSION['userID'] == $creator){
						echo "<a href=edition_page.php?project=" . $_GET['project'] .  ' class="button big">MODIFIER</a>';
					}
				}
			?>
		</div>

		
		</div>

		<div class="push"></div>
	</div>


	<footer>
    <?php require_once "common/footer.php";?>
  </footer>

</body>

</html>
