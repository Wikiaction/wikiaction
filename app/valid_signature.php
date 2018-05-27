<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION)) {
	session_start();
}
include 'common/secretInfo.php';
require_once "common_tasks/redirect_unlogged.php";
require_once ('Mail.php');
require_once("Mail/mime.php");
//var_dump($_POST);
//on extraie toutes les actions liees au projet choisit
include 'common/dbase_connect.php';
$sthandler = $dbhandler->prepare('SELECT * FROM action_table WHERE url_project_name=:name');
$sthandler->bindParam(':name', $_POST['project_name']);
$sthandler->execute();
$action = $sthandler->fetchAll();
$sthandler = $dbhandler->prepare('SELECT * FROM projet_base WHERE url_projet_name=:name');
$sthandler->bindParam(':name', $_POST['project_name']);
$sthandler->execute();
$projet = $sthandler->fetchAll();
$status = array();
$count_sign = 0;
$count_already_signed = 0;
$hash_confirm = str_replace(array('+','.','=','/'),"", base64_encode(mcrypt_create_iv(17,MCRYPT_DEV_URANDOM)));
$valid_sign = 0;
for($i=0;$i<$_POST["nb_act"];$i++){
	$signed = 0;
	if(isset($_POST[$i])){ //on teste si l'action concernée est signée
		$count_sign += 1;
		$status[$count_sign - 1] = array( $_POST[$i] , 0, "");
		$j = 0;
		while($j<$_POST["nb_act"]){ //on va chercher l'actions correspondant
			if($action[$j]["act_ref"] == $_POST[$i]){
				$new_subs = $action[$j]["nb_subscribed"] + 1; //on ajoute une signature
				$status[$count_sign - 1][2] =  $action[$j]["nom_act"];
				break;
			} else {
				$j++;
			}
		}
		//on vérifie si la signature existe déjà pour ce mail
		$sthandler = $dbhandler->prepare('SELECT * FROM engagement_base WHERE mail=:email AND ref_act=:rf_act');
		$sthandler->bindParam(':email', $_SESSION['mail']);
		$sthandler->bindParam(':rf_act', $_POST[$i]);
		$sthandler->execute();
		$existing_signature = $sthandler->fetchAll();
		if($sthandler->rowCount() > 0){ // une signature existe déjà
			$signed = 1;
			if($existing_signature[0]["need_valid"] == 1){// means already signed but waiting for confirm so we backup then delete the existing signatures and replace it by the new one
				$sthandler = $dbhandler->prepare('INSERT INTO engagement_base_save SELECT * FROM engagement_base WHERE mail=:email AND ref_act=:rf_act');
				$sthandler->bindParam(':email', $_SESSION['mail']);
				$sthandler->bindParam(':rf_act', $_POST[$i]);
				$sthandler->execute();
				$sthandler = $dbhandler->prepare('DELETE FROM engagement_base WHERE mail=:email AND ref_act=:rf_act');
				$sthandler->bindParam(':email', $_SESSION['mail']);
				$sthandler->bindParam(':rf_act', $_POST[$i]);
				$sthandler->execute();
				$status[$count_sign - 1][1] = 2;
				$signed = 0;
				$valid_sign += 1;
			} else { //la signature existe déjà et est valide
				$status[$count_sign - 1][1] = 1;
				$count_already_signed += 1;
			}
		} else {
			$valid_sign += 1;
		}
		if ($signed == 0) { //pas encore signé ou signature non validée supprimée
			//$sthandler = $dbhandler->prepare('UPDATE action_table SET nb_subscribed = :nb_subs WHERE act_ref=:ref');
			//if($status[$count_sign - 1][1] == 2){
			//	$new_subs -= 1;
			//	$sthandler->bindParam(':nb_subs', $new_subs);
			//	$status[$count_sign - 1][1] = 0;
			//} else {
			//	$sthandler->bindParam(':nb_subs', $new_subs);
			//}
			//$sthandler->bindParam(':ref', $_POST[$i]);
			//$sthandler->execute();
			//RESTE A AJOUTER UNE LIGNE DANS LA BASE DES SIGNATURES ET  EMPECHER SI LA PERSONNE A DEJA SIGNE
			$sthandler = $dbhandler->prepare('INSERT INTO engagement_base (ref_act,url_project_name,nom_act,nom,mail,date_creation,hash_valid) VALUE (:ref_act,:url_project_name,:nom_act,:nom,:mail,:datetime,:hash_validation)');
			$sthandler->bindParam(':ref_act', $_POST[$i]);
			$sthandler->bindParam(':url_project_name', $_POST['project_name']);
			$sthandler->bindParam(':nom_act', $status[$count_sign - 1][2]);
			$sthandler->bindParam(':nom', $_POST['pseudo']);
			$sthandler->bindParam(':mail', $_SESSION['mail']);
			$crt_date = date("Y-m-d H:i:s");
			$sthandler->bindParam(':datetime', $crt_date);
			$sthandler->bindParam(':hash_validation', $hash_confirm);
			$sthandler->execute();
		}
	}
}
if ($valid_sign > 0){
	$dbhandler = null;
	$from = '"contact wikiaction" <contact@wikiaction.org>';
	$to = '<'.$_SESSION['mail'].'>';
	$subject = "Signature du projet: ". $projet[0]["titre_projet"];
	//$body = "Bonjour,<br><br>Merci de votre engagement.<br>Nous vous tiendrons informé de l'avancement du projet.<br><br>L'équipe de Wikiaction";
	$body = "Bonjour, <br> Merci de vous être engagé à agir pour le projet: " . $projet[0]["titre_projet"] .".";
	if ($valid_sign > 0){
		if ($valid_sign == 0){
			$body .= "<br>L'engagement pour l'action suivante a été enregistré:";
		} else {
			$body .= "<br>L'engagement pour les actions suivantes a été enregistré:";
		}
		for ($i=0;$i<count($status);$i++){
			if($status[$i][1] == 0){
				$body .= "<br>-". $status[$i][2];
			}
		}
	} else {
		$body .= "<br>L'engagement pour l'action \"".$status[0][2] ."\" a été enregistré";
	}
	$body .= "<br><br>Confirmez votre engagement à agir en cliquant sur le lien suivant ou en le copiant dans votre navigateur:<br> https://www.wikiaction.org/confirm_sign.php?email=".$_SESSION['mail']."&ref=".$hash_confirm;
	if ($count_sign - $valid_sign == 1){
		$body .= "<br><br>L'engagement pour l'action \"" . $status[0][2] . "\" n'a pas été pris en compte car une signature a déjà été validée avec cette adresse mail.";
	} else if (($count_sign - $valid_sign) > 1) {
		$body .= "<br><br>L'engagement pour les actions suivantes n'a pas été pris en compte car une signature a déjà été validée avec cette adresse mail:";
		for ($i=0;$i<count($status);$i++){
			if($status[$i][1] == 1){
				$body .= "<br>-". $status[$i][2];
			}
		}
	}
	$body .= "<br><br>L'équipe de Wikiaction";
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
	} else {
		header("Location: projet.php?project=".$_POST['project_name']."&message=signed");
	}
} else if ($count_sign == 0) { //pas d'action selectionnée
	header("Location: projet.php?project=".$_POST['project_name']."&message=signed_no_action");
} else if ($count_already_signed > 0) {//pas de signature valide car déjà signés
	header("Location: projet.php?project=".$_POST['project_name']."&message=signed_already");
}
?>
