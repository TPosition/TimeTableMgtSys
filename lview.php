<?php
/*
Author: Javed Ur Rehman
Website: https://www.allphptricks.com/
*/
 
require('db.php');
include("auth.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>View Records</title>

<link rel="stylesheet" href="insert.css">
</head>
<body>
<div class="wrapper">
<div class="form">
<center><a style="text-decoration: none; " class="abutton button" href="admin.php">Dashboard</a> | 
<a style="text-decoration: none; " class="abutton button" href="insert.php">Insert Records (Student)</a> | 
<a style="text-decoration: none; " class="abutton button" href="view.php">View Records (Student)</a> | 
<a style="text-decoration: none; " class="abutton button" href="lectinsert.php">Insert Records (Lecturer)</a> | 
<a style="text-decoration: none; " class="abutton button" href="lview.php">View Records (Lecturer)</a> | 
<a style="text-decoration: none; " class="abutton button" href="logout.php">Logout</a>
<h2>View Records</h2>
</center>
<form action="" method="post" onChange="changeSub(); "style="float:left;">
 	
 	<select class="select" name="username" id="username">
	 <option value="" selected disabled hidden> 
          Lecturer Name
    </option>
	<?php
	$username=$_POST['username'];
	$sql="Select * from users WHERE user_type='lecturer'";
	echo $sql;
	$result = mysqli_query($con,$sql);
	while($row = mysqli_fetch_assoc($result)) { ?>
	<option value="<?php echo $row['username'] ?> ">  <?php echo $row['username'] ?>   </option>
	<?php } ?>
	</select>
	
	<input class="myButton" type="submit" name="submit" value="Submit"  />
		
	 <!--return false to prevent js DOM disapear-->
</form>

<table width="100%" border="1" style="border-collapse:collapse;">
<thead>
<tr><th><strong>No</strong></th><th><strong>Code</strong></th><th><strong>Name</strong></th><th><strong>Start</strong></th><th><strong>End</strong></th><th><strong>Day</strong></th><th><strong>Venue</strong></th><th><strong>Edit</strong></th><th><strong>Delete</strong></th></tr>
</thead>
<tbody>
<?php
$username="";
    if(isset($_POST['username'])){
		$username = $_POST['username'];
		
	} else if(isset($_GET['username'])){
		
		$username = $_GET['username'];
	}
	if($username!=""){
$count=1;
$sel_query="Select * from ".$username.";";
$result = mysqli_query($con,$sel_query);
while($row = mysqli_fetch_assoc($result)) { ?>
<tr><td align="center"><?php echo $count; ?></td>
<td align="center"><?php echo $row["Code"]; ?></td>
<td align="center"><?php echo $row["Name"]; ?></td>
<td align="center"><?php echo $row["Start"]; ?></td>
<td align="center"><?php echo $row["End"]; ?></td>
<td align="center"><?php echo $row["Day"]; ?></td>
<td align="center"><?php echo $row["Venue"]; ?></td>
<td align="center"> 
<a href="ledit.php?Code=<?php echo $row["Code"]; ?>&username=<?php echo $username; ?>">Edit</a> </td> 
<td align="center"> 
<a onclick="return confirm('Are you sure you want to delete this item?'); " href="ldelete.php?Code=<?php echo $row["Code"]; ?>&username=<?php echo $username; ?>">Delete</a> </td></tr>
	<?php $count++; } } ?>
							
</tbody>
</table>
</div>
</div>
</body>
</html>
