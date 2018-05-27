var condition_for_submit = {mail_ok:0,name_ok:0,lieu_ok:0};
function align_dropdown(sel){
	document.getElementById("unit_def").value = sel.value;
	document.getElementById("unit_freq").value = sel.value;
	document.getElementById("unit_seuil").value = sel.value;
}
function allow_submit(){
    //if(condition_for_submit.mail_ok == 1 && condition_for_submit.name_ok == 1 && condition_for_submit.lieu_ok == 1){
    if(condition_for_submit.name_ok == 1 && condition_for_submit.lieu_ok == 1){
        document.getElementById("sign_contract").disabled = false;
    }else{
        document.getElementById("sign_contract").disabled = "disabled";
    }
}
$(document).ready(function() {
	$('#pseudo').keyup(function(){
		if($('#pseudo').val().length < 1){   
			condition_for_submit.name_ok = 0;
			allow_submit();
		}else{
			condition_for_submit.name_ok = 1;
			allow_submit();
		}
	});
	$('#lieu').keyup(function(){
		if($('#lieu').val().length < 1){   
			condition_for_submit.lieu_ok = 0;
			allow_submit();
		}else{
			condition_for_submit.lieu_ok = 1;
			allow_submit();
		}
	});
	/* $('#couriel').keyup(function(){
		var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
		if(pattern.test(document.getElementById("couriel").value)){
			condition_for_submit.mail_ok = 1;
			allow_submit();
		}else{
			condition_for_submit.mail_ok = 0;
			allow_submit();
		}
	}); */
});