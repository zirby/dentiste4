<?php
include 'conn.php';

$name = $_POST['name'];

$target_dir = "../radios/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$rxname= basename($_FILES["fileToUpload"]["name"]);
$rxsize = $_FILES["fileToUpload"]["size"];
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
$message="";

if($check !== false) {
	$message.="File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
} else {
	$message.="File is not an image.";
    $uploadOk = 0;
}


// Check if file already exists
if (file_exists($target_file)) {
	$message.="Sorry, file already exists.";
    $uploadOk = 0;
}


// Check file size
if ($rxsize > 500000) {
	$message.="Sorry, your file is too large.";
    $uploadOk = 0;
}


// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
	$message.="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	$message.="Sorry, your file was not uploaded.";
	echo json_encode(array('success'=>FALSE,'message'=>$message));
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    	$message.="The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		
	    // puis on entre les données en base de données :
	    $sql = "INSERT INTO radios (id, name, rxname, rxsize, rxtype) VALUES(null, $name, $rxname, $rxsize, $rxtype)";
		$rs = mysql_query($sql);
		if ($rs){
			$message.= "Radio ".$name." saved !";
		}else{
			$message.= "Name is empty - Radio not saved";
		}
		
    	echo json_encode(array('success'=>TRUE,'message'=>$message));
    } else {
    	$message.="Sorry, there was an error uploading your file.";
    	echo json_encode(array('success'=>FALSE,'message'=>$message));
    }
}
?>