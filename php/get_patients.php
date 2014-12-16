<?php
    $result = array();
    include 'conn.php';


    /* pour le sort  */
    $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'nom';  
    $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
	
     /* where de recherche   */
     $where="";
	$donom = isset($_GET['txtNom']) ? $_GET['txtNom'] : "no"; 
	    if ($donom != "no" ) {
	        $where.=" and nom like '".$donom."%'";
	    } else {
	        $where.="";              
	    }           

     /* where de recherche   */
	$doprenom = isset($_GET['txtPrenom']) ? $_GET['txtPrenom'] : "no"; 
	    if ($doprenom != "no" ) {
	        $where.=" and prenom like '".$doprenom."%'";
	    } else {
	        $where.="";              
	    }           

     /* where de recherche   */
	$dotel = isset($_GET['txtTel']) ? $_GET['txtTel'] : "no"; 
	    if ($dotel != "no" ) {
	        $where.=" and tel_fixe like '".$dotel."%' or tel_gsm like '".$dotel."%'";
	    } else {
	        $where.="";              
	    }           
    $where=" and nom like 'dub%'";
    
    $sql = "SELECT * FROM `patients`  WHERE 1=1 ".$where." order by ".$sort." ".$order; 
    $rs = mysql_query($sql);
    //echo $sql;
    $items = array();
    while($row = mysql_fetch_object($rs)){
        $myrow = array();
        $myrow = array('sis'=>$row->SIS,
                        'nom'=>utf8_encode($row->nom),
                        'prenom'=>utf8_encode($row->prenom),
                        'adresse'=>utf8_encode($row->adresse),
                        'cp'=>utf8_encode($row->cp),
                        'commune'=>utf8_encode($row->commune),
                        'tel_fixe'=>utf8_encode($row->tel_fixe),
                        'txtNotes'=>utf8_encode($row->notes),
                        'txtMedic'=>utf8_encode($row->medic),
                        'prenomplus'=>utf8_encode($row->prenomplus),
                        'photo'=>$row->photo,
                        'nationalite'=>utf8_encode($row->national),
                        'date_naiss'=>utf8_encode($row->date_naiss),
                        'lieu_naiss'=>utf8_encode($row->lieu_naiss),
                        'tel_gsm'=>$row->tel_gsm
                        );
        array_push($items, $myrow);
    }
    $result["rows"] = $items;

    
    //echo $rs;
    echo json_encode($result);

?>