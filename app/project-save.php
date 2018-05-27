<?php

//var_dump($_POST);
error_reporting(E_ALL);
if(!isset($_SESSION)) {
	session_start();
}
include 'common/secretInfo.php';
require_once "common_tasks/redirect_unlogged.php";
require_once('hyphenize.php');
require_once ('Mail.php');
require_once("Mail/mime.php");
ini_set("display_errors", 1);
include 'common/dbase_connect.php';
$dbhandler -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
//$sthandler = $dbhandler->prepare('INSERT INTO projet_base (url_projet_name) VALUE (:name_unique)');
$sthandler = $dbhandler->prepare('INSERT INTO projet_base (url_projet_name , titre_projet , nb_engage , descr_sol , descr_prob , debut_period_project , fin_period_project , seuil_unit_engagement , createur , date_creation , confirmed_by_author , hash_confirm , project_descr , actions_descr) VALUES (:name_unique , :name , 0 , :descr_sol , :descr_prob , :debut_period_project , :fin_period_project , :seuil_unit_engagement , :createur , :date_creation , 1 , :hash_conf , :project_descr_var , :actions_descr_var)');
$project_url = hyphenize($_POST['titre_projet']);
$sthandler->bindParam(':name_unique', $project_url);
$sthandler->bindParam(':name',$_POST['titre_projet']);
$descr_project = str_replace(array("\r\n", "\r", "\n"), "",$_POST['descr_sol']);
$sthandler->bindParam(':descr_sol',$descr_project);
$descr_prob = str_replace(array("\r\n", "\r", "\n"), "",$_POST['descr_prob']);
$sthandler->bindParam(':descr_prob',$descr_prob);
$sthandler->bindParam(':debut_period_project',$_POST['debut_period_project']);
$sthandler->bindParam(':fin_period_project',$_POST['fin_period_project']);
$limit_tot = 0;
for($i = 0 ; $i < $_POST['nbre_act'] ; $i++){
	$limit_tot += intval($_POST['action_' . $i . '__seuil_act']);
}
$sthandler->bindParam(':seuil_unit_engagement',$limit_tot);
$sthandler->bindParam(':createur',$_SESSION['userID']);
$sthandler->bindParam(':project_descr_var',$_POST['projet_descr_str']);
$sthandler->bindParam(':actions_descr_var',$_POST['actions_descr_str']);
$hash_confirm = str_replace(array('+','.','=','/'),"", base64_encode(mcrypt_create_iv(17,MCRYPT_DEV_URANDOM)));
$sthandler->bindParam(':hash_conf',$hash_confirm);
$t=time();
$sthandler->bindParam(':date_creation',date("Y-m-d",$t));
$sthandler->execute();
for($i = 0 ; $i < $_POST['nbre_act'] ; $i++){
	$sthandlers = $dbhandler->prepare('INSERT INTO action_table (url_project_name , nom_act , descr_act , seuil_act , seuil_limit , temporalite_action , list_jours_actions , start_period_action , end_period_action , seuil_contraignant , act_independante , date_creation , nb_subscribed) VALUE (:name_unique , :nom_act , :descr_action , :seuil_action , :seuil_limit , :temporalite_action , :list_jours_action , :start_period_action , :end_period_action , :seuil_contraignant , :act_independante , :date_creation , :nb_subscribed)');
	$sthandlers->bindParam(':name_unique', hyphenize($_POST['titre_projet']));
	$sthandlers->bindParam(':nom_act',$_POST['action_' . $i . '__nom_act']);
	$sthandlers->bindParam(':descr_action',$_POST['action_' . $i . '__descr_act']);
	$sthandlers->bindParam(':seuil_action',$_POST['action_' . $i . '__seuil_act']);
	$sthandlers->bindParam(':seuil_limit',$_POST['action_' . $i . '__seuil_limit']);
	$sthandlers->bindParam(':temporalite_action',$_POST['action_' . $i . '__temporalite_action']);
	$a = 'action_' . $i . '__list_jours_action';
	if(isset($_POST[$a])){
		$sthandlers->bindParam(':list_jours_action',$_POST['action_' . $i . '__list_jours_action']);
	} else {
		$sthandlers->bindValue(':list_jours_action', 'na');
	}
	if($_POST['action_' . $i . '__temporalite_action']== 0){
		if($_POST['action_' . $i . '__start_period_action']== "2010-01-01"){
			$sthandlers->bindParam(':start_period_action',$_POST['debut_period_project']);
		} else {
			$sthandlers->bindParam(':start_period_action',$_POST['action_' . $i . '__start_period_action']);
		}
		if($_POST['action_' . $i . '__end_period_action']== "2010-01-01"){
			$sthandlers->bindParam(':end_period_action',$_POST['fin_period_project']);
		} else {
			$sthandlers->bindParam(':end_period_action',$_POST['action_' . $i . '__end_period_action']);
		}
	} else {
		$sthandlers->bindValue(':start_period_action', $_POST['debut_period_project']);
		$sthandlers->bindValue(':end_period_action', $_POST['fin_period_project']);
	}
	$sthandlers->bindParam(':seuil_contraignant',$_POST['action_' . $i . '__seuil_contraignant']);
	if(isset($_POST['action_' . $i . '__act_independante'])){
		$sthandlers->bindParam(':act_independante',$_POST['action_' . $i . '__act_independante']);
	} else {
		$sthandlers->bindValue(':act_independante', 0);
	}
	$sthandlers->bindParam(':date_creation',date("Y-m-d",$t));
	$sthandlers->bindValue(':nb_subscribed',0);
	$a = $sthandlers->execute();
	if (!$a) {
		echo "\nPDO::errorInfo():\n";
		print_r($sthandlers->errorInfo());
	}

}
$from = '"contact wikiaction" <contact@wikiaction.org>';
$to = '<'.$_SESSION['mail'].'>';
$subject = "Confirmation du projet: ". $_POST['titre_projet'];
//$body = "Bonjour,\n\nMerci de votre engagement.\nNous vous tiendrons informé de l'avancement du projet.\n\nL'équipe de Wikiaction";
//$body = "Bonjour,\n\nMerci de votre engagement.\nNous vous tiendrons informé de l'avancement du projet: " . $_POST['titre_projet'] . ".\nAfin de confirmer la création du contrat, merci de cliquer sur le lien suivant ou de le copier dans votre navigateur: http://www.wikiaction.org/confirm_project.php?email=".$_POST['email']."&ref=".$hash_confirm."\n\nL'équipe de Wikiaction";
$body = "Bonjour,<br>\n<br>\nMerci de votre engagement.<br>\nNous vous tiendrons informé de l'avancement du projet: " . $_POST['titre_projet'] . ".<br>\nVous pouvez accéder la page de présentation de votre projet en cliqunt sur le lien suivant ou en le copiant dans votre navigateur: https://www.wikiaction.org/projet.php?project=".$project_url."<br>\n<br>\nL'équipe de Wikiaction";
$body = wordwrap($body, 70, "\r\n");

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
} else {
    header("Location: projet.php?project=".hyphenize($_POST['titre_projet'])."&message=created");
}
header("Location: projet.php?project=".hyphenize($_POST['titre_projet'])."&message=created");
?>
