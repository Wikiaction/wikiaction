var status_valid = [0,0,0];
var status_data = "none";

function checkPass(){
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('pass1');
    var pass2 = document.getElementById('pass2');
    //Store the Confimation Message Object ...
    //var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    var goodColor = "#c6ecc6";
    var badColor = "#ff6666";
    var neutralColor = "#ffffff"
    //Compare the values in the password field
    //and the confirmation field
    if (pass1.value == pass2.value && pass1.value == ''){
      pass1.style.backgroundColor = neutralColor;
      pass2.style.backgroundColor = neutralColor;
    } else if (pass1.value == pass2.value) {
      status_valid[2] = 1;
        //The passwords match.
        //Set the color to the good color and inform
        //the user that they have entered the correct password
        pass1.style.backgroundColor = goodColor;
        pass2.style.backgroundColor = goodColor;
        //message.style.color = goodColor;
        //message.innerHTML = "Passwords Match!"
        ready_to_submit();
    } else {
      status_valid[2] = 0;
      document.getElementById('submit').disabled = true;
      //The passwords do not match.
      //Set the color to the bad color and
      //notify the user.
      pass1.style.backgroundColor = badColor;
      pass2.style.backgroundColor = badColor;
      //message.style.color = badColor;
      //message.innerHTML = "Passwords Do Not Match!"
    }
}
function check_pseudo_availability(){
	  var goodColor = "#c6ecc6";
		var badColor = "#ff6666";
		var pseudo = document.getElementById("psd").value;
    if (pseudo != "") {
      if ( /[^A-Za-z\d-]/.test(pseudo)) {
        alert("Please enter only letter and numeric characters");
        document.getElementById('psd').style.backgroundColor = badColor;
        document.getElementById('submit').disabled = true;
        return;
      }

      $.post("pseudo_check.php", { pseudo: pseudo },
  			function(result){
  				//if the result is 1
  				if(result == 1){
  					status_valid[0] = 1;
  					//show that the username is available
  					$('#psd').css('backgroundColor', goodColor);
  					//$('#name_check').html('<font color="green">Nom libre</font>');
  					//document.getElementById("nav-next").style.visibility = "visible";
  					ready_to_submit();
  				} else {
  					status_valid[0] = 0;
  					document.getElementById('submit').disabled = true;
  					//show that the username is NOT available
  					$('#psd').css('backgroundColor', badColor);
  					//$('#name_check').html('<font color="red">Nom d�j� utilis�</font>');
  					//document.getElementById("nav-next").style.visibility = "hidden";
  				}
  		});
    }
}
function check_mail_availability(){
	    var goodColor = "#c6ecc6";
		var badColor = "#ff6666";
		var email = document.getElementById("mail").value;
		$.post("mail_check.php", { email: email },
			function(result){
				//if the result is 1
				if(result == 1){
					status_valid[1] = 1;
					//show that the username is available
					$('#mail').css('backgroundColor', goodColor);
					//$('#name_check').html('<font color="green">Nom libre</font>');
					//document.getElementById("nav-next").style.visibility = "visible";
					ready_to_submit();
				}else{
					status_valid[1] = 0;
					document.getElementById('submit').disabled = true;
					//show that the username is NOT available
					$('#mail').css('backgroundColor', badColor);
					//$('#name_check').html('<font color="red">Nom d�j� utilis�</font>');
					//document.getElementById("nav-next").style.visibility = "hidden";
				}
		});
}
function valid_mail(){
    var email = document.getElementById('mail');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!filter.test(email.value)) {
		//alert('Please provide a valid email address');
		status_valid[1] = 0;
		document.getElementById('submit').disabled = true;
		email.style.color = 'red';
	} else {
		email.style.color = 'black';
		check_mail_availability();
	}
}


function ready_to_submit(){
	if(status_valid[0]==1 && status_valid[1]==1 && status_valid[2]==1){
		document.getElementById('submit').disabled = false;
	}
}
