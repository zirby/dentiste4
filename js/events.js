/**
 * @author Christian ZIRBES
 * GCD
 * Gestion Cabinet Dentaire
 */

$(document).ready(function(){
	$('#frmPatient').form('clear');
	$('#frmSoin').form('clear');
	
	var url;
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
			$('#tt').tabs('select',1);
			url='php/update_patient.php';
		}
	});

	$('#dgSoins').datagrid({
		onClickRow:function(index,row){
			$('#frmSoin').form('load',row);
		}
	});
/******************* CRUD Patient  ***********************/
	$('#btnAddPatient').click(function(){
		$('#frmPatient').form('clear');
		url = 'php/save_patient.php';
		$('#tt').tabs('select',1);
	});


	$('#btnEditPatient').click(function(){
		console.log("je sauve");
		$('#frmPatient').form('submit',{
			url: url,
			onSubmit: function(){
				console.log("je submit");
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');
				if (result.success){
					console.log("success");
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