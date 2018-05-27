var condition_for_submit = {titre_ok:0,units_ok:0};

function allow_submit(){
    if(condition_for_submit.titre_ok == 1 &&  condition_for_submit.units_ok == 1){
        document.getElementById("submit_project").disabled = false;
    }else{
        document.getElementById("submit_project").disabled = "disabled";
    }
}


$(document).ready(function() {  
  
        //the min chars for username  
        var min_chars = 5;  
  
        //result texts  
        var characters_error = 'Le nom du projet doit faire au moins 5 caractères';  
        var checking_html = 'Vérification...';  
  
        //when button is clicked  
        $('#project_name').keyup(function(){  
            //run the character number check  
            if($('#project_name').val().length < min_chars){  
                //if it's bellow the minimum show characters_error text '  
                $('#project_name_availability_result').html(characters_error);  
            }else{  
                //else show the cheking_text and run the function to check  
                $('#project_name_availability_result').html(checking_html);  
                check_availability();
            }  
        });  
  
  });  
  
//function to check projectname availability  
function check_availability(){  
        document.getElementById("submit_project").disabled = "disabled";
        //get the username  
        var project_name = $('#project_name').val();  
  
        //use ajax to run the check  
        $.post("project_name_check.php", { project_name: project_name },  
            function(result){  
                //if the result is 1  
                if(result == 1){  
                    //show that the username is available  
                    $('#project_name_availability_result').html('<font color="green">Nom disponible</font>');
                    condition_for_submit.titre_ok = 1;
                    allow_submit()
                }else{  
                    //show that the username is NOT available  
                    $('#project_name_availability_result').html('<font color="red">Nom déjà utilisé</font>');
                    condition_for_submit.titre_ok = 0;
                    allow_submit()
                }  
        });  
  
}  

function Checkunit(){
	var duplicate=false;
	var unit_name_tmp = document.getElementById("unit_name");
	if($('#unit_name').val() == ''){
		duplicate=true;
		alert("Le nom est vide");
		return;
	}
	var unit_descr_tmp = document.getElementById("unit_descr");
	if($('#unit_descr').val() == ''){
		duplicate=true;
		alert("La description est vide");
		return;
	}
	var seuil_tmp = document.getElementById("seuil");
	if($('#seuil').val() == ''){
		duplicate=true;
		alert("Veuillez entrer un seuil");
		return;
	}
	var frequence_tmp = document.getElementById("frequence");
	if($('#frequence').val() == ''){
		duplicate=true;
		alert("Veuillez entrer une fréquence");
		return;
	}
	var table=document.getElementById("Tableunit");
	for(var r=0,n=table.rows.length;r<n;r++){
		if(unit_name_tmp.value==table.rows[r].cells[0].innerHTML){
			duplicate=true;
			alert("Déjà selectionné");
			return;
		}
	}
	if(duplicate==false){
		addUnit();
	}
}
function addUnit(){
	var unit_name_tmp = document.getElementById("unit_name");
	var unit_descr_tmp = document.getElementById("unit_descr");
	var seuil_tmp = document.getElementById("seuil");
	var frequence_tmp = document.getElementById("frequence");
	var seuil_fixed_tmp = document.getElementById("seuil_fixed");
	var table=document.getElementById("Tableunit");
	var rowCount=table.rows.length;
	var row=table.insertRow(rowCount);
	if(rowCount!=0){
		$('#Tableunit').slideDown("slow");
		condition_for_submit.units_ok = 1;
		allow_submit()
	}
	row.insertCell(0).innerHTML=unit_name_tmp.value;
	row.insertCell(1).innerHTML=unit_descr_tmp.value;
	row.insertCell(2).innerHTML=frequence_tmp.value;
	row.insertCell(3).innerHTML=seuil_tmp.value;
	row.insertCell(4).innerHTML=seuil_fixed_tmp.value;
	row.insertCell(5).innerHTML='<input type="button" class="btn btn-default" value ="Remove" onClick="Javacsript:deleteUnit(this)">';
	row.insertCell(6).innerHTML= '<input type="hidden" name="unit_descr_tmp_type2[]" value="' + unit_descr_tmp.value +'">';
	row.insertCell(6).innerHTML= '<input type="hidden" name="unit_name_type2[]" value="' + unit_name_tmp.value +'">';
	row.insertCell(6).innerHTML= '<input type="hidden" name="frequence_tmp_type2[]" value="' + frequence_tmp.value +'">';
	row.insertCell(6).innerHTML= '<input type="hidden" name="seuil_tmp_type2[]" value="' + seuil_tmp.value +'">';
	row.insertCell(6).innerHTML= '<input type="hidden" name="seuil_fixed_tmp_type2[]" value="' + seuil_fixed_tmp.value +'">';
}
function deleteUnit(obj){
	var index=obj.parentNode.parentNode.rowIndex;
	var table=document.getElementById("Tableunit");
	table.deleteRow(index);
	var rowCount=table.rows.length;
	if(rowCount==1){
		$('#Tableunit').slideUp("slow");
		condition_for_submit.units_ok = 0;
		allow_submit()
	}
}