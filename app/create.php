<?php
error_reporting(E_ALL);
if(!isset($_SESSION)) {
	session_start();
}
require_once "common_tasks/redirect_unlogged.php";
?><!DOCTYPE html>

<html>

<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
	<title>Wikiaction.org</title>
	<link rel="icon" type="image/png" href="favicon.png" />
	<link rel="stylesheet" type="text/css" href="temp/styles/styles.css"/>
	<script type="text/javascript" src="scripts/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="temp/scripts/Wikiaction.js"></script>
</head>

<body>

	<?php require_once "common/css_menu.php";?>

	<div class="container">
		<div id="top_space"></div>
		<div class="create-project">
			<div class="create-project__header">
				<p>La création d'un projet se compose de 15 questions (7 pour le projet, et 8 pour chaque action) et prendra entre 15 et 30 minutes.</p>
			</div>
	
			<div class="create-project__buttons">
				<a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="button big">RETOUR</a>
				<a href="creation-page.php" class="button big">CONTINUER</a>
			</div>
		</div>

	<div class="push"></div>
	</div>

	<footer>
		<?php require_once "common/footer.php";?>
	</footer>

</body>
</html>
