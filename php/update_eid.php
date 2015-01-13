<?php
    $result = array();
    include 'conn.php';

$sis = isset($_GET['sis']) ? $_GET['sis'] : "1";

$dir    = '../data';
$files1 = scandir($dir);
$numnatfile='../data/'.$files1[3];

//echo $numnatfile;

if (file_exists($numnatfile)) {
    $xml = simplexml_load_file($numnatfile);
		$txtDateNaiss=(string)$xml->identity['dateofbirth'];
		$txtSis=substr($txtDateNaiss, 0,2).(string)$xml->identity['nationalnumber'];
		//$sis=substr($txtDateNaiss, 0,2).$sis;
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

    $sqlModif="UPDATE patients SET ";
    $sqlModif.="SIS=".$txtSis.",";
    $sqlModif.="nom='".strtoupper($txtNom)."',";
    $sqlModif.="prenom='".utf8_decode($txtPrenom)."',";
    $sqlModif.="adresse='".utf8_decode($txtAdr)."',";
    $sqlModif.="cp='".$txtCp."',";
    $sqlModif.="commune='".utf8_decode($txtCommune)."',";
    $sqlModif.="date_naiss='".$txtDateNaiss."',";
    $sqlModif.="national='".utf8_decode($txtNational)."',";
    $sqlModif.="prenomplus='".utf8_decode($txtPrenomPlus)."',";
    $sqlModif.="lieu_naiss='".utf8_decode($txtLieuNaiss)."',";
    $sqlModif.="photo='".$txtPhoto."'";
    $sqlModif.=" WHERE SIS=".$sis;	
	//echo  $sqlModif;

    if ($res = mysql_query($sqlModif)) {
    	
      if($txtSIS != $sis){
        $sqlModif="UPDATE soins SET ";
        $sqlModif.="sis_id=".$txtSis;
        $sqlModif.=" WHERE sis_id=".$sis;
        if ($res = mysql_query($sqlModif)) {
         echo json_encode(array('success'=>true));
			unlink($numnatfile);
        }
        else{
          echo json_encode(array('msg'=>'soin du patient non modifi&eacute;: '.$sqlModif));
        }
      }
      else{
        echo json_encode(array('msg'=>'patient non modifi&eacute;: '.$sqlModif));
      }
     }


	
} else {
	echo json_encode(array('msg'=>'Failed to open : '.$numnatfile));
}





?>

