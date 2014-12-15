/**
 * @author Christian ZIRBES
 * GCD
 * Gestion Cabinet Dentaire
 */

$(document).ready(function(){
	
/******************* search  ***********************/	
	$("#txtNom").keypress(function(event){
		$("#txtPrenom").val("");
		$("#txtTel").val("");
		if (event.which === 13) {
			$('#dgPatients').datagrid({
				url:'php/get_patients.php?txtNom='+$("#txtNom").val(),
			});
    	}
	});
	$("#txtPrenom").keypress(function(event){
		$("#txtNom").val("");
		$("#txtTel").val("");
		if (event.which === 13) {
			$('#dgPatients').datagrid({
				url:'php/get_patients.php?txtPrenom='+$("#txtPrenom").val(),
			});
    	}
	});
	$("#txtTel").keypress(function(event){
		$("#txtPrenom").val("");
		$("#txtNom").val("");
		if (event.which === 13) {
			$('#dgPatients').datagrid({
				url:'php/get_patients.php?txtTel='+$("#txtTel").val(),
			});
    	}
	});
/******************* click dgPatients  ***********************/		



});