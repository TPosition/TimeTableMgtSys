<?php
/*
Author: Javed Ur Rehman
Website: https://www.allphptricks.com/
*/

//try to redirect to edit page
 
require('db.php');
include("auth.php");
$Code=$_REQUEST['Code'];
$Program=$_GET['Program'];
$Intake=$_GET['Intake'];
$Sem=$_GET['Sem'];
$Combine = $Program."_".$Intake."_".$Sem;


$query = "SELECT * FROM `$Combine` WHERE $Combine.Code='$Code'"; 
$result = mysqli_query($con,$query) or die ( mysqli_error());
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Update Record</title>
<link rel="stylesheet" href="insert.css" />
</head>
<body>
<div class="form">
<div class="wrapper">
<center><a style="text-decoration: none; " class="abutton button" href="admin.php">Dashboard</a> |
<a style="text-decoration: none; " class="abutton button" href="insert.php">Insert Records (Student)</a> | 
<a style="text-decoration: none; " class="abutton button" href="view.php">View Records (Student)</a> | 
<a style="text-decoration: none; " class="abutton button" href="lectinsert.php">Insert Records (Lecturer)</a> | 
<a style="text-decoration: none; " class="abutton button" href="lview.php">View Records (Lecturer)</a> | 
<a style="text-decoration: none; " class="abutton button" href="logout.php">Logout</a>
<h1>Update Record</h1>
<?php
$status = "";
$clashErr="";
$clash=0;
$tolRun=0;
if(isset($_POST['new']) && $_POST['new']==1)
{
$oriCode =$_GET['Code'];
$Code=$_REQUEST['Code'];
$Name = $_REQUEST['Name'];
$Start =$_REQUEST['Start'];
$End =$_REQUEST['End'];
$Day = $_REQUEST["Day"];
$Venue = $_REQUEST["Venue"];

//check to avoid time clash
$query = "SELECT * FROM `$Combine` WHERE `$Combine`.Day='$Day'";
$result = mysqli_query($con,$query);
while($row = mysqli_fetch_assoc($result)) {

$subStart=str_replace(":", "", $row["Start"]);
$subEnd =  str_replace(":", "", $row["End"]);


if($subEnd<=$Start||$subStart>= $End||$row["Code"]==$Code){
	$clash++;
}
else {
	$clashErr = "The selected time {$Start} {$End} is clashed with<br> {$row['Name'] } {$row['Start']} {$row['End']}";
}
$tolRun++;
}
if($tolRun==$clash){
if($Start<$End){

$update="UPDATE `$Combine` SET `Code`='".$Code."', `Name`='".$Name."', `Start`='".$Start."', `End`='".$End."', `Day`='".$Day."',`Venue`='".$Venue."' WHERE $Combine.Code='$oriCode'";

mysqli_query($con, $update) or die(mysqli_error());
$status = "Record Updated Successfully. </br></br><a href='view.php?Program=$Program&Intake=$Intake&Sem=$Sem'>View Updated Record</a>";
echo '<p style="color:#FF0000;">'.$status.'</p>';
}
	else {
		$status = "The value of start time is higher than end time, please try again. </br></br><a href='edit.php?Code=$oriCode&Program=$Program&Intake=$Intake&Sem=$Sem'>Return To View Record</a>";
		echo '<p style="color:#FF0000;">'.$status.'</p>';
	}
}
	else{
		echo "<p style='color:#FF0000;'>$clashErr<br>Please Try Again.<br><a href='edit.php?Code=$oriCode&Program=$Program&Intake=$Intake&Sem=$Sem'>Return To Edit Record</a></p>";
		
	}
}else {
?>
<div>
<form name="form" method="post" action=""> 
<div class="enter">
<input type="hidden" name="new" value="1"/>
<input style="display:none;" name="oriCode" type="text" value="<?php echo $row['Code'];?>" />
<p style="display:none;"><input type="text" name="Code" placeholder="Enter Code" required value="<?php echo $row['Code'];?>" /></p>
<p style="display:none;"><input type="text" name="Name" placeholder="Enter Name" required value="<?php echo $row['Name'];?>" /></p>
<p style="text-align: center; vertical-align: middle; line-height: 50px; width:600px;height:50px;border:1px solid #000;">Subjec Name :&nbsp;&nbsp;<?php echo $row['Code'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['Name'];?></p>

	<p style="left:1px; position:relative;">Start Time :<select name="Start" class="select-style" style="">
	<option selected value='<?php echo $row['Start'];?>'><?php echo $row['Start'];?></option>
	<option value='083000'>8:30</option>
	<option value='090000'>9:00</option>
	<option value='093000'>9:30</option>	
	<option value='100000'>10:00</option>
	<option value='103000'>10:30</option>
	<option value='110000'>11:00</option>
	<option value='113000'>11:30</option>
	<option value='120000'>12:00</option>
	<option value='123000'>12:30</option>
	<option value='130000'>13:00</option>
	<option value='133000'>13:30</option>
	<option value='140000'>14:00</option>
	<option value='143000'>14:30</option>
	<option value='150000'>15:00</option>
	<option value='153000'>15:30</option>
	<option value='160000'>16:00</option>
	<option value='163000'>16:30</option>
	<option value='170000'>17:00</option>
	<option value='173000'>17:30</option>
	<option value='180000'>18:00</option>
	<option value='183000'>18:30</option>
	<option value='190000'>19:00</option>
</select></p>
<div style="left:3px; position:relative;"><p>End Time :	<select name="End" class="select-style" style="">
	<option selected value='<?php echo $row['End'];?>'><?php echo $row['End'];?></option>
	
	<option value='090000'>9:00</option>
	<option value='093000'>9:30</option>	
	<option value='100000'>10:00</option>
	<option value='103000'>10:30</option>
	<option value='110000'>11:00</option>
	<option value='113000'>11:30</option>
	<option value='120000'>12:00</option>
	<option value='123000'>12:30</option>
	<option value='130000'>13:00</option>
	<option value='133000'>13:30</option>
	<option value='140000'>14:00</option>
	<option value='143000'>14:30</option>
	<option value='150000'>15:00</option>
	<option value='153000'>15:30</option>
	<option value='160000'>16:00</option>
	<option value='163000'>16:30</option>
	<option value='170000'>17:00</option>
	<option value='173000'>17:30</option>
	<option value='180000'>18:00</option>
	<option value='183000'>18:30</option>
	<option value='190000'>19:00</option>
</select></p></div>

	<p style="left:20px; position:relative;">Day :<select name="Day" class="select-style" style="">
	<option selected value='<?php echo $row['Day'];?>'><?php echo $row['Day'];?></option>
<option value='MON'>Monday</option>
	<option value='TUE'>Tuesday</option>
	<option value='WED'>Wednesday</option>	
	<option value='THU'>Thursday</option>
	<option value='FRI'>Friday</option>
</select></p>

	<p style="left:13px; position:relative;">Venue :<select name="Venue" class="select-style" style="">
	<option selected value='<?php echo $row['Venue'];?>'><?php echo $row['Venue'];?></option>
<option value='3C.1'>3C.1</option>
	<option value='3C.2'>3C.2</option>
	<option value='3C.3'>3C.3</option>	
	<option value='3C.4'>3C.4</option>
	<option value='3C.5'>3C.5</option>
	<option value='3C.5'>3C.5</option>
	<option value='3C.6'>3C.6</option>
	<option value='3D.1'>3D.1</option>
	<option value='3D.2'>3D.2</option>
	<option value='3D.3'>3D.3</option>
</select></p>
</div>
<p><input class="submit" name="submit" type="submit" value="Update" /></p>



</form>
<?php  echo "<a href='view.php?Program=$Program&Intake=$Intake&Sem=$Sem'>Back</a>" ?>
</center>
<?php } ?>

</div>
</div>
</div>
</body>
</html>
