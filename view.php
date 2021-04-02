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
 	<select class="select" name="progOpt" id="progOptJS">
	 <option value="" selected disabled hidden> 
          Program
    </option>
	<optgroup label="Diploma">
	<option value="dit">Diploma in Internet and Computing Technology (DIT)</option>
	<option value="dcy">Diploma in Cyber Security (DCY)</option>
	<option value="ddm">Diploma in Digital Media (DDM)</option>
	<option value="dgd">Diploma in Game Development (DGD)</option>
	<option value="dbc">Dipolama in Business Computing (DBC)</option>
	</optgroup>
	</select>
	
	<select class="select" name="intOpt" id="intOptJS">
	 <option value="" selected disabled hidden> 
          Intake
    </option>
	<optgroup label="2019">
	<option value="jan_2019">Jan</option>
	<option value="apr_2019">April</option>
	<option value="aug_2019">August</option>
	</optgroup>
	<optgroup label="2020">
	<option value="jan_2020">Jan</option>
	<option value="apr_2020">April</option>
	<option value="aug_2020">August</option>
	</optgroup>
	<optgroup label="2021">
	<option value="jan_2021">Jan</option>
	<option value="apr_2021">April</option>
	<option value="aug_2021">August</option>
	</optgroup>
	</select>
	
	<select class="select" name="semOpt" id="semOptJS">
	 <option value="" selected disabled hidden> 
          Select Your Semester
    </option>
	<optgroup label="Year 1" >
	<option value="y1s1">Semester 1</option>
	<option value="y1s2">Semester 2</option>
	<option value="y1s3">Semester 3</option>
	</optgroup>
	<optgroup label="Year 2">
	<option value="y2s1">Semester 1</option>
	<option value="y2s2">Semester 2</option>
	<option value="y2s3">Semester 3</option>
	</optgroup>
	<optgroup label="Year 3">
	<option value="y3s1">Semester 1</option>
	
	</optgroup>
	</select>


	<div class="subIcon">
	<input class="myButton" type="submit" name="submit" value="Submit"  />
		
	</div>  <!--return false to prevent js DOM disapear-->
</form>

<table width="100%" border="1" style="border-collapse:collapse;">
<thead>
<tr><th><strong>No</strong></th><th><strong>Code</strong></th><th><strong>Name</strong></th><th><strong>Start</strong></th><th><strong>End</strong></th><th><strong>Day</strong></th><th><strong>Venue</strong></th><th><strong>Edit</strong></th><th><strong>Delete</strong></th></tr>
</thead>
<tbody>
<?php
$program=$intake=$sem="";
    if(isset($_POST['progOpt'])&&isset($_POST['intOpt'])&&isset($_POST['semOpt'])){
		$program = $_POST['progOpt'];
		$intake = $_POST['intOpt'];
		$sem = $_POST['semOpt'];
		
	}else  if(isset($_GET['Program'])&&isset($_GET['Intake'])&&isset($_GET['Sem'])){
		$program = $_GET['Program'];
		$intake = $_GET['Intake'];
		$sem = $_GET['Sem'];
	}
	 if($program!=""&&$intake!=""&&$sem!=""){
$count=1;
$sel_query="Select * from ".$program."_".$intake."_".$sem." ORDER BY Code desc;";
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
<a href="edit.php?Code=<?php echo $row["Code"]; ?>&Program=<?php echo $program; ?>&Intake=<?php echo $intake; ?>&Sem=<?php echo $sem; ?>">Edit</a> </td> 
<td align="center"> 
<a onclick="return confirm('Are you sure you want to delete this item?'); "href="delete.php?Code=<?php echo $row["Code"]; ?>&Program=<?php echo $program; ?>&Intake=<?php echo $intake; ?>&Sem=<?php echo $sem; ?> ">Delete</a> </td></tr>
	<?php $count++; } } ?>
							
</tbody>
</table>
</div>
</div>
</body>
</html>
