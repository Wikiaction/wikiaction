$("#psswd").keyup(function(event){
    if(event.keyCode == 13){
        $("#sign_in").click();
    }
});

var xhttp = null;

function check_creds(){
	if (document.getElementById('psd').value.length < 1){
		alert("Pseudo trop court")
		return;
	}
	if (document.getElementById('psswd').value.length < 1){
		alert("Mot de passe trop court")
		return;
	}
	document.getElementById("sign_in").disabled = true;
	document.getElementById("sign_in").innerHTML = "Veuillez patienter";
	xhttp.open("POST", "log_user.php" , true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("pseudo=" + document.getElementById('psd').value + "&psswd=" + document.getElementById('psswd').value);
}
xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
	if (xhttp.readyState == 4 && xhttp.status == 200) {
		if(xhttp.responseText == 3){
			if (referer == ""){
				window.location = "myaccount.php";
			} else {
				window.location = referer;
			}
			//document.getElementById("sign_in").innerHTML = "CONNEXION";
			//document.getElementById("sign_in").disabled = false;
		} else if (xhttp.responseText == 5){
			document.getElementById("sign_in").innerHTML = "CRÉER UN COMPTE";
			document.getElementById("sign_in").disabled = false;
			alert("Ce compte n'a pas encore été confirmé, veuillez utiliser le lien qui vous a été envoyé");
		} else {
			document.getElementById("sign_in").innerHTML = "CRÉER UN COMPTE";
			document.getElementById("sign_in").disabled = false;
			alert("veuillez vérifier le mot de passe");
		}
	}
};
