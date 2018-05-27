<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
?><!DOCTYPE html>

<html>

<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
	<link rel="icon" type="image/png" href="favicon.png" />
	<link rel="stylesheet" type="text/css" href="temp/styles/styles.css"/>
	<script type="text/javascript" src="js/sign-in.js"></script>
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
</head>

<body>
<?php require_once "common/css_menu.php";?>

	<div class="container">
		<div id="top_space"></div>
		<div class="sign-in__container">
			<form action="create_user.php" method="post">
				<div>
					<input id="psd" name="psd" placeholder="pseudo" onkeyup="check_pseudo_availability()" type="text" required>
				</div>
				<div>
					<input id="mail" name="mail" placeholder="email" type="text" onkeyup="valid_mail()" required>
				</div>
				<div>
					<input id="pass1" name="pass1" placeholder="mot de passe" type="password" onkeyup="checkPass();" required>
				</div>
				<div>
					<input id="pass2" name="pass2" placeholder="confirmez votre mot de passe" type="password" onkeyup="checkPass(); return false;" required>
				</div>
				<div>
					<input id="submit" type="submit" class="button big" value="CRÉER" disabled>
				</div>

			</form>
		</div>

		<div class="push"></div>
	</div>

	<footer>
		<?php require_once "common/footer.php";?>
	</footer>

</body>

</html>
