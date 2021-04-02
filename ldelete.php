<?php
/*
Author: Javed Ur Rehman
Website: https://www.allphptricks.com/
*/

require('db.php');

$username=$_GET['username'];
$Code=$_REQUEST['Code'];


$query = "DELETE FROM `$username` WHERE `$username`.Code='$Code'"; 
echo $query;
$result = mysqli_query($con,$query) or die ( mysqli_error());

header("Location: lview.php?username=$username"); 
?>