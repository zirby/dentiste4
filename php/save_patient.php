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


$sis = $_POST['sis'];
$nom = securite_bdd(utf8_decode($_POST['nom']));
$prenom = securite_bdd(utf8_decode($_POST['prenom']));
$adresse = securite_bdd(utf8_decode($_POST['adresse']));
$cp = securite_bdd(utf8_decode($_POST['cp']));
$commune = securite_bdd(utf8_decode($_POST['commune']));
$tel_fixe = securite_bdd(utf8_decode($_POST['tel_fixe']));
$tel_gsm = securite_bdd($_POST['tel_gsm']);
$notes = securite_bdd(utf8_decode($_POST['txtNotes']));
$medic = securite_bdd(utf8_decode($_POST['txtMedic']));
$prenomplus = securite_bdd(utf8_decode($_POST['prenomplus']));
//$photo = securite_bdd($_POST['photo']);
$national = securite_bdd(utf8_decode($_POST['nationalite']));
$date_naiss = securite_bdd(utf8_decode($_POST['date_naiss']));
$lieu_naiss = securite_bdd(utf8_decode($_POST['lieu_naiss']));

$date_reserv=date("Y-m-d");

$sql = "insert into `patients` (SIS, nom, prenom,adresse,cp,commune,tel_fixe,tel_gsm, notes, medic,prenomplus, national,date_naiss,lieu_naiss) 
		values(
			$sis, 
			'$nom',
			'$prenom',
			'$adresse',
			'$cp',
			'$commune',
			'$tel_fixe',
			'$tel_gsm', 
			'$notes',
			'$medic',
			'$prenomplus',
			'$national',
			'$date_naiss',
			'$lieu_naiss'
			)";
	//echo $sql;	
$rs = mysql_query($sql);
if ($rs){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('msg'=>$sql));
}
?>