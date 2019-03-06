<?php require_once('Connections/attendance.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO staff (staffid, password, `names`, course) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['matric'], "text"),
                       GetSQLValueString($_POST['Password'], "text"),
                       GetSQLValueString($_POST['names'], "text"),
                       GetSQLValueString($_POST['course'], "text"));

  mysql_select_db($database_attendance, $attendance);
  $Result1 = mysql_query($insertSQL, $attendance) or die(mysql_error());
  echo'<script>alert("Registered");</script>';

}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmadd")) {
  $updateSQL = sprintf("UPDATE staff SET staffid=%s, password=%s, `names`=%s, course=%s WHERE staffid=%s",
                       GetSQLValueString($_POST['staffid'], "text"),
                       GetSQLValueString($_POST['Password1'], "text"),
                       GetSQLValueString($_POST['names1'], "text"),
                       GetSQLValueString($_POST['course1'], "text"),
                       GetSQLValueString($_POST['staffid'], "text"));

  mysql_select_db($database_attendance, $attendance);
  $Result1 = mysql_query($updateSQL, $attendance) or die(mysql_error());
  echo'<script>alert("Updated");</script>';
}

$colname_students = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_students = $_SESSION['MM_Username'];
}
mysql_select_db($database_attendance, $attendance);
$query_students = sprintf("SELECT * FROM staff WHERE staffid = %s", GetSQLValueString($colname_students, "text"));
$students = mysql_query($query_students, $attendance) or die(mysql_error());
$row_students = mysql_fetch_assoc($students);
$totalRows_students = mysql_num_rows($students);


if(isset($_GET['del'])){
	$del=$_GET['del'];
	mysql_query("delete from `staff` where `id`='".$del."'")or die(mysql_error());
	echo'<script>window.location="profile.php";</script>';
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
				<li><a href="#">Profile</a></li>
			</ul>

		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Profile</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                    <a href="#" class="btn btn-success btn-setting">Register Staff </a>
                   
                    <hr>
					  <form action="<?php echo $editFormAction; ?>"  method="POST" enctype="multipart/form-data" class="form-horizontal" name="frmadd"><fieldset>
			<p>
						  
							<div class="control-group">
							  <label class="control-label" for="typeahead">Staff ID </label>
							  <div class="controls">
								<input type="text" class="input-xlarge" id="staffid" name="staffid" placeholder="Staff ID" value="<?php echo $row_students['staffid']?>" readonly>
								
							  </div>
							</div>
                            <div class="control-group">
							  <label class="control-label" for="date01">Password</label>
							  <div class="controls">
								<input type="password" class="input-xlarge" id="password1" name="Password1" placeholder="Password" value="<?php echo $row_students['password']?>" >
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">Name</label>
							  <div class="controls">
								<input type="text" class="input-xlarge" id="names1" name="names1" placeholder="Name" value="<?php echo $row_students['names']?>" >
							  </div>
							</div>

							       
							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Course</label>
							  <div class="controls">
								<input name="course1" type="text" class="input-large" placeholder="Course" value="<?php echo $row_students['course']?>">
							  </div>
							</div>
							<div class="form-actions">
							 
							<button type="submit" class="btn btn-primary">Save</button>
		</div></fieldset>
						  <input type="hidden" name="MM_update" value="frmadd">
	                  </form>
						  
						   </p>
		</div>          
					</div>
				</div><!--/span-->
			
			
			<?php $o = "SELECT * FROM staff ";
$qry = mysql_query($o, $attendance) or die(mysql_error());
//$ro = mysql_fetch_assoc($qry);?>
       <table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead class="alert alert-primary">
							  <tr>
								  <th>STAFF ID</th>
                                  
								  <th>NAMES</th>
								 
								  <th>COURSE</th>
								  
							  </tr>
						  </thead>   
						  <tbody><?php while($ro=mysql_fetch_assoc($qry)){
							   
		//echo $namesdata;
							  ?>
							<tr>
								<td><?php echo $ro['staffid']; ?></td>
                                <td><?php echo $ro['names']; ?></td>
								
								<td class="center">
									<span class="label label-success"><?php echo $ro['course']; ?></span>
								</td>
								
							</tr>
							<?php }?>
						
						  </tbody>
					  </table>      
</div><!--/row-->
	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
	<div class="modal hide fade" id="myModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Register Staff</h3>
		</div>
		<form action="<?php echo $editFormAction; ?>" name="form" method="POST" enctype="multipart/form-data" class="form-horizontal"><fieldset><div class="modal-body">
			<p>
						  
							<div class="control-group">
							  <label class="control-label" for="typeahead">Staff ID </label>
							  <div class="controls">
								<input type="text" class="input-xlarge" id="matric" name="matric" placeholder="Staff ID" required>
								
							  </div>
							</div>
                            <div class="control-group">
							  <label class="control-label" for="date01">Password</label>
							  <div class="controls">
								<input type="password" class="input-xlarge" id="password" name="Password" placeholder="Password" >
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">Name</label>
							  <div class="controls">
								<input type="text" class="input-xlarge" id="names" name="names" placeholder="Name" >
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
			 <button type="submit" class="btn btn-primary">Register</button>
		</div></fieldset>
		  <input type="hidden" name="MM_insert" value="form">
		</form>
	</div>
	
	<div class="clearfix"></div>
	
	<?php include('footer.php');?>
<?php
mysql_free_result($students);
?>
