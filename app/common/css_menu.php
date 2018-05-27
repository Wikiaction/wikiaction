<?php
if(!isset($_SESSION)) {
	session_start();
}
if(!isset($_SESSION['logged'])){
	$logged = 0;
} else {
	$logged = 1;
}
if(isset($_SERVER['HTTP_USER_AGENT'])){
	$useragent=$_SERVER['HTTP_USER_AGENT'];
} else {
	$useragent="";
}
if(isset($_SERVER['REQUEST_URI'])){
	$previous = $_SERVER['REQUEST_URI'];
} else {
	$previous = "wikiaction.org";
}
$previous_2 = str_replace("www.","m.",$_SERVER['HTTP_HOST'] . $previous);


$to_print = "<div class=\"header\">
<div class=\"header__menu\">
<div class=\"header__logo\"><a href=\"index.php\"><span><img src=\"images/wikilogoblue.png\" width=\"210px\" height=\"43px\" .top=\"0\" alt=\"logo of Wikiaction\"/></span></a></div>
<ul>
<li><a href=\"";
if($logged){
	$to_print .= "logout.php";
} else {
	$to_print .= "login.php";
}
$to_print .= "\"><b>";
if($logged){
	$to_print .= "deconnexion";
} else {
	$to_print .= "connexion";
}
$to_print .= "</b></a>";
if($logged){
	$to_print .= "<li><a href=\"myaccount.php\"><b>mes projets</b></a>";
}
$to_print .= "<li><a href=\"create.php\"><b>créer</b></a>
<li><a href=\"recherche.php\"><b>rechercher</b></a>
</ul></div>";

$to_print .= "</div>";
echo $to_print;
?>
