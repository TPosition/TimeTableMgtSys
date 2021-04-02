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
if(isset($_POST['new']) && $_POST['new']==1)
{
$Code=$_REQUEST['Code'];

	if($Code== 'IT201' )
	$Name='Intro. to Cryptography';
else if($Code== 'IT202' )
	$Name='Internetworking Security';
else if($Code== 'IT209' )
	$Name='Network Infrastructure';
else if($Code== 'IT304' )
	$Name='Intro. to Ethical Hacking and Intrusion Prevention';
else if($Code== 'IT305' )
	$Name='Forensics in Digital Security';
else if($Code== 'LG100' )
	$Name='Effective Communication';
else if($Code== 'MA100' )
	$Name='Computing Mathematics I';
else if($Code== 'MG200' )
	$Name='Intro. to Investment';
else if($Code== 'MM200' )
	$Name='Game Programming I';
else if($Code== 'MM210' )
	$Name='Web Application Development';
else if($Code== 'MM213' )
	$Name='Intro. to Motion Graphics';
else $Name='Error in Code';

$Start =$_REQUEST['Start'];
$End =$_REQUEST['End'];
	
$Day = $_REQUEST["Day"];
$Venue = $_REQUEST["Venue"];

$Program=$_REQUEST['Program'];
$Intake=$_REQUEST['Intake'];
$Sem=$_REQUEST['Sem'];
$Combine = $Program."_".$Intake."_".$Sem;
$clash=0;
$tolRun=0;

//check to avoid time clash
$query = "SELECT * FROM `$Combine` WHERE `$Combine`.Day='$Day'";
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

$ins_query="INSERT INTO `$Combine` (`Code`,`Name`,`Start`,`End`,`Day`,`Venue`) values ('$Code','$Name','$Start','$End','$Day','$Venue')";
if(mysqli_query($con,$ins_query)){
	$status = "New Record Inserted Successfully.</br></br><a href='view.php?Program=$Program&Intake=$Intake&Sem=$Sem'>View Inserted Record</a>";
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

 	<select class="select" name="Program" id="progOptJS" required>
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
	
	<select class="select" name="Intake" id="intOptJS" required>
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
	
	<select class="select" name="Sem" id="semOptJS" required>
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
	
<input type="hidden" name="new" value="1" />
<br>
<br>
<div class="enter">
<p style="left:1px; position:relative;">Subject Name:&nbsp;	<select name="Code" class="select-style" style="" required>
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
	<p style="left:12px; position:relative;">Start Time:&nbsp;<select name="Start" class="select-style" style="" required>
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
	<p style="left:14px; position:relative;">End Time:&nbsp;<select name="End" class="select-style" style="" required>
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

		<p style="left:30px; position:relative;">Day:&nbsp;<select name="Day" class="select-style" style="" required>
		 <option value="" selected disabled hidden> 
          Select the day of subject
    </option>
<option value='MON'>Monday</option>
	<option value='TUE'>Tuesday</option>
	<option value='WED'>Wednesday</option>	
	<option value='THU'>Thursday</option>
	<option value='FRI'>Friday</option>
</select></p>

	<p style="left:24px; position:relative;">Venue:&nbsp;<select name="Venue" class="select-style" style="" required>
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
