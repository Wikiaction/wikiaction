<!DOCTYPE html>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
if(isset($_SESSION['logged'])){
	require_once('hyphenize.php');
	header("Location: myaccount.php");
	exit();
} else {
	session_destroy();
}
?>

<html>

<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
	<link rel="icon" type="image/png" href="favicon.png" />
	<link rel="stylesheet" type="text/css" href="temp/styles/styles.css"/>
	<script type="text/javascript" src="scripts/jquery-1.11.3.min.js"></script>
	<script type="text/javascript">
	<?php
	if (isset($_GET["referer"])){
		$string_url = $_GET["url"];
		if($_GET["referer"] == "get"){
			$string_url .= "?";
			foreach($_GET as $key => $value){
				if($key == "referer" or $key == "url"){
					continue;
				} else {
					$string_url .= $key . "=" . $value . "&";
				}
			}
			echo 'var referer = "' . $string_url .'";';
		} else if ($_GET["referer"] == "url") {
			echo 'var referer = "' . $_GET["url"] . '";';
		} else {
			echo 'var referer = "";';
		}
	} else {
		echo 'var referer = "";';
	}
	?>
	</script>
	<script type="text/javascript" src="js/login.js"></script>
</head>

	<body>
	<?php require_once "common/css_menu.php";?>

	<div class="container">	
		<div id="top_space"></div>
		<div class="login__container">
			<div>
				<input id="psd" class="login__pseudo" placeholder="pseudo" type="text" required>
			</div>
			<div>
				<input id="psswd" class="login__password" placeholder="mot de passe" type="password" required>
			</div>
			<div>
				<input type="button" id="connection" onclick="check_creds()" value="CONNEXION" class="button big">
			</div>
			<div>
				<a id="sign_in" href="sign-in.php" class="button big">CRÉER UN COMPTE</a>
			</div>
		</div>
	</div>
	<script>
		$("#psswd").keyup(function(event){
			if(event.keyCode == 13){
					$("#sign_in").click();
			}
	});
	</script>

	<footer>
		<?php require_once "common/footer.php";?>
	</footer>

</body>
</html>
