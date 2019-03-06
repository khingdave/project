<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "AttendanceDB";

// strtolower()
// lcfirst()
// ucfirst()
// ucwords()

$Name = strtoupper($_POST['Name']);
$SName = ucfirst(strtolower($_POST['SName']));

$Name = $Name ." " .$SName;
// echo $Name ." " .$SName;
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// echo $Name;
if(isset($_POST['register'])){
  $sql = "SELECT * FROM AllStudent WHERE NAME =" ."'" .$Name ."'";
  // echo $sql;
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo "Error updating record: ";
    echo $Name;
    echo " User Already Exist";

  }else{

	$sql = "INSERT INTO AllStudent (NAME)
								VALUES ('$Name')
                  ON DUPLICATE KEY UPDATE SN=LAST_INSERT_ID(SN)";

  if ($conn->query($sql) === TRUE) {

    echo "Record updated successfully";
    // header('Location: showallinfo.php');
    header('Location: showallinfo.php');

	} else {
    echo "Error updating record: " . $conn->error;
		// header('Location: index.html');
	}
}

}

$conn->close();
?>
