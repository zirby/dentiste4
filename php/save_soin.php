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


$sis_id = $_POST['sis'];
$s_date = securite_bdd(utf8_decode($_POST['s_date']));
$s_dent = securite_bdd(utf8_decode($_POST['s_dent']));
$inami_id = securite_bdd(utf8_decode($_POST['inami_id']));
$s_rem = securite_bdd(utf8_decode($_POST['s_rem']));
$s_hono = securite_bdd($_POST['s_hono']);
$s_pay = securite_bdd(utf8_decode($_POST['s_pay']));
$s_pay_le = securite_bdd($_POST['s_pay_le']);
$s_coul = securite_bdd(utf8_decode($_POST['s_coul']));
$s_dentiste = securite_bdd(utf8_decode($_POST['s_dentiste']));
$s_asd = securite_bdd(utf8_decode($_POST['s_asd']));
$s_medic = securite_bdd(utf8_decode($_POST['s_medic']));


$date_reserv=date("Y-m-d");

$sql = "insert into `soins` (s_id, sis_id, s_date,s_dent,inami_id,s_rem,s_hono,s_pay, s_pay_le, s_coul,s_dentiste, s_asd,s_medic) 
		values(
			null, 
			$sis_id,
			'$s_date',
			'$s_dent',
			'$inami_id',
			'$s_rem',
			$s_hono,
			'$s_pay', 
			'$s_pay_le',
			'$s_coul',
			'$s_dentiste',
			'$s_asd',
			'$s_medic'
			)";
	//echo $sql;	
$rs = mysql_query($sql);
if ($rs){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('msg'=>$sql));
}
?>