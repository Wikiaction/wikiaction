<?php

//var_dump($_POST);
error_reporting(E_ALL);
if(!isset($_SESSION)) {
	session_start();
}
include 'common/secretInfo.php';
require_once "common_tasks/redirect_unlogged.php";
//var_dump($_POST);
error_reporting(E_ALL);
require_once('hyphenize.php');
require_once ('Mail.php');
require_once("Mail/mime.php");
ini_set("display_errors", 1);

//on sauvegarde les anciennes lignes
include 'common/dbase_connect.php';
$sthandler = $dbhandler->prepare('INSERT INTO projet_base_save SELECT * FROM projet_base WHERE url_projet_name = :name_initial');
$sthandler->bindParam(':name_initial', $_POST['init_name']);
$sthandler->execute();
$sthandler = $dbhandler->prepare('INSERT INTO action_table_save SELECT * FROM action_table WHERE url_project_name = :name_initial');
$sthandler->bindParam(':name_initial', $_POST['init_name']);
$sthandler->execute();
//on extraie les actions existantes
$sthandler = $dbhandler->prepare('SELECT * FROM action_table WHERE url_project_name = :name_initial');
$sthandler->bindParam(':name_initial', $_POST['init_name']);
$sthandler->execute();
$action_data = $sthandler->fetchAll();
//on update les enregistrements du projet_base
$sthandler = $dbhandler->prepare('UPDATE projet_base SET url_projet_name = :name_unique , titre_projet = :name , descr_sol = :descr_sol, descr_prob = :descr_prob , debut_period_project = :debut_period_project , fin_period_project = :fin_period_project , seuil_unit_engagement = :seuil_unit_engagement , createur = :createur, confirmed_by_author = :value, hash_confirm = :hash_conf, project_descr = :project_descr_var , actions_descr = :actions_descr_var WHERE url_projet_name = :name_initial');
$sthandler->bindParam(':name_initial', $_POST['init_name']);
$project_url = hyphenize($_POST['titre_projet']);
$sthandler->bindParam(':name_unique', $project_url);
$sthandler->bindParam(':name',$_POST['titre_projet']);
$sthandler->bindParam(':descr_sol',$_POST['descr_sol']);
$sthandler->bindParam(':descr_prob',$_POST['descr_prob']);
$sthandler->bindParam(':debut_period_project',$_POST['debut_period_project']);
$sthandler->bindParam(':fin_period_project',$_POST['fin_period_project']);
$limit_tot = 0;
for($i = 0 ; $i < $_POST['nbre_act'] ; $i++){
	$limit_tot += intval($_POST['action_' . $i . '__seuil_act']);
}
$sthandler->bindParam(':seuil_unit_engagement',$limit_tot);
$sthandler->bindValue(':value', 1);
$sthandler->bindParam(':createur',$_SESSION['userID']);
$sthandler->bindParam(':project_descr_var',$_POST['projet_descr_str']);
$sthandler->bindParam(':actions_descr_var',$_POST['actions_descr_str']);
$hash_confirm = str_replace(array('+','.','=','/'),"", base64_encode(mcrypt_create_iv(17,MCRYPT_DEV_URANDOM)));
$sthandler->bindParam(':hash_conf',$hash_confirm);
$sthandler->execute();
//on update les enregistrements des actions
$init_action_list = array();
foreach($action_data as $action){
	 $init_action_list[$action["act_ref"]] = 0;
}
var_dump($init_action_list);
for($i = 0 ; $i < $_POST['nbre_act'] ; $i++){
	if(isset($_POST["action_ref_". $i])){
		$init_action_list[$_POST["action_ref_". $i]] = 1;
		$sthandlers = $dbhandler->prepare('UPDATE action_table SET url_project_name =:name_unique , nom_act =:nom_act , descr_act =:descr_action , seuil_act =:seuil_action , seuil_limit =:seuil_limit , temporalite_action =:temporalite_action , list_jours_actions =:list_jours_action , start_period_action =:start_period_action , end_period_action =:end_period_action , seuil_contraignant =:seuil_contraignant , act_independante =:act_independante WHERE act_ref =:ref');
		$sthandlers->bindParam(':name_unique', hyphenize($_POST['titre_projet']));
		$sthandlers->bindParam(':nom_act',$_POST['action_' . $i . '__nom_act']);
		$sthandlers->bindParam(':descr_action',$_POST['action_' . $i . '__descr_act']);
		$sthandlers->bindParam(':seuil_action',$_POST['action_' . $i . '__seuil_act']);
		$sthandlers->bindParam(':seuil_limit',$_POST['action_' . $i . '__seuil_limit']);
		$sthandlers->bindParam(':temporalite_action',$_POST['action_' . $i . '__temporalite_action']);
		$sthandlers->bindParam(':ref',$_POST["action_ref_". $i ]);
		$a = 'action_' . $i . '__list_jours_action';
		if(isset($_POST[$a])){
			$sthandlers->bindParam(':list_jours_action',$_POST['action_' . $i . '__list_jours_action']);
		} else {
			$sthandlers->bindValue(':list_jours_action', 'na');
		}
		if($_POST['action_' . $i . '__temporalite_action'] == 0){
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
		$a = $sthandlers->execute();
		if (!$a) {
			echo "\nPDO::errorInfo():\n";
			print_r($sthandlers->errorInfo());
		}
	} else {
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
		if($_POST['action_' . $i . '__temporalite_action'] == 0){
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
		$t=time();
		$sthandlers->bindParam(':date_creation',date("Y-m-d",$t));
		$sthandlers->bindValue(':nb_subscribed',0);
		$a = $sthandlers->execute();
		if (!$a) {
			echo "\nPDO::errorInfo():\n";
			print_r($sthandlers->errorInfo());
		}
	}
}
var_dump($init_action_list);
// foreach($init_action_list as $key => $value){
// 	if($value == 0){
// 		$sthandler = $dbhandler->prepare('DELETE FROM action_table WHERE act_ref =:ref');
// 		$sthandler->bindParam(':ref', $key);
// 		$sthandler->execute();
// 	}
// }
$from = '"contact wikiaction" <contact@wikiaction.org>';
$to = '<'.$_SESSION['mail'].'>';
$subject = "Modification du projet: ". $_POST['titre_projet'];
//$body = "Bonjour,\n\nMerci de votre engagement.\nNous vous tiendrons informé de l'avancement du projet.\n\nL'équipe de Wikiaction";
//$body = "Bonjour,\n\nMerci de votre engagement.\nNous vous tiendrons informé de l'avancement du projet: " . $_POST['titre_projet'] . ".\nAfin de confirmer la création du contrat, merci de cliquer sur le lien suivant ou de le copier dans votre navigateur: http://www.wikiaction.org/confirm_project.php?email=".$_POST['email']."&ref=".$hash_confirm."\n\nL'équipe de Wikiaction";
$body = "Bonjour,<br>\n<br>\nMerci d'avoir mis à jour votre projet.<br>\nNous continuerons de vous tenir informé de l'avancement du projet: " . $_POST['titre_projet'] . ".<br>\nLes modifications que vous avez apporté seront mises en ligne après modération de notre part.<br>\nVous pouvez accéder la page de présentation de votre projet en cliqunt sur le lien suivant ou en le copiant dans votre navigateur: https://www.wikiaction.org/projet.php?project=".$project_url."<br>\n<br>\nL'équipe de Wikiaction";
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
    header("Location: projet.php?project=".hyphenize($_POST['titre_projet'])."&message=modif");
}
header("Location: projet.php?project=".hyphenize($_POST['titre_projet'])."&message=modif");
?>
