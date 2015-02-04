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
			 echo "<a href='radios/$image' target='_blank' ><img src='radios/$image' title='$image' class='easyui-tooltip' ></a>&nbsp;&nbsp;";
		}		
	};

?>