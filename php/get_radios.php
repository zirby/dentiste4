<?php
    $result = array();
    include 'conn.php';


	$sis_id = isset($_GET['sis_id']) ? $_GET['sis_id'] : 0;  

    $sql = "SELECT * FROM `radios`  WHERE name=$sis_id"; 
	$res=mysql_query($sql);
	if($res){
		while($row=mysql_fetch_object($res))
		{
			$image=$row->rxname;
			 echo "<img src='radios/$image' title='$image' class='easyui-tooltip' ><figcaption>$image</figcaption>";
		}		
	};

?>