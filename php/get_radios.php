<?php
    $result = array();
    include 'conn.php';


	$sis_id = isset($_GET['sis_id']) ? $_GET['sis_id'] : 0;  

    $sql = "SELECT * FROM `radios`  WHERE sis_id=$sis_id"; 
	$res=mysql_query($sql);
	if($res){
		while($row=mysql_fetch_array($res))
		{
			$image=$row ['photo'];
			echo '<img src="radios/'.$image.'">';
		}		
	};

?>