<?php require_once('Connections/attendance.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$namesdata ="";
$Name="";
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_students = "-1";
if (isset($_SESSION['COURSE'])) {
  $colname_students = $_SESSION['COURSE'];
}
mysql_select_db($database_attendance, $attendance);
$query_students ="SELECT * FROM allstudent WHERE COURSE = '".$colname_students."' ORDER BY NAME ASC";
$students = mysql_query($query_students, $attendance) or die(mysql_error());

$totalRows_students = mysql_num_rows($students);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
	 $sql =mysql_query("SELECT * FROM `allStudent` WHERE MATRIC ='".$_POST['matric']."'")or die(mysql_error());
	 if(mysql_num_rows($sql)>0){
		 echo'<script>alert("Oops! '.$_POST['matric'].' Student already exist...");</script>';
	 }else{
  $insertSQL = sprintf("INSERT INTO allstudent (MATRIC, NAME, `LEVEL`, COURSE) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['matric'], "text"),
                       GetSQLValueString($_POST['names'], "text"),
                       GetSQLValueString($_POST['level'], "text"),
                       GetSQLValueString($_POST['course'], "text"));

  mysql_select_db($database_attendance, $attendance);
  $Result1 = mysql_query($insertSQL, $attendance) or die(mysql_error());
   echo'<script>alert("'.$_POST['matric'].' Registered Successful...");</script>';
   echo'<script>window.location="dashboard.php";</script>';
	 }
}
if(isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
  $delete_id = $_GET['delete_id'];
  mysql_query("DELETE FROM `allStudent` WHERE `SN`='".$delete_id."'")or die(mysql_error());
    echo'<script>alert("'.$delete_id.' Deleted...");</script>';
   echo'<script>window.location="http://192.168.4.1:801/DELETEFPS/?=' .$delete_id.'";</script>';
	
  //header('Location: http://192.168.4.1:801/DELETEFPS/?=' .$delete_id);
  // header('Location: showallinfo.php');

}


?>
<?php include('header.php');?>
			
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="dashboard.php">Dashboard</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">Students</a></li>
			</ul>

		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>My Students</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon plus"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                    <a href="#" class="btn btn-primary btn-setting">Register Student</a>
                    <a href="http://192.168.4.1:801/ENROLLFPS/?=<?php $h ="SELECT * FROM allstudent WHERE COURSE = '".$colname_students."' ORDER BY NAME ASC";
$hj = mysql_query($h, $attendance) or die(mysql_error());
while($row = mysql_fetch_assoc($hj)){
$Name = $row["SN"] .",";
    $Name = $Name .str_replace(" ", ",", $row["NAME"]);
    $namesdata = ''.$namesdata .$Name .'&';	
}echo $namesdata;?>" class="btn btn-warning">Enroll FingerPrint</a>
                    <a href="http://192.168.4.1:801/DELETEFPS/?=9999" class="btn btn-danger">Format FingerPrint Database</a><hr>
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead class="alert alert-primary">
							  <tr>
								  <th>ID</th>
                                  <th>MATRIC NO</th>
								  <th>NAMES</th>
								  <th>LEVEL</th>
								  <th>COURSE</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody><?php while($row_students=mysql_fetch_assoc($students)){
							   
		//echo $namesdata;
							  ?>
							<tr>
								<td><?php echo $row_students['SN']; ?></td>
                                <td><?php echo $row_students['MATRIC']; ?></td>
								<td class="center"><?php echo $row_students['NAME']; ?></td>
								<td class="center"><?php echo $row_students['LEVEL']; ?></td>
								<td class="center">
									<span class="label label-success"><?php echo $row_students['COURSE']; ?></span>
								</td>
								<td class="center">
									<a class="btn btn-info" href="http://192.168.4.1:801/ENROLLFPS/?=<?php echo trim($row_students["SN"]).','.trim(str_replace(" ", ",",$row_students["NAME"])).'&';?>">
										<i class="halflings-icon white hand-left"></i>  
									</a>
									<a class="btn btn-danger" href="dashboard.php?delete_id=<?php echo $row_students['SN'];?>">
										<i class="halflings-icon white trash"></i> 
									</a>
								</td>
							</tr>
							<?php }?>
						
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
			
       

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
	<div class="modal hide fade" id="myModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Register Student</h3>
		</div>
		<form action="<?php echo $editFormAction; ?>" name="form" method="POST" enctype="multipart/form-data" class="form-horizontal"><fieldset><div class="modal-body">
			<p>
						  
							<div class="control-group">
							  <label class="control-label" for="typeahead">Matric No </label>
							  <div class="controls">
								<input type="text" class="input-xlarge" id="matric" name="matric" placeholder="Matric No" required>
								
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">Name</label>
							  <div class="controls">
								<input type="text" class="input-xlarge" id="names" name="names" placeholder="Name" required >
							  </div>
							</div>

							<div class="control-group">
							  <label class="control-label" for="fileInput">Level</label>
							  <div class="controls">
								<select name="level" class="input-xlarge" >
								  <option value="100">100</option>
								  <option value="200">200</option>
								  <option value="300">300</option>
								  <option value="400">400</option>
                                  <option value="500">500</option>
								</select>
							  </div>
							</div>          
							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Course</label>
							  <div class="controls">
								<input name="course" type="text" class="input-large" placeholder="Course" required>
							  </div>
							</div>
							<!--<div class="form-actions">
							 
							  <button type="reset" class="btn">Cancel</button>
							</div>-->
						  
						   </p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			 <button type="submit" class="btn btn-primary">Save changes</button>
		</div></fieldset>
		  <input type="hidden" name="MM_insert" value="form">
		</form>
	</div>
	
	<div class="clearfix"></div>
	
	<?php include('footer.php');?>
<?php
mysql_free_result($students);
?>
