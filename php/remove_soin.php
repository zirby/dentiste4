<?php
$result = array();
include 'conn.php';

$id = intval($_POST['s_id']);

$sql = "delete from `soins` where s_id=$id";
//echo $sql;

$rs = mysql_query($sql);
if ($rs){
		echo json_encode(array('success'=>true));
	}else {
		echo json_encode(array('msg'=>$sql));
	}
	

?>