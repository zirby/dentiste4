<?php
    $result = array();
    include 'conn.php';

function EID2date($dt){
	$birthyear=substr($dt,0,4);
    $birthmonth=substr($dt,4,2);
    $birthday=substr($dt,6,2);
	return sprintf("%4d-%02d-%02d",$birthyear,$birthmonth,$birthday);
}

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


//$numnatfile='../data/'.$numnat.'.eid';
$dir    = '../data';
$files1 = scandir($dir);
$numnatfile='../data/'.$files1[3];


if (file_exists($numnatfile)) {
    $xml = simplexml_load_file($numnatfile);
		$txtDateNaiss=(string)$xml->identity['dateofbirth'];
		$txtSis=substr($txtDateNaiss, 0,2).(string)$xml->identity['nationalnumber'];
		$txtGender=(string)$xml->identity['gender'];
		$txtNom=(string)$xml->identity->name;
		$txtPrenom=(string)$xml->identity->firstname;
		$txtPrenomPlus=(string)$xml->identity->middlenames;
		$txtNational=(string)$xml->identity->nationality;
		$txtLieuNaiss=(string)$xml->identity->placeofbirth;
		$txtPhoto=(string)$xml->identity->photo;
		$txtAdr=(string)$xml->address->streetandnumber;
		$txtCp=(string)$xml->address->zip;
		$txtCommune=(string)$xml->address->municipality;

    $sqlAjout="INSERT INTO patients (SIS,nom,prenom,prenomplus,national,date_naiss,lieu_naiss,photo,adresse,cp,commune,tel_fixe) VALUES (";
    $sqlAjout.=$txtSis.",'".strtoupper($txtNom)."','".securite_bdd(utf8_decode($txtPrenom))."','".securite_bdd(utf8_decode($txtPrenomPlus))."','".securite_bdd(utf8_decode($txtNational))."','".EID2date($txtDateNaiss)."','".securite_bdd(utf8_decode($txtLieuNaiss))."','".$txtPhoto."','".securite_bdd(utf8_decode($txtAdr))."','".$txtCp."','".securite_bdd(utf8_decode($txtCommune))."',0)";
	//echo $txtSis;
	//echo substr($txtDateNaiss, 0,2);

    $res = mysql_query($sqlAjout);
    if($res){
      	echo json_encode(array('success'=>true));
		// je supprime le fichier
		unlink($numnatfile);
      }
      else {
      	echo json_encode(array('msg'=>'patient non ajout&eacute;: '.$sqlAjout));
      }


} else {
	echo json_encode(array('msg'=>'Failed to open : '.$numnat));
}





?>

