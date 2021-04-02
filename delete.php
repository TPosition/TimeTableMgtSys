<?php
require('db.php');

if ($_POST['confirm'] !== 1) {
$id=$_REQUEST['Code'];
$Program=$_GET['Program'];
$Intake=$_GET['Intake'];
$Sem=$_GET['Sem'];
$Combine = $Program."_".$Intake."_".$Sem;

$query = "DELETE FROM `$Combine` WHERE $Combine.Code='$id'"; 
echo $query;
$result = mysqli_query($con,$query) or die ( mysqli_error());
}else {
	
	
}

header("Location: view.php?Program=$Program&Intake=$Intake&Sem=$Sem"); 
?>
