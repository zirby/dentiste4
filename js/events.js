/**
 * @author Christian ZIRBES
 * GCD
 * Gestion Cabinet Dentaire
 */

$(document).ready(function(){
	$('#frmPatient').form('clear');
	$('#frmSoin').form('clear');
	
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
/******************* click dg  ***********************/		
	$('#dgPatients').datagrid({
		onClickRow:function(index,row){
			$('#frmPatient').form('load',row);
			console.log(row.sis);
			$('#dgSoins').datagrid({
				url:'php/get_soins.php?sis_id='+row.sis,
			});
			$('#frmSoin').form('clear');
		}
	});

	$('#dgSoins').datagrid({
		onClickRow:function(index,row){
			$('#frmSoin').form('load',row);
		}
	});
/******************* CRUD Patient  ***********************/
	$('#btnEditPatient').click(function(){
		console.log("je sauve");
		$('#frmPatient').form('submit',{
			url: 'php/update_patient.php',
			onSubmit: function(){
				console.log("je submit");
				return $(this).form('validate');
			},
			success: function(result){
				console.log(result.msg);
				if (result.success){
					$('#dgPatients').datagrid('reload');	// reload the user data
				} 
			},
			error: function(xhr, textStatus, errorThrown){
				if (xhr.status==400){
					alert(xhr.responseText);
				} else {
					alert("Une erreur est survenue lors de l'enregistrement : "+xhr.status+" - "+textStatus);
				}
			}

		});
	});


});