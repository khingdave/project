<?php
include('Connections/attendance.php');



// $sql = "SELECT * FROM AllStudent";
if(isset($_GET['ATD'])){
  $ATDS = str_split(str_replace(",", "", $_GET["ATD"]));
  //echo print_r($ATDS);
  for($d = 0; $d<49; $d++){

    $id = 100000+$d+1;
   //echo $ATDS[$d].'<br>';
    if($ATDS[$d] == '1'){
$sql = "UPDATE `attendance` SET attendance = '1' WHERE SN='" .$id."' and `course`='".$_GET['CC']."' and `datetime`= CURDATE()";
   //    echo $sql;
     mysql_query($sql,$attendance)or die(mysql_error());
	//  mysql_query("UPDATE `attendance` SET `attendance` = '1' WHERE `SN`='".$id."' and `course`='".$_GET['CC']."' and `datetime`='CURDATE()'", $attendance) or die(mysql_error());
 

      
    }
  }

header('Location: http://localhost/WEbfiles/showallatds.php?CC=' .$_GET['CC']);
}

?>
