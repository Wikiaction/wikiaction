function change_title_1(){
	document.getElementById('header1').innerHTML = "<form action='update_title.php' method='get'><input name='project' type='hidden' value = " + project_url + "><input name='new_title_1' type = 'text' placeholder ='Entrez votre texte'><input type='submit' value='Submit'></form>";
}

function change_title_2(){
	document.getElementById('header2').innerHTML = "<form action='update_title.php' method='get'><input name='project' type='hidden' value = " + project_url + "><input name='new_title_2' type = 'text' placeholder ='Entrez votre texte'><input type='submit' value='Submit'></form>";
}