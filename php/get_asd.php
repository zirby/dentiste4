<?php

    $result = array();
    include 'conn.php';

    
function getASD($dentiste){
  $sql="select * from soins where s_dentiste = '".$dentiste."' order by s_id desc";
  //return $sql;
  $res=mysql_query($sql);
  if($res){
   while($rec=mysql_fetch_object($res)){
   
      if($rec->s_asd !="00*0000/00"){
          $cur_asd=explode("/",$rec->s_asd);
          $cur_asd[1]=$cur_asd[1]+1;
          if($cur_asd[1]<10) $cur_asd[1]="0".$cur_asd[1];
          return implode("/", $cur_asd);
      } 
   }	
   }
}

	
    /* where de recherche    */
    $dentis = isset($_GET['dentis']) ? $_GET['dentis'] : 'Z';  
    
    echo getASD($dentis);

?>