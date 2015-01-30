<?php
$result = array();
include 'conn.php';

$sis_id = isset($_GET['sis_id']) ? $_GET['sis_id'] : 0;  

if(isset($_FILES['files'])){
    $errors= array();
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
	    $file_name = $key.$_FILES['files']['name'][$key];
		$file_name = $sis_id."-".$file_name;
	    $file_size =$_FILES['files']['size'][$key];
	    $file_tmp =$_FILES['files']['tmp_name'][$key];
	    $file_type=$_FILES['files']['type'][$key];  
	    if($file_size > 2097152){
	        $errors[]='File size must be less than 2 MB';
	    }       
	    $query="INSERT into radios (SIS_ID,`FILE_NAME`,`FILE_SIZE`,`FILE_TYPE`) 
	            VALUES($sis_id,'$file_name','$file_size','$file_type'); ";
	
	    $desired_dir="radios";
	    if(empty($errors)==true){
	        if(is_dir($desired_dir)==false){
	            mkdir("$desired_dir", 0700);        // Create directory if it does not exist
	        }
	        if(is_dir("$desired_dir/".$file_name)==false){
	            move_uploaded_file($file_tmp,"gallery/".$file_name);
	        }else{                                  //rename the file if another one exist
	            $new_dir="radios/".$file_name.time();
	             rename($file_tmp,$new_dir) ;               
	        }
	        mysql_query($query) or die(mysql_error());          
	    }else{
				echo json_encode($errors);
	    }
	 }
	if(empty($error)){
	    echo json_encode(array('success'=>true));
	}
}
?>