<?php
if(!isset($_SESSION)) {
	session_start(); 
}
include 'common/secretInfo.php';
require_once ('Mail.php');
require_once("Mail/mime.php");
//var_dump($_POST);
include 'pass_functions.php';
include 'common/dbase_connect.php';
$sthandler = $dbhandler->prepare('SELECT * FROM comptes_utilisateurs WHERE pseudo=:pseudo');
$sthandler->bindParam(':pseudo',$_POST['psd']);
$sthandler->execute();
if($sthandler->rowCount() > 0){
	$valid_pseudo =  false;
}else{
	$valid_pseudo =  true;
}
$sthandler = $dbhandler->prepare('SELECT * FROM comptes_utilisateurs WHERE email=:mail');
$sthandler->bindParam(':mail', $_POST['mail']);
$sthandler->execute();
if($sthandler->rowCount() > 0){
	$valid_email =  false;
}else{
	$valid_email =  true;
}
$dbhandler = null;

if(!$valid_email  ||  !$valid_pseudo){
	//echo "FALSE";
	session_destroy();
	header('Location: sign-in.php');
} else {
	//echo "avant requete";
	//echo generate_hash($_POST['pass1']);
	include 'common/dbase_connect.php';
	$sthandler = $dbhandler->prepare('INSERT INTO comptes_utilisateurs (email,pseudo,hash,date_join,hash_confirm) VALUE (:email,:pseudo,:hash,:date_join,:hash_confirm)');
	$sthandler->bindParam(':email',$_POST['mail']);
	$sthandler->bindParam(':pseudo',$_POST['psd']);
	$sthandler->bindParam(':hash',generate_hash($_POST['pass1']));
	$sthandler->bindParam(':date_join',date("Y-m-d H:i:s"));
	$hash_confirm = str_replace(array('+','.','=','/'),"", base64_encode(mcrypt_create_iv(17,MCRYPT_DEV_URANDOM)));
	$sthandler->bindParam(':hash_confirm',$hash_confirm);
	$sthandler->execute();
	$dbhandler = null;
	$from = '"contact wikiaction" <contact@wikiaction.org>';
	$to = '<'.$_POST['mail'].'>';
	$subject = "Confirmation de compte";
	//$body = "Bonjour,<br><br>Merci de votre engagement.<br>Nous vous tiendrons informé de l'avancement du projet.<br><br>L'équipe de Wikiaction";
	$body = "Bonjour,<br><br>Merci d'avoir créé un compte sur Wikiaction.org!<br>Avant de pouvoir éditer vos projets, merci de confirmer la création de votre compte en cliquant sur le lien suivant ou en le copiant dans votre navigateur: https://dev.wikiaction.org/confirm_account.php?email=".$_POST['mail']."&ref=".$hash_confirm."<br><br>L'équipe de Wikiaction";
	// $body = wordwrap($body, 70, "\r<br>");
	$headers = array(
		'From' => $from,
		'To' => $to,
		'Subject' => $subject
	);
	$mimeparams=array();
	$mimeparams['text_encoding']="7bit";
	$mimeparams['text_charset']="UTF-8";
	$mimeparams['html_charset']="UTF-8";
	$mimeparams['head_charset']="UTF-8";
	$message = new Mail_mime();
	$message->setHTMLBody($body);
	$body = $message->get($mimeparams);
	$headers = $message->headers($headers);
	$smtp = Mail::factory('smtp', array(
			'host' => MAILER_HOST,
			'port' => MAILER_PORT,
			'auth' => MAILER_AUTH,
			'username' => MAILER_USRNAME,
			'password' => MAILER_PWD
		));
	$couriel = $smtp->send($to, $headers, $body);
	if (PEAR::isError($couriel)) {
		echo('<p>' . $couriel->getMessage() . '</p>');
	}
	header("Location: confirm.php?action=create_account&status=valid");
}
?>
