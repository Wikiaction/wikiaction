<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
if(!isset($_SESSION)) {
	session_start();
}
if(!isset($_SESSION['logged'])){
	session_destroy();
}
include 'common/dbase_connect.php';

if (isset($_GET['sort']) && $_GET['sort'] == 'c'){
	$sthandler = $dbhandler->prepare('SELECT * FROM posts WHERE post_topic = :topic ORDER BY thread_id, post_level, sort_order');
	$sthandler->bindValue(':topic', $_GET['project']);
	$sthandler->execute();
	$result = $sthandler->fetchAll();
}
elseif (isset($_GET['sort']) && $_GET['sort'] == 'v') {
	$sthandler = $dbhandler->prepare('SELECT * FROM posts WHERE post_topic = :topic ORDER BY post_level ASC, ups DESC');
	$sthandler->bindValue(':topic', $_GET['project']);
	$sthandler->execute();
	$result = $sthandler->fetchAll();
}

$sthandler = $dbhandler->prepare('SELECT * FROM projet_base WHERE ID=:id');
$sthandler->bindParam(':id', $_GET['project']);
$sthandler->execute();
$project_info = $sthandler->fetchAll();
$title = $project_info[0]["titre_projet"];

if(isset($_SESSION['mail'])){
	$sthandler = $dbhandler->prepare('SELECT * FROM votes WHERE user_id = :user');
	$sthandler->bindValue(':user', $_SESSION['pseudo']);
	$sthandler->execute();
	$user_vote = $sthandler->fetchAll();
	$creator = $_SESSION['pseudo'];
}
$project= $_GET['project'];

?><!DOCTYPE html>

<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
	<title>Wikiaction.org</title>
	<link rel="icon" type="image/png" href="favicon.png" />
	<link rel="stylesheet" type="text/css" href="css/background.css"/>
	<link rel="stylesheet" type="text/css" href="css/debate.css"/>
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="js/debate.js"></script>
</head>

<body>

<?php require_once "common/css_menu.php"; ?>

<div class="container">

<div id="top_space"></div>

<div><h1> Page de débat du projet: <?php echo $title ?> </h1></div>
<br>

<?php
	if(isset($_SESSION['mail'])){
		echo "<div id='mainform'>";
		echo "<form action='new_thread.php' id='new_thread' method='get'>
					<input name='reply_id' type='hidden' value = 0>";
		echo "<input name='project' type='hidden' value ='$project'>
					<input name='post_by' type='hidden' value ='$creator'>";
		echo "<!-- Name: <input type='text' name='usrname'> -->
					<textarea placeholder='Enter text here...' rows='5' cols='60' maxlength='10000' name='content' form='new_thread'></textarea>
					<button class='button big'>Submit</button>
					</form>
					</div>";
	}
?>

<div id="sorting">
	<div id="SortByTimeButton"><a href="<?php echo "debate2.php?project=".$project."&sort=c"; ?>" class="button">Organiser ordre chronologique</a></div>
	<div id="SortByVoteButton"><a href="<?php echo "debate2.php?project=".$project."&sort=v"; ?>" class="button">Organiser par vote</a></div>
</div>

<br>

<div id="board">

</div>

 <!-- NEW VERSION OF POSTING IN JS -->
<script>

var TempResult= '<?php echo json_encode($result); ?>';
var result = JSON.parse(TempResult);

var TempUserInfo= '<?php echo json_encode($_SESSION); ?>';
var UserInfo = JSON.parse(TempUserInfo);

if (Object.keys(UserInfo).length > 0){
	var TempVote= '<?php if(isset($_SESSION['mail'])){echo json_encode($user_vote);} ?>';
	var UserVote = JSON.parse(TempVote);
}
else {
	var TempVote= '[]';
	var UserVote = JSON.parse(TempVote);
}


function printPost(post,vote_value = 0){
	var background_color;
	if (post.post_level%2 == 0){
		background_color = 'even';
	}
	else{
		background_color = 'odd';
	}

	var Score = Number(post.ups) - Number(post.downs);

	var upvote ='', downvote = '';
	if(vote_value == 1){
		var upvote = 'voted'
	}
	else if (vote_value == -1){
		var downvote = 'voted'
	}

	var post_content = '';
// PRINT THE ARROWS AND SCORE
	if(typeof UserInfo.mail != "undefined"){
		post_content += '<div class="voting">' +
		 '<div class="ups"><input class="arrowup '+ upvote +'" type="button" onclick="approve(' + post.post_id + ')"></div>' +
		 '<div class="score disapproved" style="display:none;"><p>' + (Score - 1)  + '</p></div>' +
		 '<div class="score neutral" style="display:block;"><p>' + Score + '</p></div>' +
		 '<div class="score approved" style="display:none;"><p>' + (Score + 1) + '</p></div>' +
		 '<div class="downs"><input class="arrowdown '+ downvote +'" type="button" onclick="disapprove(' + post.post_id + ')"></div>' +
		'</div>';
	}
	else {
		post_content += '<div class="voting">' +
			'<div class="ups"><input class="arrowup" type="button" onclick=""></div>' +
			'<div class="score neutral" style="display:block;"><p>' + Score + '</p></div>' +
			'<div class="downs"><input class="arrowdown" type="button" onclick=""></div>' +
			'</div>';
	}

	post_content += '<div class="content">' +
		'<p class="post-header">' +
		'<span class="user-id">' + post.post_by + '</span>' +
		'<span class="date">' + post.post_date + '</span>' +
		'<span class="score">' + Score + ' points </span>' +
		'<span class="post_id">post id:' + post.post_id + '</span>';
	if(post.edited == 1){
		post_content += '<span class="edited">edited</span>'+
		'</p>';
	}
	else{
		'</p>';
	}

// PRINT CONTENT OF POST

	post_content += '<div id="post_content_' + post.post_id + '" style="display: block">' +
		'<p>' + removeTags(post.post_content) + '</p>' +
		'</div>';

// IF IT'S THE USE POST ADD AN EDIT BUTTON
	if(UserInfo.pseudo == post.post_by){
		post_content += '<div class"edit-post">'+
			'<form id="edit_' +post.post_id +'" action="edit_post.php" method="get" style="display: none">'+
			'<input name="id" type="hidden" value ="' +post.post_id +'">'+
			'<input name="project" type="hidden" value ="' +post.post_topic +'">'+
			'<input name="post_by" type="hidden" value ="' +post.reply_by + '">'+
			'<textarea rows="4" cols="50" maxlength="10000" name="new_post" form="edit_' +post.post_id +'">'+post.post_content +'</textarea>'+
			'<button class="button">Submit</button>'+
			'<button class="button" onclick=hide_edit(\'edit_' +post.post_id +'\',\'post_content_' +post.post_id +'\')>Cancel</button>'+
			'</form>'+
			'</div>';
	}

// PRINT THE OPTIONS BUTTONS
	post_content += '<ul class="option-list">';
	if(typeof UserInfo.mail !== 'undefined'){
		if(UserInfo.pseudo == post.post_by){
			post_content +=
				'<li><a onclick="edit_content(\'edit_' + post.post_id +'\',\'post_content_' +post.post_id +'\')" class="button small">Editer</a></li>';
		}
		post_content += '<li><a onclick="reply_to_post(\'reply_' +post.post_id +'\')" class="button small"> Répondre</a></li>';
	}
	else{
		post_content += '<li><a onclick="" class="button small"> Répondre</a></li>';
	}
	post_content += '</ul>';

// PRINT THE REPLY FORM
	if(typeof UserInfo.mail !== 'undefined'){
		post_content += '<div class"edit-post">' +
			'<form id="edit_' + post.post_id + '" action="edit_post.php" method="get" style="display: none">' +
	 		'<input name="id" type="hidden" value ="' + post.post_id + '"> ' +
			'<input name="project" type="hidden" value ="' + post.post_topic + '">' +
			'<input name="post_by" type="hidden" value ="' + post.reply_by +  '">' +
			'<textarea rows="4" cols="50" maxlength="10000" name="new_post" form="edit_' + post.post_id + '">'+ post.post_content + '</textarea>' +
			'<button class="button">Submit</button>' +
			'<button class="button" onclick=hide_edit(\'edit_' + post.post_id + '\',\'post_content_' + post.post_id + '\')>Cancel</button>' +
			'</form>' +
	 		'</div>';
	}


if(post.thread_id == post.post_id){
	document.getElementById("board").innerHTML += '<div class="post '+ background_color +'" id="' + post.post_id + '">' +
	'</div>';
}
else{
	document.getElementById(post.parent_id).innerHTML += '<div class="post '+background_color+'" id="' + post.post_id + '">' +
	'</div>';
}

document.getElementById(post.post_id).innerHTML = post_content;
}
//
function getVoteByUser(post_id,pseudo){
	return UserVote.filter(
		function(UserVote){return UserVote.post_id == post_id && UserVote.user_id == pseudo;}
	);
}

for (k in result){
	if (Object.keys(UserInfo).length > 0){
		var UserVote = getVoteByUser(result[k].post_id, UserInfo.pseudo);
		if(typeof UserVote[0] != "undefined"){
			printPost(result[k],UserVote[0].vote_value);
		}
		else{
			printPost(result[k]);
		}
	}
	else{
		printPost(result[k]);
	}
	// document.getElementById("board").innerHTML += vote[0].vote_value;

	// printPost(result[k],1);
}
</script>






<!-- END OF THE NEW VERSION  -->


<div class="push"></div>
</div>
<!-- End of container -->

<footer>
	<?php require_once "common/footer.php";?>
</footer>

</body>


</html>
