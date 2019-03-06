<?php
// *** Logout the current user.
$logoutGoTo = "index.php";
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['MM_Username'] = NULL;
$_SESSION['COURSE'] = NULL;
unset($_SESSION['MM_Username']);
unset($_SESSION['COURSE']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
?>
