<?php

  $con = mysql_connect("cias.rit.edu","nostalgia","miniM3K0dom");

 if (!$con){
        exit_status('Could not connect');
      }else{
        mysql_select_db("nostalgia", $con);
        
        $result = mysql_query("SELECT * FROM images  WHERE Approved = '1' ORDER BY RAND() LIMIT 0,1;");
        $row = mysql_fetch_array($result);
      }
      
      mysql_close($con);
	  $return = array(
      "message" => $row['message']
		);
		
		//echo print_r($return, true);
		echo json_encode($return);
?>