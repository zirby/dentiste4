<?php
$result = array();
include 'conn.php';

function securite_bdd($string){
    // On regarde si le type de string est un nombre entier (int)
    if(ctype_digit($string)){
    	$string = intval($string);
    }
    // Pour tous les autres types
    else
    {
        $string = mysql_real_escape_string($string);
        $string = addcslashes($string, '%_');
    }
    
    return $string;
}

$s_id = $_POST['s_id'];
$sis_id = $_POST['sis_id'];
$s_date = securite_bdd(utf8_decode($_POST['s_date']));
$s_dent = securite_bdd(utf8_decode($_POST['s_dent']));
$inami_id = securite_bdd(utf8_decode($_POST['inami_id']));
$s_rem = securite_bdd(utf8_decode($_POST['s_rem']));
$s_hono = securite_bdd($_POST['s_hono']);
$s_pay = securite_bdd(utf8_decode($_POST['s_pay']));
$s_dentiste = securite_bdd(utf8_decode($_POST['s_dentiste']));
$s_asd = securite_bdd(utf8_decode($_POST['s_asd']));
$s_medic = securite_bdd(utf8_decode($_POST['s_medic']));

$sql="update `soins` set `sis_id` = $sis_id, `s_date` = '$s_date', `s_dent` = '$s_dent', `inami_id` = '$inami_id',`s_rem` = '$s_rem',`s_hono` = $s_hono,`s_pay` = '$s_pay', `s_dentiste` = '$s_dentiste', `s_asd` = '$s_asd',`s_medic` = '$s_medic'	where s_id = $s_id";
echo $sql;	
$rs = mysql_query($sql);
if ($rs){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('msg'=>$sql));
}
?>