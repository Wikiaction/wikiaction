<!DOCTYPE html>

<html>

<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
	<title>Wikiaction.org</title>
	<link rel="icon" type="image/png" href="favicon.png"/>
	<link rel="stylesheet" type="text/css" href="temp/styles/styles.css"/>
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="js/d3.v3.min.js"></script>
	<script type="text/javascript" src="temp/scripts/Wikiaction.js"></script>
</head>

<body>
	<?php require_once "path.php";?>
	<?php require_once "common/css_menu.php";?>

	<div class="container">
		<div id="top_space"></div>
		<div class="index__grid">

			<div class="index__who">
				<div class="titre">
					<a href="about.php"><h2>QUI SOMMES NOUS ?</h2></a>
				</div>
				<div class="index__who__container">
					<p>Wikiaction est une plateforme expérimentale d’engagement collectif. Au lieu de vous demander d’agir tout de suite, nous vous proposons de conditionner votre engagement à l’efficacité d’un projet collectif. Les engagements prennent effet lorsque suffisamment de personnes sont mobilisées.</p>
				</div>
			</div>

			<div class="index__how">
				<div class="titre">
					<a href="about.php"><h2>COMMENT ÇA MARCHE?</h2></a>
				</div>
				<div class="index__how__container">
					<div>
							<p>1 - Adopte un projet<img style="vertical-align:middle" src="/images/cree.png" width="90px" height="50px" alt="logo"/></p>
					</div>
					<div>
							<p>2 - Choisi une action<img style="vertical-align:middle" src="images/mot.png" width="90px" height="50px" alt="logo"/></p>
					</div>
					<div>
							<p>3 - Fais passer le mot!<img style="vertical-align:middle" src="images/debat.png" width="80px" height="50px" alt="logo"/></p>
					</div>
					<div id="exemple">
						<a href="https://wikiaction.org/projet.php?project=nettoyer-le-parc-mont-royal-de-ses-dechets" class="button button--big">EXEMPLE DE PROJET</a>
					</div>
				</div>
			</div>

			<div class="index__graph">
					<div class="titre">
							<b>PROJETS COLLECTIFS EN GESTATION</b>
					</div>
					<div id="graph" class="index__graph__container">
						<script type="text/javascript" src="js/bubble_plot.js"></script>
					</div>
					<div class="index__graph__buttons">
						<a href="recherche.php" class="button button--big">RECHERCHER</a>
						<a href="login.php" class="button button--big">CRÉER</a>
					</div>
			</div>

		</div>
		<div class="push"></div>
	</div>

	<footer>
		<?php require_once "common/footer.php";?>
	</footer>

</body>

</html>
