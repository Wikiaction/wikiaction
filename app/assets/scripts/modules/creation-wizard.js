// removed from chain_project: 0 : {"Q" : "Première étape : l’incontournable adresse de courriel!" , "type" : "email" , "format" : "txt" , "max-size" : 100 , "list-choix" : {} , "next" : 1 , "title" : "email" , "placeholder" : "Entrez votre email."},


var chain_project = {1 : {"Q":"Décrivez le problème auquel vous voulez faire face" , "type" : "simple" , "format" : "txt_mce" , "max-size" : 2000 , "list-choix" : {} , "next" : 2 , "title" : "descr_prob" , "placeholder" : "Écrivez ici le problème auquel vous faite face"},
2 : {"Q" : "Expliquez comment l'engagement des autres peut résoudre le problème" , "type" : "simple" , "format" : "txt_mce" , "max-size" : 2000 , "list_choix" : {} , "next" : 2.2 , "title" : "descr_sol" , "placeholder" : "Décrivez ici la solution que vous proposez de mettre en place"},
2.2 : {"Q" : "Le projet collectif devrait entrer en action..." , "type" : "date" , "format" : "custom" , "list-choix" : {} , "next" : 2.3 , "title" : "debut_period_project"},
2.3 : {"Q" : "Mais il ne pourrait plus entrer en action après le..." , "type" : "date" , "format" : "custom" , "list-choix" : {} , "next" : 3 , "title" : "fin_period_project"},
3 : {"Q" : "Merci! Désormais nous passons à la création des actions du projet collectif!" , "type" : "simple" , "format" : "bouton" , "list-choix" : {} , "next" : 4 , "label" : "Créer ma première action", "title" : "void"},
13 : {"Q" : "La cerise sur le gâteau pour la fin : quel est le titre de votre projet?" , "type" : "text" , "format" : "txt" , "max-size" : 120 , "list-choix" : {} , "next" : "end" , "title" : "titre_projet" , "placeholder" : "L’objectif final de votre projet collectif!"}
}
var chain_action = {4 : {"Q" : "Quel serait le nom de l'action à suivre?" , "type" : "text" , "format" : "txt" , "max-size" : 120 , "list-choix" : {} , "next" : 5 , "title" : "nom_act" , "placeholder" : "Un conseil : mettez un verbe d’action!"},
5 : {"Q" : "En quoi consiste-t-elle?" , "type" : "simple" , "format" : "txt_mce" , "max-size" : 2000 , "list-choix" : {} , "next" : 6 , "title" : "descr_act" , "placeholder" : "Décrivez ici l'action que vous proposez"},
6 : {"Q" : "À partir de combien de personnes actives le projet deviendra efficace?" , "type" : "simple" , "format" : "int" , "max-size" : 8 , "list-choix" : {} , "next" : 7 , "title" : "seuil_act"},
7 : {"Q" : "Voulez-vous limiter le nombre d’engagés à ce seuil?" , "type" : "choix" , "format" : "list" , "list-choix" : {
	0 : "Non, plus on est mieux c'est!" ,
	1 : "Oui, plus de personnes ne rendraient pas le projet plus efficace"} ,
"next" : {
	0 : 8 ,
	1 : 8} , "title" : "seuil_limit"},
8 : {"Q" : "Cette action serait..." , "type" : "choix" , "format" : "list" , "list-choix" : {
	0 : "Ponctuelle (on n’agit qu’une fois)" ,
	1 : "Répétée" ,
	2 : "Permanente , tout au long du projet"} ,
"next" : {
	0 : 9.2 ,
	1 : 9.1 ,
	2 : 10} , "title" : "temporalite_action"},
9.1 : {"Q" : "Quels seraient les jours possibles d’action dans une semaine?" , "type" : "choix_mult" , "format" : "cases" , "list-choix" : {
	0 : "lundi" ,
	1 : "mardi" ,
	2 : "mercredi" ,
	3 : "jeudi" ,
	4 : "vendredi" ,
	5 : "samedi" ,
	6 : "dimanche"} ,
"next" : 10 , "title" : "list_jours_action"},
9.2 : {"Q" : "L’action commencerait..." , "type" : "periode" , "format" : "custom" , "list-choix" : {} , "next" : 9.3 , "title" : "start_period_action"},
9.3 : {"Q" : "L’action se terminerait..." , "type" : "periode" , "format" : "custom" , "list-choix" : {} , "next" : 10 , "title" : "end_period_action"},
10 : {"Q" : "Les engagés pourront-ils agir même si le seuil de l'action n’est pas franchi?" , "type" : "choix" , "format" : "list" , "list-choix" : {
	0 : "Non ça ne servirait à rien!" ,
	1 : "Oui" } ,
"next" : {
	0 : 12 ,
	1 : 11} , "title" : "seuil_contraignant"},
11 : {"Q" : "L'action peut-elle être menée à terme indépendament des autres?" , "type" : "choix" , "format" : "list" , "list-choix" : {
	0 : "Non pas vraiment..." ,
	1 : "Oui, pas de soucis!"} ,
"next" : {
	0 : 12 ,
	1 : 12} , "title" : "act_independante"} ,
12 : {"Q" : "Parfait! Voulez vous ajouter une autre action à votre projet?" , "type" : "choix" , "format" : "list" , "list-choix" : {
	0 : "Non ça devrait marcher comme ça!" ,
	1 : "Oui!"} ,
"next" : {
	0 : 4 ,
	1 : 13} , "title" : "void"}
};
if(typeof editing == 'undefined'){
	var position = 0;
	var position_list = [1];
	var projet_descr = {"nbre_act" : 0 , "position_list" : {}};
	var count_action = 0;
	var position_action = 0;
	var actions_descr = [];
	var projet_or_action = 0; //indique si on édite le projet ou une action, 0 pour projet, 1 pour action
	var next_q = 0;
};
var encodeHtmlEntity = function(str) {
  var buf = [];
  for (var i=str.length-1;i>=0;i--) {
    buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
  }
  return buf.join('');
};

var decodeHtmlEntity = function(str) {
  return str.replace(/&#(\d+);/g, function(match, dec) {
    return String.fromCharCode(dec);
  });
};


function show_step(){
	tinymce.remove();
	if(position_list[position] > 0 && position > 0){
		document.getElementById("nav-prev").style.visibility = "visible";
	} else {
		document.getElementById("nav-prev").style.visibility = "hidden";
	}
	if(position_list[position] < 13){
		document.getElementById("nav-next").style.visibility = "visible";
	} else {
		document.getElementById("nav-next").style.visibility = "hidden";
	}
	if (projet_or_action == 0){ //on se place dans le descriptif du projet
		document.getElementById("question").innerHTML = "<h2>" + chain_project[position_list[position]]["Q"] + "</h2>";
		if (position_list[position] == 3) {
			document.getElementById("answer_div").innerHTML = '<p>Vous pouvez en tout temps revenir sur l’edition du projet en cliquant sur « édition » du projet et/ou éditer ou suprimer vos actions ci-dessous</p>';
		} else if (position_list[position] == 13){ // cas de la dernière question
			if(chain_project[position_list[position]]["title"] in projet_descr){ //on teste si l'utilisateur a déjà fait cette étape, auquel cas on affiche sa réponse précédente
				document.getElementById("answer_div").innerHTML = '<input style="text-align:center;" placeholder="' + chain_project[position_list[position]]["placeholder"] + '" onclick="check_availability()" onkeyup="check_availability()" type="text" id="answer" name="answer" value="' + projet_descr[chain_project[position_list[position]]["title"]].replace("sple|","'").replace('dble|','"').replace(/\n/g, "\\\\n").replace(/\r/g, "\\\\r").replace(/\t/g, "\\\\t") + '" maxlength="' + chain_project[position_list[position]]["max-size"] + '" required><div id="name_check"></div>';
				check_availability();
				} else {
				document.getElementById("answer_div").innerHTML = '<input style="text-align:center;" placeholder="' + chain_project[position_list[position]]["placeholder"] + '" onclick="check_availability()" onkeyup="check_availability()" type="text" id="answer" name="answer" value="" maxlength="' + chain_project[position_list[position]]["max-size"] + '" required><div id="name_check"></div>';
				$('#name_check').html("<font color='red'>Le projet doit avoir un nom d'au moins 5 caractères</font>");
				}
			document.getElementById("nav-next").style.visibility = "hidden";
			check_availability();
		} else if (chain_project[position_list[position]]["format"] == "txt"){ // cas des questions demandant une entrée de texte de la part de l'utilisateur
			if(chain_project[position_list[position]]["title"] in projet_descr){ //on teste si l'utilisateur a déjà fait cette étape, auquel cas on affiche sa réponse précédente
				document.getElementById("answer_div").innerHTML = '<p class="text"><input type = "' + chain_project[position_list[position]]["type"] + '" placeholder="' + chain_project[position_list[position]]["placeholder"] + '" id="answer" name="answer" maxlength="' + chain_project[position_list[position]]["max-size"] + '" value="' + projet_descr[chain_project[position_list[position]]["title"]].replace("sple|","'").replace('dble|','"').replace(/\n/g, "\\\\n").replace(/\r/g, "\\\\r").replace(/\t/g, "\\\\t") + '" required> </p>';
			} else {
				document.getElementById("answer_div").innerHTML = '<p class="text"><input type = "' + chain_project[position_list[position]]["type"] + '" placeholder="' + chain_project[position_list[position]]["placeholder"] + '" id="answer" name="answer" value="" maxlength="' + chain_project[position_list[position]]["max-size"] + '" required></p>';
			}
		} else if (chain_project[position_list[position]]["format"] == "txt_mce"){ // cas des questions demandant une entrée de texte de la part de l'utilisateur sous la forme de plusieurs paragraphes
			if(chain_project[position_list[position]]["title"] in projet_descr){ //on teste si l'utilisateur a déjà fait cette étape, auquel cas on affiche sa réponse précédente
				document.getElementById("answer_div").innerHTML = '<textarea placeholder="' + chain_project[position_list[position]]["placeholder"] + '" id="answer" name="answer" maxlength=' + chain_project[position_list[position]]["max-size"] + ' required></textarea>';
				init_tinymce(projet_descr[chain_project[position_list[position]]["title"]]);
				//tinymce.get('answer').insertContent(projet_descr[chain_project[position_list[position]]["title"]]);
			} else {
				document.getElementById("answer_div").innerHTML = '<textarea placeholder="' + chain_project[position_list[position]]["placeholder"] + '" id="answer" name="answer" value="" maxlength=' + chain_project[position_list[position]]["max-size"] + ' required></textarea>';
				init_tinymce("");
			}
		} else if(position_list[position] == 2.2) {
			if(chain_project[position_list[position]]["title"] in projet_descr){
				if(projet_descr[chain_project[position_list[position]]["title"]] == "2010-01-01"){
					document.getElementById("answer_div").innerHTML = '<input type="radio" name="rdm" value="project_start" checked onclick="date_to_2010()">Dès que le projet atteint le seuil<br><input type="radio" name="rdm" value="date"><input style="text-align:center;" type="date" id="answer" value="2010-01-01" name="answer" required min = "' + today_date + '">';
				} else {
					document.getElementById("answer_div").innerHTML = '<input type="radio" name="rdm" value="project_start" onclick="date_to_2010()">Dès que le projet atteint le seuil<br><input type="radio" name="rdm" value="date" checked ><input style="text-align:center;" type="date" id="answer" value="' + projet_descr[chain_project[position_list[position]]["title"]] + '" name="answer" required min = "' + today_date + '">';
				}
			} else {
				document.getElementById("answer_div").innerHTML = '<input type="radio" name="rdm" value="project_start" checked onclick="date_to_2010()">Dès que le projet atteint le seuil<br><input type="radio" name="rdm" value="date"><input style="text-align:center;" type="date" id="answer" value="2010-01-01" name="answer" required min = "' + today_date + '">';
			}
		} else if(position_list[position] == 2.3) {
			if(projet_descr["debut_period_project"] == "2010-01-01"){
				default_min_date = "2010-01-01";
			} else if ("debut_period_project" in projet_descr){
				default_min_date = projet_descr["debut_period_project"];
			} else {
				default_min_date = today_date;
			}
			if(chain_project[position_list[position]]["title"] in projet_descr){
				if(projet_descr[chain_project[position_list[position]]["title"]] == "2010-01-01"){
					document.getElementById("answer_div").innerHTML = '<input type="radio" name="rdm" value="project_end" checked onclick="date_to_2010()">Il pourra toujours entrer en action!<br><input type="radio" name="rdm" value="date"><input style="text-align:center;" type="date" id="answer" value="2010-01-01" name="answer" required min = "' + default_min_date + '">';
				} else {
					document.getElementById("answer_div").innerHTML = '<input type="radio" name="rdm" value="project_end" onclick="date_to_2010()">Il pourra toujours entrer en action!<br><input type="radio" name="rdm" value="date" checked ><input style="text-align:center;" type="date" id="answer" value="' + projet_descr[chain_project[position_list[position]]["title"]] + '" name="answer" required min = "' + default_min_date + '">';
				}
			} else {
				document.getElementById("answer_div").innerHTML = '<input type="radio" name="rdm" value="project_end" checked onclick="date_to_2010()">Il pourra toujours entrer en action!<br><input type="radio" name="rdm" value="date"><input style="text-align:center;" type="date" id="answer" value="2010-01-01" name="answer" required min = "' + default_min_date + '">';
			}
		}
	} else if(projet_or_action == 1) { // on se place dans le descriptif de l'action
		document.getElementById("question").innerHTML = "<h2>" + chain_action[position_list[position]]["Q"] + "</h2>";
		if (chain_action[position_list[position]]["format"] == "txt"){ // cas des questions demandant une entrée de texte de la part de l'utilisateur
			if(chain_action[position_list[position]]["title"] in actions_descr[position_action - 1]){ //on teste si l'utilisateur a déjà fait cette étape, auquel cas on affiche sa réponse précédente
				document.getElementById("answer_div").innerHTML = '<p class="text"><input type = "' + chain_action[position_list[position]]["type"] + '" placeholder="' + chain_action[position_list[position]]["placeholder"] + '" id="answer" name="answer" maxlength="' + chain_action[position_list[position]]["max-size"] + '" value="' + actions_descr[position_action - 1][chain_action[position_list[position]]["title"]].replace("sple|","'").replace('dble|','"').replace(/\n/g, "\\\\n").replace(/\r/g, "\\\\r").replace(/\t/g, "\\\\t") + '" required> </p>';
			} else {
				document.getElementById("answer_div").innerHTML = '<p class="text"><input type = "' + chain_action[position_list[position]]["type"] + '" placeholder="' + chain_action[position_list[position]]["placeholder"] + '" id="answer" name="answer" value="" maxlength="' + chain_action[position_list[position]]["max-size"] + '" required></p>';
			}
		} else if (chain_action[position_list[position]]["format"] == "txt_mce"){ // cas des questions demandant une entrée de texte de la part de l'utilisateur sous la forme de plusieurs paragraphes
			if(chain_action[position_list[position]]["title"] in actions_descr[position_action - 1]){ //on teste si l'utilisateur a déjà fait cette étape, auquel cas on affiche sa réponse précédente
				document.getElementById("answer_div").innerHTML = '<textarea placeholder="' + chain_action[position_list[position]]["placeholder"] + '" id="answer" name="answer" maxlength=' + chain_action[position_list[position]]["max-size"] + ' required></textarea>';
				init_tinymce(actions_descr[position_action - 1][chain_action[position_list[position]]["title"]]);
				//tinymce.get('answer').insertContent(actions_descr[position_action - 1][chain_action[position_list[position]]["title"]]);
			} else {
				document.getElementById("answer_div").innerHTML = '<textarea placeholder="' + chain_action[position_list[position]]["placeholder"] + '" id="answer" name="answer" value="" maxlength=' + chain_action[position_list[position]]["max-size"] + ' required></textarea>';
				init_tinymce("");
			}
		}
		/*
		if (chain_action[position_list[position]]["format"] == "txt") {
			if(chain_action[position_list[position]]["title"] in actions_descr[position_action - 1]){ //on teste si l'utilisateur a déjà fait cette étape, auquel cas on affiche sa réponse précédente
				document.getElementById("answer_div").innerHTML = '<p class="text"><textarea input placeholder="' + chain_action[position_list[position]]["placeholder"] + '" id="answer" name="answer" maxlength=' + chain_action[position_list[position]]["max-size"] + ' required>' + actions_descr[position_action - 1][chain_action[position_list[position]]["title"]].replace("sple|","'").replace('dble|','"').replace(/\n/g, "\\\\n").replace(/\r/g, "\\\\r").replace(/\t/g, "\\\\t") + '</textarea></p>';
			} else {
				document.getElementById("answer_div").innerHTML = '<p class="text"><textarea input placeholder="' + chain_action[position_list[position]]["placeholder"] + '" id="answer" name="answer" maxlength=' + chain_action[position_list[position]]["max-size"] + ' required></textarea></p>';
			}
		}*/ else if (chain_action[position_list[position]]["format"] == "int") {
			if(chain_action[position_list[position]]["title"] in actions_descr[position_action - 1]){ //on teste si l'utilisateur a déjà fait cette étape, auquel cas on affiche sa réponse précédente
				document.getElementById("answer_div").innerHTML = '<input style="text-align:center;" type="number" min="1" id="answer" name="answer" value="' + actions_descr[position_action - 1][chain_action[position_list[position]]["title"]].replace("sple|","'").replace('dble|','"').replace(/\n/g, "\\\\n").replace(/\r/g, "\\\\r").replace(/\t/g, "\\\\t") + '" maxlength=' + chain_action[position_list[position]]["max-size"] + ' required>';
			} else {
				document.getElementById("answer_div").innerHTML = '<input style="text-align:center;" type="number" min="1" id="answer" name="answer" placeholder="0" maxlength=' + chain_action[position_list[position]]["max-size"] + ' required>';
			}
		} else if (chain_action[position_list[position]]["format"] == "list") { //cas des listes
			var first = 1;
			var code_to_add = '';
			for (var key in chain_action[position_list[position]]["list-choix"]){ //on itère les items
				if(chain_action[position_list[position]]["title"] in actions_descr[position_action - 1]){
					if(key == actions_descr[position_action - 1][chain_action[position_list[position]]["title"]]){
						code_to_add += '<input type="hidden" id="answer" name="answer" value="' + key + '"><br><input style="text-align:center;" type="radio" checked';
					} else {
						code_to_add += '<br><input style="text-align:center;" type="radio"';
					}
				} else if(first == 1){
					code_to_add += '<input type="hidden" id="answer" name="answer" value="' + key + '"><br><input style="text-align:center;" type="radio" checked';
					first = 0;
				} else {
					code_to_add += '<br><input style="text-align:center;" type="radio"';
				}
				code_to_add += ' onclick="update_value_radio(' + "'" + key + "'" + ')" id="' + key + '" name="choice" value ="' + chain_action[position_list[position]]["list-choix"][key] + '">' + chain_action[position_list[position]]["list-choix"][key];
			}
			document.getElementById("answer_div").innerHTML  = code_to_add;
		} else if (chain_action[position_list[position]]["format"] == "cases") { //cas des boites à cocher
			if(chain_action[position_list[position]]["title"] in actions_descr[position_action - 1]){
					// on extrait la variable contenant l'état enregistré des check-box et on la rend "lisible"
					a = actions_descr[position_action - 1][chain_action[position_list[position]]["title"]];
					a = a.split("&");
					b = [];
					for(i = 0; i < a.length ; i++){
						b[a[i].split("=")[0]] =a[i].split("=")[1];
					}
					code_to_add = ""
					code_to_add += '<input type="hidden" id="answer" name="answer" value=""><form>';
					for(i = 0 ; i < 7 ; i ++){
						code_to_add += '<br><input class = "checkbox-custom" type="checkbox" id = "case" name=' + i + ' value="1" onclick="refresh_boxes()"';
						if(b[i] == 1){
							code_to_add += " checked ";
						}
						code_to_add += '>' + chain_action[position_list[position]]["list-choix"][i];
					}
					code_to_add += '</form>';
					document.getElementById("answer_div").innerHTML = code_to_add;
					refresh_boxes()
				} else {
					code_to_add = "";
					code_to_add += '<input type="hidden" id="answer" name="answer" value=""><form>';
					for(i = 0 ; i < 7 ; i ++){
						code_to_add += '<br><input class = "checkbox-custom" type="checkbox" id = "case" name=' + i + ' value="1" onclick="refresh_boxes()">' + chain_action[position_list[position]]["list-choix"][i];
					}
					code_to_add += '</form>';
					document.getElementById("answer_div").innerHTML = code_to_add;
				}
		} else if (position_list[position] == 9.2){
			if(projet_descr["debut_period_project"] == "2010-01-01"){
				default_min_date = today_date;
			} else if ("debut_period_project" in projet_descr){
				default_min_date = projet_descr["debut_period_project"];
			} else {
				default_min_date = today_date;
			}
			if(projet_descr["fin_period_project"] == "2010-01-01"){
				default_max_date = "2099-12-31";
			} else if ("fin_period_project" in projet_descr){
				default_max_date = projet_descr["fin_period_project"];
			} else {
				default_max_date = "2099-12-31";
			}
			if(chain_action[position_list[position]]["title"] in actions_descr[position_action - 1]){
				if(actions_descr[position_action - 1][chain_action[position_list[position]]["title"]] == "2010-01-01"){
					document.getElementById("answer_div").innerHTML = '<input type="radio" name="rdm" value="project_start" checked onclick="date_to_2010()">Avec le projet <br><input type="radio" name="rdm" value="date"><input style="text-align:center;" type="date" id="answer" value="2010-01-01" name="answer" required min = "' + default_min_date + '" max = "' + default_max_date + '">';
				} else {
					document.getElementById("answer_div").innerHTML = '<input type="radio" name="rdm" value="project_start" onclick="date_to_2010()">Avec le projet <br><input type="radio" name="rdm" value="date" checked ><input style="text-align:center;" type="date" id="answer" value="" name="answer" required min = "' + default_min_date + '" max = "' + default_max_date + '">';
					document.getElementById("answer").value = actions_descr[position_action - 1][chain_action[position_list[position]]["title"]];
				}
			} else {
				document.getElementById("answer_div").innerHTML = '<input type="radio" name="rdm" value="project_start" checked onclick="date_to_2010()">Avec le projet <br><input type="radio" name="rdm" value="date"><input style="text-align:center;" type="date" id="answer" value="2010-01-01" name="answer" required min = "' + default_min_date + '" max = "' + default_max_date + '">';
			}
		} else if (position_list[position] == 9.3){
			if ("start_period_action" in actions_descr[position_action - 1] && actions_descr[position_action - 1]["start_period_action"] !== "2010-01-01"){
				default_min_date = actions_descr[position_action - 1]["start_period_action"];
			} else {
				if(projet_descr["debut_period_project"] == "2010-01-01"){
					default_min_date = today_date;
				} else if ("debut_period_project" in projet_descr){
					default_min_date = projet_descr["debut_period_project"];
				} else {
					default_min_date = today_date;
				}
			}
			if(projet_descr["fin_period_project"] == "2010-01-01"){
				default_max_date = "2099-12-31";
			} else if ("fin_period_project" in projet_descr){
				default_max_date = projet_descr["fin_period_project"];
			} else {
				default_max_date = "2099-12-31";
			}
			if(chain_action[position_list[position]]["title"] in actions_descr[position_action - 1]){
				if(actions_descr[position_action - 1][chain_action[position_list[position]]["title"]] == "2010-01-01"){
					document.getElementById("answer_div").innerHTML = '<input type="radio" name="rdm" value="project_end" checked onclick="date_to_2010()">Avec le projet <br><input type="radio" name="rdm" value="date"><input style="text-align:center;" type="date" id="answer" value="2010-01-01" name="answer" required min = "' + default_min_date + '" max = "' + default_max_date + '">';
				} else {
					document.getElementById("answer_div").innerHTML = '<input type="radio" name="rdm" value="project_end" onclick="date_to_2010()">Avec le projet <br><input type="radio" name="rdm" value="date" checked ><input style="text-align:center;" type="date" id="answer" value="" name="answer" required min = "' + default_min_date + '" max = "' + default_max_date + '">';
					document.getElementById("answer").value = actions_descr[position_action - 1][chain_action[position_list[position]]["title"]];
				}
			} else {
				document.getElementById("answer_div").innerHTML = '<input type="radio" name="rdm" value="project_end" checked onclick="date_to_2010()">Avec le projet <br><input type="radio" name="rdm" value="date"><input style="text-align:center;" type="date" id="answer" value="2010-01-01" name="answer" required min = "' + default_min_date + '" max = "' + default_max_date + '">';
			}
		}
	//document.getElementById("answer_div").innerHTML += '<div style="position: absolute; bottom: 0;"><button onclick = "delete_action(' + position_action + ')">' + "Supprimer l'action en cours" + '</button></div>';// on ajoute le bouton pour supprimer l'action en cours
	}
	if(document.getElementsByTagName('textarea').length == 0){
		document.getElementById("answer_div").style.paddingTop = 25;
		document.getElementById("answer_div").style.paddingBottom = 25;
		document.getElementById("answer_div").style.paddingLeft = 25;
		document.getElementById("answer_div").style.paddingRight = 25;
		document.getElementById("answer_div").style.height = "auto";
		document.getElementById("answer_div").style.width = "700px";
	}
}

function date_to_2010(){
	document.getElementById("answer").value = "2010-01-01";
}

function update_value_radio(key){
	document.getElementById("answer").value = key;
}

function prev_step(){
	save_data();
	position --;
	show_step();
	if(position == 0){
		document.getElementById("nav-prev").style.visibility = "hidden";
	}
}

function save_data(){
	if(document.getElementsByTagName('textarea').length !== 0){
		if(tinyMCE.get('answer').getContent() !== ""){
			if(projet_or_action == 0){ //descriptifs projet format texte
				projet_descr[chain_project[position_list[position]]["title"]] = tinymce.get('answer').getContent().replace("'","&rsquo;").replace('"',"&quot;").replace("\\","&frasl;").replace(/\r?\n|\r/g,"");
				projet_descr["position_list"] = position_list;
			} else if(projet_or_action == 1) {
				actions_descr[position_action - 1][chain_action[position_list[position]]["title"]] = tinymce.get('answer').getContent().replace("'","&rsquo;").replace("\\","&frasl;").replace('"','&quot;').replace(/\r?\n|\r/,"");
				actions_descr[position_action - 1]["position_list"] = position_list;
			}
		}
	return;
	}
	if(document.getElementById('answer') !== null){
		if(document.getElementById('answer').value !== ""){
			if(projet_or_action == 0){ //descriptifs projet format texte
				projet_descr[chain_project[position_list[position]]["title"]] = document.getElementById('answer').value.replace("'","&rsquo;").replace('"',"&quot;").replace(/\r?\n|\r/g,"");
				projet_descr["position_list"] = position_list;
			} else if(projet_or_action == 1) {
				actions_descr[position_action - 1][chain_action[position_list[position]]["title"]] = document.getElementById('answer').value.replace("'","&rsquo;").replace('"','&quot;').replace(/\r?\n|\r/g,"");
				actions_descr[position_action - 1]["position_list"] = position_list;
			}
		}
	}
}

function next_step(){
	if(projet_or_action == 0){ // cas projet
		save_data();
		if(chain_project[position_list[position]]["next"] == "end"){ //cas fin de questionnaire
			r = confirm('Souhaitez-vous soumettre le projet?');
			if(r == true){
				document.getElementById('nav-next').style.display='none';
				submit_project();
				return;
			}
		} else if (count_action == 0 && position_list[position] == 3){ // cas création de la première action (obligatoire celle là), ne kick in que si la première action n'a pas été créé encore
			projet_descr["position_list"] = position_list;
			add_action();
		} else if (count_action > 0 && position_list[position] == 2.3){ // cas edition projet avec au moins une action déjà créée, à la fin on va directement au titre du projet
			position_list[position + 1] = 13; // vu que c'est le deuxième passage, on écrase le passage à la page 3 (qui ne sert à rien si une action est déjà existante
			position ++;
		} else if (chain_project[position_list[position]]["format"] == "list") {
			position_list[position + 1] = chain_project[position_list[position]]["next"][document.getElementById("answer").value];
			position ++;
		} else {
			position_list[position + 1] = chain_project[position_list[position]]["next"];
			position ++;
		}
		show_step();
		refresh_links();
	} else if(projet_or_action == 1){//cas action
		if (chain_action[position_list[position]]["format"] == "list") {
			next_q = chain_action[position_list[position]]["next"][document.getElementById("answer").value];
		} else {
			next_q = chain_action[position_list[position]]["next"];
		}
		if(position_list[position + 1] !== next_q && position_list.length > position + 1){ //on verifie si le choix est différent du choix précédent et qu'on a déjà dépassé ce stade par le passé
			found = 0;
			for (i in [1,2,3]){
				if(position_list[position] == 8){//cas du neud à la question 8
				found = 1;
					if (position_list[position + i] == 10){ //on verifie qu'on a atteint la question 10
						found = 1;
						if(next_q == 9.1){
							for(j = 1; j < i - 1; j++){
								delete actions_descr[position_action - 1][chain_action[position_list[position + j]]["title"]];
							}
							position_list.splice(position + 1,i - 1,9.1);
							break;
						} else if(next_q == 9.2){
							for(j = 1; j < i - 1; j++){
								delete actions_descr[position_action - 1][chain_action[position_list[position + j]]["title"]];
							}
							position_list.splice(position + 1,i - 1,9.2,9.3);
							break;
						} else if(next_q == 10){
							for(j = 1; j < i - 1; j++){
								delete actions_descr[position_action][chain_action[position_list[position + j]]["title"]];
							}
							position_list.splice(position + 1,i - 1);
							break;
						}
					}
				} else if(position_list[position] == 10){//cas du neud à la question 12
					found = 1;
					if (position_list[position + i] == 12){//on verifie qu'on a atteint la question 12
						if(next_q == 11){
							for(j = 1; j < i - 1; j++){
								delete actions_descr[position_action - 1][chain_action[position_list[position + j]]["title"]];
							}
							position_list.splice(position + 1 , i - 1);
							break;
						} else if(next_q == 12){
							for(j = 1; j < i - 1; j++){
								delete actions_descr[position_action - 1][chain_action[position_list[position + j]]["title"]];
							}
							position_list.splice(position + 1 , i - 1,11);
							break;
						}
					}
				}
			}
			if (found == 0){ // cas où on a pas atteint le neud suivant
				position_list.splice(position + 1 , position_list.length - position - 1, next_q);
			}
		}
		if (position_list[position] == 12){
			if (document.getElementById("answer").value == 1) { // cas bouclage pour ajouter une nouvelle action
				save_data();
				add_action();
			} else {
				save_data();
				projet_or_action = 0;
				position = projet_descr["position_list"].length - 1;
				position_list = projet_descr["position_list"];
				position_list[position] = 13;
			}
		} else if (chain_action[position_list[position]]["format"] == "list") {
			save_data();
			position_list[position + 1] = chain_action[position_list[position]]["next"][document.getElementById("answer").value];
			position ++;
		} else {
			save_data();
			position_list[position + 1] = chain_action[position_list[position]]["next"];
			position ++;
		}
		show_step();
		refresh_links();
	}
}
function submit_project(){
	for(position_step of projet_descr["position_list"]){
		if(chain_project[position_step]["title"] in projet_descr){
			if(projet_descr[chain_project[position_step]["title"]] == ""){
				alert("Il manque des données d'entrées à l'étape " + position_step + " de la création du projet");
				document.getElementById('nav-next').style.display='inherit';
				return;
			}
		} else {
			alert("Il manque des données d'entrées à l'étape " + position_step + " de la création du projet");
			document.getElementById('nav-next').style.display='inherit';
			return;
		}
	}
	for(action in actions_descr){
		for(position_step of actions_descr[action]["position_list"]){
			if(chain_action[position_step]["title"] in actions_descr[action]){
				if(actions_descr[action][chain_action[position_step]["title"]] == ""){
					alert("Il manque des données d'entrées à l'étape " + position_step + " de la création de l'action " + action);
					document.getElementById('nav-next').style.display='inherit';
					return;
				}
			} else {
				alert("Il manque des données d'entrées à l'étape " + position_step + " de la création de l'action " + action);
				document.getElementById('nav-next').style.display='inherit';
				return;
			}
		}
	}
	// final_result = "";
	// first = 1;
	// for (key in projet_descr){
		// if(first == 1){
			// first = 0;
		// } else {
			// final_result += "&&";
		// }
		// final_result += key;
		// final_result += "==";
		// final_result += projet_descr[key];
	// }
	// final_result += "|||";
	// first_action = 1;
	// for (action in actions_descr){
		// if(first_action == 1){
			// first_action = 0;
		// } else {
			// final_result += "|||";
		// }
		// first_key = 1
		// for (key in actions_descr[action]){
			// if(first_key == 1){
				// first_key = 0;
			// } else {
				// final_result += "&&";
			// }
			// final_result += key;
			// final_result += "==";
			// final_result += actions_descr[action][key];
		// }
	// }
	//document.getElementById("answer_div").innerHTML = final_result;
	method = "post";
	var form = document.createElement("form");
	form.setAttribute("method", method);
	form.setAttribute("action", form_target);
	for (key in projet_descr){
		var hiddenField = document.createElement("input");
		hiddenField.setAttribute("type", "hidden");
		hiddenField.setAttribute("name", key);
		hiddenField.setAttribute("value", projet_descr[key]);
		form.appendChild(hiddenField);
	}
	for (action in actions_descr){
		for (key in actions_descr[action]){
			var hiddenField = document.createElement("input");
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", "action_" + action + "__" + key);
			hiddenField.setAttribute("value", actions_descr[action][key]);
			form.appendChild(hiddenField);
		}
	}
	//on nettoie la variable actions_descr avant de la soumettre
	if (typeof actions_descr["init_name"] != "undefined"){
		delete actions_descr["init_name"];
	}
	if (typeof projet_descr["init_name"] != "undefined"){
		delete projet_descr["init_name"];
	}
	if (typeof projet_descr["init_act_nbr"] != "undefined"){
		init_act_nbr = projet_descr["init_act_nbr"];
		for(i = 0 ; i < init_act_nbr ; i++){
			if (typeof projet_descr["action_name_"+i.toString()] != "undefined"){
				delete projet_descr["action_name_"+i.toString()];
			}
			if (typeof projet_descr["action_ref_"+i.toString()] != "undefined"){
				delete projet_descr["action_ref_"+i.toString()];
			}
		}
		delete projet_descr["init_act_nbr"];
	delete actions_descr["init_name"];
	}
	if (typeof actions_descr["init_name"] != "undefined"){
		delete actions_descr["init_name"];
	}
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "actions_descr_str");
	hiddenField.setAttribute("value", JSON.stringify(actions_descr));
	form.appendChild(hiddenField);
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "projet_descr_str");
	$string = {"":projet_descr,"":actions_descr}
	hiddenField.setAttribute("value", JSON.stringify({"proj_descr": projet_descr,"act_descr": actions_descr}));
	form.appendChild(hiddenField);
	// hiddenField.setAttribute("type", "hidden");
	// hiddenField.setAttribute("name", "results");
	// hiddenField.setAttribute("value", final_result);
	// form.appendChild(hiddenField);
	document.body.appendChild(form);
	form.submit();
}
function delete_action(i){
	r = confirm("Souhaitez-vous supprimer l'action numéro" + i + "?");
	if(r == true){
		count_action --;
		projet_descr["nbre_act"] = count_action;
		actions_descr.splice(i - 1 , 1)
		position = 0;
		position_action = 0;
		projet_or_action = 0;
		position_list = projet_descr["position_list"];
		show_step();
	}
	refresh_links();
}
function edit_project(){
	r = confirm("Souhaitez-vous revenir à l'édition du projet?");
	if(r == true){
		save_data();
		position = 0;
		projet_or_action = 0;
		position_list = projet_descr["position_list"];
		show_step();
	}
}

function edit_action(i){
	r = confirm("Souhaitez-vous revenir à l'édition de l'action " + i +"?");
	if(r == true){
		save_data();
		position_action = i;
		position = 0;
		projet_or_action = 1;
		position_list = actions_descr[position_action - 1]["position_list"];
		show_step();
	}
}

function refresh_links(){
	document.getElementById("case_lien_actions").innerHTML = "";
	if(actions_descr.length > 0){
		for(i = 1 ; i <= actions_descr.length ; i ++){
			if("nom_act" in actions_descr[i - 1]){
				document.getElementById('case_lien_actions').innerHTML += actions_descr[i - 1]["nom_act"] + ' <u style="font-color: blue; cursor: pointer;" onclick="edit_action(' + i +')">Éditer</u> | <u style="font-color: blue; cursor: pointer;" onclick="delete_action(' + i + ')">Supprimer</u> | <u style="font-color: blue; cursor: pointer;" onclick="save_data();duplicate_action(' + i + ');show_step()">Dupliquer</u></p><br>';
			} else {
				document.getElementById('case_lien_actions').innerHTML += 'Action ' + i + ' <u style="font-color: blue; cursor: pointer;" onclick="edit_action(' + i +')">Éditer</u> | <u style="font-color: blue; cursor: pointer;" onclick="delete_action(' + i + ')">Supprimer</u> | <u style="font-color: blue; cursor: pointer;" onclick="save_data();duplicate_action(' + i + ');show_step()">Dupliquer</u></p><br>';
			}
		}
	}
}

function refresh_boxes(){
	str = $("form").serialize();
	document.getElementById("answer").value = str;
}
function get_check_boxes(){
	a = actions_descr[position_action - 1][chain_action[position_list[position]]["title"]];
	a = a.split("&");
	b = [];
	for(i = 0; i < a.length ; i++){
		b[i] =[a[i].split("=")[0] , a[i].split("=")[1]];
	}
	for(i = 0; i < b.length ; i++){
		document.getElementsByName(b[i][0])[0].checked = true;
	}
	refresh_boxes()
}

function add_action(){
	position_action = actions_descr.length;
	actions_descr[position_action] = {"position_list" : {0:4}};
	position_action ++;
	count_action ++;
	projet_descr["nbre_act"] = count_action;
	position = 0;
	projet_or_action = 1;
	position_list = [4];
}

function duplicate_action(i){
	position_action = actions_descr.length;
	actions_descr[position_action] = $.extend(true, [], actions_descr[i - 1]);
	position_action ++;
	count_action ++;
	projet_descr["nbre_act"] = count_action;
	position = 0;
	projet_or_action = 1;
	position_list = [4];
	refresh_links();
}

function check_availability(){
	//document.getElementById("submit_project").disabled = "disabled";
	//get the username
	var project_name = $('#answer').val();
	//use ajax to run the check
	if (project_name == "" || project_name.length < 5){
		$('#name_check').html("<font color='red'>Le projet doit avoir un nom d'au moins 5 caractères</font>");
		document.getElementById("nav-next").style.visibility = "hidden";
		return;
	}
	if (typeof projet_descr['init_name'] === 'undefined') {
		$.post("project_name_check.php",
		{ project_name: project_name},
		function(result){
			//if the result is 1
			if(result == 1){
				//show that the username is available
				$('#result').css('color', 'green');
				$('#name_check').html('<font color="green">Nom libre</font>');
				document.getElementById("nav-next").style.visibility = "visible";
			}else{
				//show that the username is NOT available
				$('#result').css('color', 'red');
				$('#name_check').html('<font color="red">Nom déjà utilisé</font>');
				document.getElementById("nav-next").style.visibility = "hidden";
			}
			if ($('#answer').val() != project_name){
				check_availability();
			}
		});
	} else {
		$.post("project_name_check.php",
		{ project_name: project_name , init_name: projet_descr['init_name']},
		function(result){
			//if the result is 1
			if(result == 1){
				//show that the username is available
				$('#result').css('color', 'green');
				$('#name_check').html('<font color="green">Nom libre</font>');
				document.getElementById("nav-next").style.visibility = "visible";
			}else{
				//show that the username is NOT available
				$('#result').css('color', 'red');
				$('#name_check').html('<font color="red">Nom déjà utilisé</font>');
				document.getElementById("nav-next").style.visibility = "hidden";
			}
			if ($('#answer').val() != project_name){
				check_availability();
			}
		});
	}
}
function init_tinymce(val){
	var tinymce_loaded = 0;
	tinymce.init({
		selector: 'textarea#answer',
		height: '200',
		plugins: [
			'advlist autolink lists link image charmap print preview anchor',
			'searchreplace visualblocks code fullscreen',
			'insertdatetime media table contextmenu paste code'
		],
		toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		body_id: 'answer',
		theme_advanced_resizing: true,
		theme_advanced_resizing_use_cookie : false,
		width: '698px',
		//autoresize_on_init: false
		setup : function(ed) {
			ed.on("init",function(ed) {
			tinymce.get('answer').insertContent(val);
			element_format : 'html';
			encoding: 'xml';
			//entities : '47,sol,62,gt,60, lt,92,bsol,160,nbsp,162,cent,8364,euro,163,pound,8260,frasl';
			entity_encoding : "named";
			content_css : "css/creation-page.css";
			});
			//ed.on('postRender', function() {
			//tinymce.get('answer').insertContent(val);
			//});
		}
	});
	if(document.getElementsByTagName('textarea').length !== 0){
		document.getElementById("answer_div").style.paddingTop = 0;
		document.getElementById("answer_div").style.paddingBottom = 0;
		document.getElementById("answer_div").style.paddingLeft = 2;
		document.getElementById("answer_div").style.paddingRight = 0;
		document.getElementById("answer_div").style.height = "auto";
		document.getElementById("answer_div").style.width = "700px";
	}
}
function check_mail(mail){
	patern = new RegExp(/[^\s@]+@[^\s@]+\.[^\s@]+/);
	if (!patern.test(mail)){
		alert("Le mail est invalide");
	}
}

var progressProject = 0;
var progressAction = 0;
function wa_Progress_bar(){

	if (projet_or_action == 0){
		if (position_list[position] == 1){
			progressProject = 20;
			$('#waBar').css('width', progressProject+'%' );
		}
		else if (position_list[position] == 2){
			progressProject = 40;
			$('#waBar').css('width', progressProject+'%' );
		}
		else if (position_list[position] == 2.2){
			progressProject = 60;
			$('#waBar').css('width', progressProject+'%' );
		}
		else if (position_list[position] == 2.3){
			progressProject = 80;
			$('#waBar').css('width', progressProject+'%' );
		}
		else if (position_list[position] == 13){
			progressProject = 100;
			$('#waBar').css('width', progressProject+'%' );
		}
		// progress = (position / 7) * 100
		// $('#waBar').css('width', progress+'%' );
	}
	else if (projet_or_action == 1) {
		if (position_list[position] == 5){
			progressAction = 16.6;
			$('#waBarAction').css('width', progressAction+'%' );
		}
		else if (position_list[position] == 6){
			progressAction = 33.3;
			$('#waBarAction').css('width', progressAction+'%' );
		}
		else if (position_list[position] == 7){
			progressAction = 50;
			$('#waBarAction').css('width', progressAction+'%' );
		}
		else if (position_list[position] == 8){
			progressAction = 66.6;
			$('#waBarAction').css('width', progressAction+'%' );
		}
		else if (position_list[position] == 10){
			progressAction = 83.3;
			$('#waBarAction').css('width', progressAction+'%' );
		}
		else if (position_list[position] == 12){
			progressAction = 100;
			$('#waBarAction').css('width', progressAction+'%' );
		}

		// progress = (position / 8) * 100;
		// $('#waBarAction').css('width', progress+'%' );
	}
}
