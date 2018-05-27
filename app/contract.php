<?php
if(!isset($_SESSION)) {
	session_start();
}
require_once "common_tasks/redirect_unlogged.php";
error_reporting(E_ALL);
ini_set("display_errors", 0);

include 'common/dbase_connect.php';
$dbhandler -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
$sthandler = $dbhandler->prepare('SELECT * FROM projet_base WHERE url_projet_name=:name');
$sthandler->bindParam(':name', $_GET['project']);
$sthandler->execute();
$result = $sthandler->fetchAll();
$dbhandler = null;
$title = $result[0]["titre_projet"];
$descr_prob = $result[0]["descr_prob"];
$descr_sol = $result[0]["descr_sol"];
$debut_period_projet = $result[0]["debut_period_project"];
$fin_period_projet = $result[0]["fin_period_project"];
$seuil_unit_engagement = $result[0]["seuil_unit_engagement"];
$date_creation = $result[0]["date_creation"];
include 'common/dbase_connect.php';
$dbhandler -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
$sthandler = $dbhandler->prepare('SELECT * FROM action_table WHERE url_project_name=:name');
$sthandler->bindParam(':name', $_GET['project']);
$sthandler->execute();
$action = $sthandler->fetchAll();
$dbhandler = null;
?><!DOCTYPE html>


<html>

<head>
	<link rel="icon" type="image/png" href="favicon.png" />
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="temp/styles/styles.css"/>
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="temp/scripts/Wikiaction.js"></script>

</head>


<body>

	<?php require_once "common/css_menu.php";?>

			<div class="container">

				<div id="top_space"></div>
				<div id="contract-title" class="contract__title">
						<h1>contrat d'engagement</h1>
				</div>


				<form action="valid_signature.php" method="post">
				<div class="contract__container">

					<div class="contract__headers">
						<p>Veuillez sélectionner les actions pour lesquelles vous souhaitez vous engager: </p>
					</div>
					<div class="contract__actions">
					<?php
					echo "<input id='test' name='nb_act' type='hidden' value='". count($action) ."'>";
					echo "<input id='test' name='project_name' type='hidden' value='". $_GET['project'] ."'>";
					for($i=0;$i<count($action);$i++){
						echo "<div><input id='checkbox-". $i ."' name='". $i ."' type='checkbox' value='". $action[$i]["act_ref"] ."'>
						<label for='checkbox-". $i ."'>". $action[$i]["nom_act"] ."</label></div>";
					}
					?>
					</div>

					<div class="contract__headers">
						<p>Sélectionner ces actions ne vous engage que lorsque le seuil sera franchi.</p>
						<p>Entre temps, nous vous invitons à faire passer le mot afin de mobiliser ce nombre minimum de personnes. Nous vous tenons au courant de l’évolution du projet!</p>
					</div>
					
					<div class="contract__nom">
						<input class="contract__input" name="pseudo" placeholder="Nom" type="text" required>
					</div>
					<div class="contract__email">
						<input class="contract__input" name="email_placeholder" type="text" required value="<?PHP echo $_SESSION["mail"]; ?>"  disabled>
						
					</div>

					<div class="contract__validation">
						<input type="submit" id ="submit_button" class="button big" value="Signer">
						<script>
							$('form').submit(function() {
								$(this).find("input[type='submit']").prop('disabled',true);
							});
						</script>
					</div>

				</div>

			</form>

			<div class="push"></div>
		</div>

		<footer>
			<?php require_once "common/footer.php";?>
		</footer>

</body>

</html>
