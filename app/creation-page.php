<?php
error_reporting(E_ALL);
if(!isset($_SESSION)) {
	session_start();
}
require_once "common_tasks/redirect_unlogged.php";
?><!DOCTYPE html>

<html>

<head>
	<link rel="icon" type="image/png" href="favicon.png" />
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
	<title>Wikiaction.org</title>
	<link rel="stylesheet" type="text/css" href="css/background.css"/>
	<link rel="stylesheet" type="text/css" href="css/creation-page.css"/>
	<link rel="stylesheet" type="text/css" href="css/progressbar.css"/>
	<script type="text/javascript"><?php echo 'var form_target = "project-save.php";';?></script>
	<script type="text/javascript" src="js/creation-wizard.js"></script>
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript"><?php echo 'var today_date = "' . date("Y-m-d") . '";';?></script>
	<script type ="text/javascript" src='js/tinymce/tinymce.min.js'></script>
</head>

<body onload="show_step();">

	<?php require_once "common/css_menu.php";?>

	<div class="container">
	<div id="top_space"></div>
		<div id="question">
			<h2></h2>
		</div>

		<div id="container2">

			<!-- <div style="display:table;width:100%;">
  		<div style="display:table-cell;vertical-align:middle;">
    <div style="margin-left:auto;margin-right:auto;"></div>
  </div>
</div> -->

			<div id="prev">
					<!-- <a id="nav-prev" onclick="prev_step();wa_Progress_bar()" class="button prev" style="visibility:hidden"></a> -->
					<a id="nav-prev" onclick="prev_step();wa_Progress_bar()" class="arrow"></a>
			</div>

			<div id="answer_div" class="form text"></div>

			<div id="next">
					<a id="nav-next" onclick="next_step();wa_Progress_bar()" class="arrow"></a>
			</div>

		</div>

		<div id="waProgress">
			 <div id="waBar"></div>
		</div>
		
		<div id="waProgressAction">
			 <div id="waBarAction"></div>
		</div>

		<div id="table_div">

				<table>
						<tr>
							<th>Projet</th>
							<td><p onclick="edit_project()" style="font-color: blue; text-decoration: underline; cursor: pointer;">Éditer</p></td>
						</tr>
				</table>

				<table>
					<thead>
						<tr>
						<th>Actions   <button type="button" onclick="save_data();add_action();show_step();refresh_links();">Ajouter une action</button></th>
						</tr>
					</thead>
					<tbody id="case_lien_actions">
					</tbody>
				</table>

		</div>

	<div class="push"></div>
	</div>

	<footer>
		<?php require_once "common/footer.php";?>
	</footer>

</body>

</html>
