<?php
    $result = array();
    include 'conn.php';


	$sis_id = isset($_GET['sis_id']) ? $_GET['sis_id'] : 0;  

    $sql = "SELECT photo FROM `patients`  WHERE SIS=$sis_id"; 
	$res=mysql_query($sql);
	  	if($res){
	   		$rec=mysql_fetch_object($res);
			$imgstr = $rec->photo;
		};

echo "<img src='data:image/png;base64,$imgstr' alt='Photo identité' ></img>";

?>