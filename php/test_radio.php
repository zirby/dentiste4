<?php


$file_name = $_FILES['files']['name'];
//$file_name = $sis_id."-".$file_name;
$file_size =$_FILES['files']['size'];
$file_tmp =$_FILES['files']['tmp_name'];
$file_type=$_FILES['files']['type'];  

 
echo <<<INFO
<div style="padding:0 50px">
<p>file_name: $file_name</p>
<p>file_size: $file_size</p>
<p>file_tmp: $file_tmp</p>
<p>file_type: $file_type</p>
</div>
INFO;

?>