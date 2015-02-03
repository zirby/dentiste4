/**
 * @author Christian ZIRBES
 * GCD
 * Gestion Cabinet Dentaire
 */

$(document).ready(function(){
	$('#frmPatient').form('clear');
	$('#frmSoin').form('clear');
	var date = new Date();console.log(date);
	var y = date.getFullYear();
	var m = date.getMonth() + 1;
	var d = date.getDate();
	var today=y + '-' + (m < 10 ? '0' + m : m) + '-' + (d < 10 ? '0' + d : d) ;console.log(today);
	var url;
	var sis_id;
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
			sis_id=row.sis;
			
			/* soins */
			$('#dgSoins').datagrid({
				url:'php/get_soins.php?sis_id='+sis_id
			});
			$('#pSoin').panel('setTitle',row.nom+" "+row.prenom+" - "+row.age+" ans");
			$('#frmSoin').form('clear');
			console.log(today);
			$('#s_date').textbox("setValue",today);
			$("input[name=s_pay]").val(['E']);
			$("input[name=s_dentiste]").val(['Z']);
			console.log(sis_id);
			$('#sis_id').textbox("setValue",sis_id);	
			$('#name').textbox("setValue",sis_id);
			$('#soin_asd').textbox("setValue","00*0000/00");	
			$('#s_hono').textbox("setValue","0");	
			url = 'php/save_soin.php';
			/* patient */
			$('#tt').tabs('select',1);
			//$('#td_photo').html("<img src='./css/images/unknown_140.jpg' />");
			$.ajax({
				"url": "php/get_photo.php?sis_id="+sis_id,
				"type":"GET",
				"success": function(data){$('#td_photo').html(data);}
			});
					url='php/update_patient.php';
					url_s='php/save_soin.php';
		}
	});

	$('#dgSoins').datagrid({
		onClickRow:function(index,row){
			$('#frmSoin').form('load',row);
			sis_id=row.sis_id;
			console.log(sis_id);
			url_s='php/update_soin.php';
		}
	});
/******************* CRUD Patient  ***********************/
	$('#btnAddEid').click(function(){
		$('#frmPatient').form('clear');
		$.ajax({
			"url": "php/add_eid.php",
			"type":"GET",
			"success": function(data){
				var result = eval('('+data+')');
				if (result.success){
					$('#dgPatients').datagrid('reload');
				}else{
					alert(result.msg);
				}
			}
		});		
	});

	$('#btnEditEid').click(function(){
		$.ajax({
			"url": "php/update_eid.php?sis="+sis_id,
			"type":"GET",
			"success": function(data){
				var result = eval('('+data+')');
				if (result.success){
					$('#frmPatient').form('reload');
				}else{
					alert(result.msg);
				}
			}
		});		
	});


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

/******************* CRUD Soin  ***********************/
	$('#btnAddSoins').click(function(){
		$('#frmSoin').form('clear');
		console.log(today);
		$('#s_date').textbox("setValue",today);
		$("input[name=s_pay]").val(['E']);
		$("input[name=s_dentiste]").val(['Z']);
		console.log(sis_id);
		$('#sis_id').textbox("setValue",sis_id);	
		$('#soin_asd').textbox("setValue","00*0000/00");
		$('#s_hono').textbox("setValue","0");	
		url_s = 'php/save_soin.php';
	});


	$('#btnEditSoin').click(function(){
		console.log("je sauve");
		$('#frmSoin').form('submit',{
			url: url_s,
			method:"POST",
			onSubmit: function(){
				console.log("je submit");
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');
				if (result.success){
					console.log("success");
					$('#dgSoins').datagrid('reload');	// reload the user data
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
	
	$('#btnDeleteSoins').click(function (){
		var row = $('#dgSoins').datagrid('getSelected');
		if (row){
			$.post('php/remove_soin.php',{s_id:row.s_id},function(result){
						if (result.success){
							$('#dgSoins').datagrid('reload');
							$('#btnAddSoins').click();	
						} 
					},'json');
				}
		});


	$('#btnAsd').click(function(){
		$.ajax({
			"url": "php/get_asd.php?dentis="+$("input[name=s_dentiste]:checked").val(),
			"type":"GET",
			"success": function(data){
				console.log(data);
				$("#soin_asd").textbox("setValue",data);
			}
		});
	});

/******************* CRUD Radios  ***********************/	
	
	$('#btnAddRadio').click(function(){
		console.log("je vais submiter");
		$('#frmRadio').form('submit',{
		    url: "php/save_radio.php",
		    method:"POST",
		    onSubmit: function(){
		        console.log("je submit");
		        // return false to prevent submit;
		    },
		    success:function(data){
		    	console.log("je suis dans success");
		        var data = eval('(' + data + ')');  // change the JSON string to javascript object
		        if (data.success){
		            console.log(data.message);
			    }else{
			    	console.log(data.message);
			    }
			}
			
		});
	});

});