<?php
/*
Author: Javed Ur Rehman
Website: https://www.allphptricks.com/
*/
 
require('db.php');
include("auth.php");
$clashErr="";
$status = "";
$statusColor="";


$status = "";
if(isset($_REQUEST["submit"]))
{

$Code=$_REQUEST['Sname'];
$Start = $_REQUEST['Stime'];
$End =$_REQUEST['Etime'];
$Day =$_REQUEST['Dname'];
$Venue = $_REQUEST["Vname"];
$username=trim($_REQUEST['username']);


if($Code == 'IT201' )
	$Name='Intro. to Cryptography';
else if($Code == 'IT202' )
	$Name='Internetworking Security';
else if($Code == 'IT209' )
	$Name='Network Infrastructure';
else if($Code == 'IT304' )
	$Name='Intro. to Ethical Hacking and Intrusion Prevention';
else if($Code == 'IT305' )
	$Name='Forensics in Digital Security';
else if($Code == 'LG100' )
	$Name='Effective Communication';
else if($Code == 'MA100' )
	$Name='Computing Mathematics I';
else if($Code== 'MG200' )
	$Name='Intro. to Investment';
else if($Code == 'MM200' )
	$Name='Game Programming I';
else if($Code == 'MM210' )
	$Name='Web Application Development';
else if($Code == 'MM213' )
	$Name='Intro. to Motion Graphics';

$clash=0;
$tolRun=0;

$query = "SELECT * FROM `$username` WHERE `$username`.Day='$Day'";
$result = mysqli_query($con,$query);
while($row = mysqli_fetch_assoc($result)) {

$subStart=str_replace(":", "", $row["Start"]);
$subEnd =  str_replace(":", "", $row["End"]);


if($subEnd<=$Start||$subStart>= $End){
	$clash++;
}
else {
	$clashErr = "The selected time {$Start} {$End} is clashed with<br> {$row['Name'] } {$row['Start']} {$row['End']}";
}

$tolRun++;
}
if($tolRun==$clash){
//Check start not should not < end
if($Start<$End){

$ins_query="INSERT INTO `$username` (`Code`,`Name`,`Start`,`End`,`Day`,`Venue`) values ('$Code','$Name','$Start','$End','$Day','$Venue')";

		if(mysqli_query($con,$ins_query)){
			$status = "New Record Inserted Successfully.</br></br><a href='lview.php?username=$username'>View Inserted Record</a>";
			$statusColor="green";
		}else{
		$status = "The selected suject is repeated, please try again.";
		}
}
else{
	$status = "The value of start time is higher than end time, please try again.";
}
}
else {
	$status = "The selected time is clash, please try again.";
}

}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Insert New Record</title>
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

<div>
<h1>Insert New Record</h1>
<form name="form" method="post" action=""> 

 	<select class="select" name="username" id="progOptJS">
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
	
<input type="hidden" name="new" value="1" />
<br>
<br>
<div class="enter">

<p style="left:1px; position:relative;">Subject Name:&nbsp;<select name="Sname" class="select-style" style="">
		 <option value="" selected disabled hidden> 
          Select the Subject
    </option>
<option value='IT201'>IT201 Intro. to Cryptography</option>
	<option value='IT202'>IT202 Internetworking Security</option>	
	<option value='IT209'>IT209 Network Infrastructure</option>	
	<option value='IT304'>IT304 Intro. to Ethical Hacking and Intrusion Prevention</option>
	<option value='IT305'>IT305 Forensics in Digital Security</option>
	<option value='LG100'>LG100 Effective Communication</option>
	<option value='MA100'>MA100 Computing Mathematics I</option>
	<option value='MG200'>MG200 Intro. to Investment</option>
	<option value='MM200'>MM200 Game Programming I</option>
	<option value='MM210'>MM210 Web Application Development</option>
	<option value='MM213'>MM213 Intro. to Motion Graphics</option>
</select></p>
	<p style="left:12px; position:relative;">Start Time:&nbsp;<select name="Stime" class="select-style" style="">
		 <option value="" selected disabled hidden> 
          Select the start time of subject
    </option>
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
	<p style="left:14px; position:relative;">End Time:&nbsp;<select name="Etime" class="select-style" style="">
		 <option value="" selected disabled hidden> 
          Select the end time of subject
    </option>

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

	<p style="left:30px; position:relative;">Day:&nbsp;<select name="Dname" class="select-style" style="">
		 <option value="" selected disabled hidden> 
          Select the day of subject
    </option>
<option value='MON'>Monday</option>
	<option value='TUE'>Tuesday</option>
	<option value='WED'>Wednesday</option>	
	<option value='THU'>Thursday</option>
	<option value='FRI'>Friday</option>
</select></p>

	<p style="left:24px; position:relative;">Venue:&nbsp;<select name="Vname" class="select-style" style="">
		 <option value="" selected disabled hidden> 
          Select the venue of subject
    </option>
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

<p><input class="submit" name="submit" type="submit" value="Submit" /></p>

</center>
</form>
<p style="color:white; background-color:<?php 
if($statusColor=="green")
echo "#4CAF50";
else echo "red";	?>"><?php echo $status; echo $clashErr; ?></p>
</div>
</div>
</div>
</body>
</html>
