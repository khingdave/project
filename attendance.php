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

$colname_students = "-1";
if (isset($_SESSION['COURSE'])) {
  $colname_students = $_SESSION['COURSE'];
}
mysql_select_db($database_attendance, $attendance);
if(isset($_GET['performance'])){
	$query_students = "SELECT `SN`, `matric`, `course`, `attendance`, SUM(`attendance`) AS 'cnt',`datetime`  FROM attendance WHERE course ='".$colname_students."' group by `SN`, `matric`, `course`";
}else{
$query_students = sprintf("SELECT * FROM attendance WHERE course = %s ORDER BY datetime ASC", GetSQLValueString($colname_students, "text"));
}
$students = mysql_query($query_students, $attendance) or die(mysql_error());
//$row_students = mysql_fetch_assoc($students);
$totalRows_students = mysql_num_rows($students);


if(isset($_GET['CourseCode'])){

$CourseCode =$_GET['CourseCode'];

$qry=mysql_query("select * from `allstudent` where `COURSE`='".$CourseCode."'")or die(mysql_error());

while($r=mysql_fetch_assoc($qry)){
mysql_query("INSERT INTO `attendance`(`SN`,`matric`, `course`, `datetime`) VALUES ('".$r['SN']."','".$r['MATRIC']."','".$CourseCode."',CURDATE())")or die(mysql_error());	
}

// header('Location: showallinfo.php');
header('Location: http://192.168.4.1:801/GETATDFPS?CourseCode=' .$CourseCode);
}

if(isset($_GET['del'])){
	$del=$_GET['del'];
	mysql_query("delete from `attendance` where `id`='".$del."'")or die(mysql_error());
	echo'<script>window.location="attendance.php";</script>';
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
				<li><a href="#">Attendance</a></li>
			</ul>

		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Students Attendance</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                    <a href="attendance.php?CourseCode=<?php echo $_SESSION['COURSE'];?>" class="btn btn-success">Update <?php echo $_SESSION['COURSE'];?> Attendance </a>
                    <a href="attendance.php?performance=1" class="btn btn-warning">Attendance Performance</a>
                    <hr>
						<?php if(!isset($_GET['performance'])){?><table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead class="alert alert-primary">
							  <tr class="alert alert-primary">
								  <th>STUDENT ID</th>
								  <th>COURSE</th>
                                   <th>ATTENDANCE</th>
                                  <th>DATETIME</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody><?php while($row_students=mysql_fetch_assoc($students)){
							  
		//echo $namesdata;
							  ?>
							<tr>
								<td><?php echo $row_students['matric']; ?></td>
								<td class="center"><?php echo $row_students['course']; ?></td>
                                <td class="center"><?php echo $row_students['attendance']; if(isset($_GET['performance'])){?> <span class="label label-primary pull-right"><?php echo $row_students['cnt']; ?></span><?php }?></td>
								<td class="center"><?php $dat = date_create($row_students['datetime']);
echo date_format($dat, 'F j, Y'); ?></td>
								
								<td class="center">
									
									<a class="btn btn-danger" href="attendance.php?del=<?php echo $row_students['id'];?>">
										<i class="halflings-icon white trash"></i> 
									</a>
								</td>
							</tr>
							<?php }?>
						
						  </tbody>
					  </table>   
                               <?php }else{?>
                               <table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead class="alert alert-primary">
							  <tr class="alert alert-primary">
								  <th>STUDENT ID</th>
								  <th>COURSE</th>
                                   <th>ATTENDANCE</th>
                                   <th>TOTAL</th>
                                   <th>PERCENTAGE</th>
							  </tr>
						  </thead>   
						  <tbody><?php while($row_students=mysql_fetch_assoc($students)){
							  
		//echo $namesdata;
							  ?>
							<tr>
								<td><?php echo $row_students['matric']; ?></td>
								<td class="center"><?php echo $row_students['course']; ?></td>
                                <td class="center"><?php echo $row_students['cnt'];?></td>
                                <td class="center">24</td>

                                <td class="center"> <span class="label label-primary pull-right"><?php echo number_format($row_students['cnt']/24 * 100); ?> %</span></td>
							</tr>
							<?php }?>
						
						  </tbody>
					  </table>           <?php }?>
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
							  <label class="control-label" for="typeahead">Student ID </label>
							  <div class="controls">
								<input type="text" class="span6 typeahead" id="matric" name="matric" placeholder="Matric No">
								
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">Name</label>
							  <div class="controls">
								<input type="text" class="input-xlarge" id="names" name="names" placeholder="Name" >
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
								</select>
							  </div>
							</div>          
							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Course</label>
							  <div class="controls">
								<input name="course" type="text" class="input-large" placeholder="Course">
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
