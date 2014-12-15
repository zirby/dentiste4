<?php

    $result = array();
    include 'conn.php';

    /* pour le sort  */
    $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 's_date';  
    $order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';  
	
    /* where de recherche    */
    $searchSis = isset($_GET['sis_id']) ? $_GET['sis_id'] : 0;  
    $where=" and sis_id = ".$searchSis;   
    
    
    $sql = "SELECT s_id, s_date, inami_id, s_dent, s_rem, s_asd FROM `soins`  WHERE ".$where." order by ".$sort." ".$order; 
    $rs = mysql_query($sql);
    //echo $sql;
    $items = array();
    while($row = mysql_fetch_object($rs)){
        $myrow = array();
        $myrow = array('id'=>$row->s_id,
                        's_date'=>$row->s_date,
                        'inami_id'=>$row->inami_id,
                        's_rem'=>utf8_encode($row->s_rem),
                        's_dent'=>$row->s_dent,
                        's_asd'=>$row->s_asd
                        );
        array_push($items, $myrow);
    }
    $result["rows"] = $items;

    
    //echo $rs;
    echo json_encode($result);

?>