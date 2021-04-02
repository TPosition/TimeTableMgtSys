<?php

/*21/12 version
1. change the pdf icon & adjust position  sm do it
2. change simplify background to none		sm do it
3. Add subject option by JS -- on progress
*/
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unimytimetable";

$arr=[];
$addCode="";
if(isset($_POST['submit'])==false){
$_POST['progOpt'] = "";
$_POST['intOpt'] = "";
$_POST['semOpt'] = "";
$_POST['addOpt'] = "";

}
// Create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
 
if(isset($_POST['submit'])){

$progVal = $_POST['progOpt'];  
$intVal = $_POST['intOpt'];
$semVal = $_POST['semOpt'];
	if(isset($_POST['addOpt'])){
	$addVal	= $_POST['addOpt'];
	}
	else
	{
		$_POST['addOpt']= "none" ;
	}

$tfVal = 0;

$sql = "SELECT * FROM ".$progVal."_".$intVal."_".$semVal;


$result = mysqli_query($conn,$sql);
$arr = array();
$i=0;
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

		array_push($arr,$row);
    }
		
} else {
    echo "0 results";
	
}
$tfVal= 1;
$phpSubCode = "";
}



?> 
<!DOCTYPE html>
<html>
<head>
  <link href="home.css" rel="stylesheet"/>
  <script src="home.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|PT+Sans|Varela+Round&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/baa02f9c09.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script>


  <script src="jscolor.js"></script>
   <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="three.r92.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

  </head>

<body>

<table class="nav">

<tr>
	<td rowspan="2" width="8%"><img class="uniLogo" src="img\uniLogo.jpg"></td>
	<td style="margin:5%; font-family: 'PT Sans', sans-serif;"rowspan = "2" width="70%">&emsp;&emsp; TIMETABLE MANAGEMENT SYSTEM</td>
	<td rowspan = "2" valign="bottom"width="5%"><img class="userLogo" src="img\userIcon.png" ></td>
	<td width="10%" style="vertical-align:bottom; font-family: 'Varela Round', sans-serif;"><?php echo htmlspecialchars($_SESSION["username"]); ?></td>
	<td rowspan="2" width="10%" class="drop"><button onclick="myFunction()" class="dropbtn"></button><i class="fas fa-angle-down" style="position:relative; left:30px;font-size:40px; z-index:99;"></i>
	 <div id="myDropdown" class="dropdown-content">
	 <br>
	 <br>
	<a href="reset-password.php">Change Password</a>
	<a href="admin.php">Dashboard</a>
    <a href="logout.php">Log out&nbsp;<i class="fas fa-sign-out-alt"></i></a></td>
	</div>
</tr>
<tr>
	<td class="student" style="vertical-align:top; font-family: 'Open Sans Condensed', sans-serif;";  >Admin</td>
</tr>


</table>
<br /><br>
<form action="" method="post" onChange="changeSub();">
 	<select class="select" name="progOpt" id="progOptJS" required>
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
	
	<select class="select" name="intOpt" id="intOptJS" required>
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
	
	<select class="select" name="semOpt" id="semOptJS" required>
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
	<input class="myButton" type="submit" name="submit" value="submit" style="display:none;"  id="inputSubT" onclick="myFunc(); myfunc1();  return true;" />
	<input class="myButton" type="submit" name="submit" value="submit"  id="inputSubF" onclick="myFunc(); myfunc1(); return false;"/><i class="fas fa-file-upload"></i>
	<!--<input class="myButton secBut" type="submit" name="submit" value="submit"  id="inputSubF" onclick="myFunc(); myfunc1(); return false;"/> position problem, try put it to another form-->
		
	</div>  <!--return false to prevent js DOM disapear-->
</form>
	


	<br><br>
<br>

<div id = "complete">
<div id='cplmyTable'>
<!--for display-->
<table border='1'>
<thead>
<tr>
	<th colspan='22'> TIMETABLE </th>
</tr>
<tr class="tcolor">
	<td></td>
	<td>8.30 - 9.00</td>
	<td>9.00 - 9.30</td>
	<td>9.30 - 10.00</td>
	<td>10.00 - 10.30</td>
	<td>10.30 - 11.00</td>
	<td>11.00 - 11.30</td>
	<td>11.30 - 12.00</td>
	<td>12.00 - 12.30</td>
	<td>12.30 - 13.00</td>
	<td>13.00 - 13.30</td>
	<td>13.30 - 14.00</td>
	<td>14.00 - 14.30</td>
	<td>14.30 - 15.00</td>
	<td>15.00 - 15.30</td>
	<td>15.30 - 16.00</td>
	<td>16.00 - 16.30</td>
	<td>16.30 - 17.00</td>
	<td>17.00 - 17.30</td>
	<td>17.30 - 18.00</td>
	<td>18.00 - 18.30</td>
	<td>18.30 - 19.00</td>
</tr>
</thead>
<tr>
	
	<td style="padding: 13px 5px; font-size: 18px;" class ="days">Monday</td>
	<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
	<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
</tr>
<tr>
	<td style="padding: 13px 5px; font-size: 18px;" class ="days">Tuesday</td>
	<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
	<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
	
</tr>
<tr>
	<td style="padding: 13px 5px; font-size: 18px;" class ="days">Wednesday</td>
	<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
	<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
</tr>
<tr>
	<td style="padding: 13px 5px; font-size: 18px;" class ="days">Thursday</td>
	<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
	<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
</tr>
<tr>
	<td style="padding: 13px 5px; font-size: 18px;" class ="days">Friday</td>
	<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
	<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
	
</tr>
</table>


	<div class = "timeTable" id="time"></div>
	
</div>

<!--for excel export-->
	<table style="display:none;" id='exmyTable' border='1'>
<thead>
<tr>
	<th colspan='22'> TIMETABLE </th>
</tr>
<tr class="tcolor">
	<td></td>
	<td>8.30 - 9.00</td>
	<td>9.00 - 9.30</td>
	<td>9.30 - 10.00</td>
	<td>10.00 - 10.30</td>
	<td>10.30 - 11.00</td>
	<td>11.00 - 11.30</td>
	<td>11.30 - 12.00</td>
	<td>12.00 - 12.30</td>
	<td>12.30 - 13.00</td>
	<td>13.00 - 13.30</td>
	<td>13.30 - 14.00</td>
	<td>14.00 - 14.30</td>
	<td>14.30 - 15.00</td>
	<td>15.00 - 15.30</td>
	<td>15.30 - 16.00</td>
	<td>16.00 - 16.30</td>
	<td>16.30 - 17.00</td>
	<td>17.00 - 17.30</td>
	<td>17.30 - 18.00</td>
	<td>18.00 - 18.30</td>
	<td>18.30 - 19.00</td>
	
</thead>
<tr>
	
	<td style="padding: 13px 12px; font-size: 18px;" class ="days">Monday</td>
	<td id="000"><td id="010"><td id="020"><td id="030"><td id="040">
	<td id="050"><td id="060"><td id="070"><td id="080"><td id="090">
	<td id="100"><td id="110"><td id="120"><td id="130"><td id="140">
	<td id="150"><td id="160"><td id="170"><td id="180"><td id="190">
	<td id="200">
</tr>
<tr>
	<td style="padding: 13px 12px; font-size: 18px;" class ="days">Tuesday</td>
	<td id="001"><td id="011"><td id="021"><td id="031"><td id="041">
	<td id="051"><td id="061"><td id="071"><td id="081"><td id="091">
	<td id="101"><td id="111"><td id="121"><td id="131"><td id="141">
	<td id="151"><td id="161"><td id="171"><td id="181"><td id="191">
	<td id="201">	
</tr>
<tr>
	<td style="padding: 13px 12px; font-size: 18px;" class ="days">Wednesday</td>
	<td id="002"><td id="012"><td id="022"><td id="032"><td id="042">
	<td id="052"><td id="062"><td id="072"><td id="082"><td id="092">
	<td id="102"><td id="112"><td id="122"><td id="132"><td id="142">
	<td id="152"><td id="162"><td id="172"><td id="182"><td id="192">
	<td id="202">
</tr>
<tr>
	<td style="padding: 13px 12px; font-size: 18px;" class ="days">Thursday</td>
	<td id="003"><td id="013"><td id="023"><td id="033"><td id="043">
	<td id="053"><td id="063"><td id="073"><td id="083"><td id="093">
	<td id="103"><td id="113"><td id="123"><td id="133"><td id="143">
	<td id="153"><td id="163"><td id="173"><td id="183"><td id="193">
	<td id="203">
</tr>
<tr>
	<td style="padding: 13px 12px; font-size: 18px;" class ="days">Friday</td>
	<td id="004"><td id="014"><td id="024"><td id="034"><td id="044">
	<td id="054"><td id="064"><td id="074"><td id="084"><td id="094">
	<td id="104"><td id="114"><td id="124"><td id="134"><td id="144">
	<td id="154"><td id="164"><td id="174"><td id="184"><td id="194">
	<td id="204">
	
</tr>
</table><!--for excel-->

	<div class= "compImgIcon">
	<button id="convert" class = "imgButton" onclick="convert()"/>
      Convert&nbsp;to&nbsp;pdf&nbsp;
     </button>
	 <i class="far fa-file-pdf"></i>
	
	 
	<div id="result" style="display:none;">
         <!-- Result will appear be here -->
      </div>
	   </div>
	  
	  <div class="compExIcon">
	<input 
  type="button" 
  onclick="tableToExcel('exmyTable', 'name', 'myfile.xls')" 
  value="Export to Excel"
  class = "exButton"
	><i class="far fa-file-excel"></i>
	</div>
</div><!--complete-->
	
	



<center>
<div id="simplified" class="simp" style="display:none;">
	
	<div  id="block" class="hideTable">
	</div>
		<center>
	<div class="simPut">
	<div id="simInput">
	</div>	

	</div>
	</center>
	
	


</div>

</center>
<div class="stop" style="clear:both;">
<br><br>
	<div class="butn">
	<input id="toggle-on" class="toggle toggle-left" name="toggle" value="false" type="radio" onclick="switchOn()" checked>
	<label for="toggle-on" class="btn">Complete</label>
	<input id="toggle-off" class="toggle toggle-right" name="toggle" value="true" type="radio" onclick="switchOff()">
	<label for="toggle-off" class="btn">Simplified</label>
	    
	<div id="dropdiv" ondrop="drop(event)" ondragover="allowDrop(event)" class="remDrop">
			
			
	<form>
	<select id="mySelect" class="addSub" onChange="myOption()" style="height:25px;">
	<option value="" selected disabled hidden>Add Subject</option>
  <option  value="IT201">IT201 Intro. to Cryptography</option>
  <option  value="IT202">IT202 Internetworking Security</option>
  <option  value="IT209">IT209 Network Infrastructure</option>
  <option  value="IT304">IT304 Intro. to Ethical Hacking and Intrusion Prevention</option>
  <option  value="IT305">IT305 Forensics in Digital Security</option>
  <option  value="LG100">LG100 Effective Communication</option>
  <option  value="MA100">MA100 Computing Mathematics I</option>
  <option  value="MG200">MG200 Intro. to Investment</option>
  <option  value="MM200">MM200 Game Programming I</option>
  <option  value="MM210">MM210 Web Application Development</option>
  <option  value="MM213">MM213 Intro. to Motion Graphics</option>


</select>
	<div id="demo"></div>
	<input class="myButton secBut" type="submit" name="submit" value="submit"  onclick="myFunc(); myfunc1(); return false;"/>
</form>
    </div>

	</div>
	<div class="simpExport" id="simpEXHide" style="display:none;">
		<div class="simpExIcon">
<input 
  type="button" 
  onclick="tableToExcel('myTable', 'name', 'myfile.xls')" 
  value="Export to Excel"
  class = "exButton"
	> <i class="far fa-file-excel"></i>
	</div>
	<div class = "simpImgIcon">
	 <button id="newconvert" class = "imgButton" onclick="newconvert()">
      Convert&nbsp;to&nbsp;pdf
     </button>
	 <i class="far fa-file-pdf"></i>
	 
	<div id="newresult" style="display:none;">
         <!-- Result will appear be here -->
      </div>
	  </div>
	

	</div>

<div class="bird" style="position:absolute;"></div>
</body>
</html>
<script>

	//to keep select option value after submission
  document.getElementById('progOptJS').value = "<?php echo $_POST['progOpt'];?>";
  document.getElementById('semOptJS').value = "<?php echo $_POST['semOpt'];?>";
  document.getElementById('intOptJS').value = "<?php echo $_POST['intOpt'];?>";
  
function changeSub(){

 }
 
  
function showDown(){
	document.getElementById("downDown").style.display = "block";
}

var vo= [];
var xo;
function myOption(){

	 var x = document.getElementById("mySelect").value;
 
	if( x == "IT201" ){
		vo.push('IT201','Intro. To Cryptography','140000','170000','MON','3C.1');  
	}else if (x == "IT202"){
		vo.push('IT202','Internetworking Security','100000','130000','TUE','3D.1');
	}else if (x == "IT209"){
		vo.push('IT209','Network Infrastructure','100000','130000','WED','3D.1');
	}else if (x == "IT304"){
		vo.push('IT304','Intro. to Ethical Hacking and Intrusion Prevention','090000','120000','THU','3D.1');
	}else if (x == "IT305"){
		vo.push('IT305','Forensics in Digital Security','160000','190000','FRI','3D.3');
	}else if (x == "LG100"){
		vo.push('LG100','Effective Communication','110000','140000','MON','3C.1');
	}else if (x == "MA100"){
		vo.push('MA100','Computing Mathematics I','090000','120000','TUE','3D.2');
	}else if (x == "MG200"){
		vo.push('MG200','Intro. to Investment','150000','180000','WED','3D.1');
	}else if (x == "MM200"){
		vo.push('MM200','Game Programming I','110000','140000','THU','3C.3');
	}else if (x == "MM210"){
		vo.push('MM210','Web Application Development','110000','140000','FRI','3C.2');
	}else if (x == "MM213"){
		vo.push('MM213','Intro. to Motion Graphics','150000','180000','THU','3C.2');
	}
}

var dex=0;
	var clashAddCode=[];
function myFunc() {
	var compCode="";


	//receive php obj and convert to string
	var data = <?php echo json_encode($arr); ?>;
		//remove unwanted words in string
	var word = JSON.stringify(data);
	var loop = word.replace(/"Code"|"Name"|"Start"|"End"|"Day"|"Venue"|\[|\]|:|\{|\}|"/g,"");
	var array = loop.split(',');
	var noClash=[];
	var dayClash=0;
	var subNoClash=[];

	var clashOriCode="";
	var warnArr="";
	
	if(vo.length){
	for(var x=4;x<vo.length;x+=6){
		for(var y=4;y<array.length;y+=6){
				if((array[y-1]<=vo[x-2]&&array[y]==vo[x]) || (array[y-2]>=vo[x-1] &&array[y]==vo[x])||array[y]!=vo[x]){
					noClash++;
				}
				else{
					clashAddCode.push(vo[x-4]);
				}
			
			}
			
		}
	}

			//remove clashed subject
	if(clashAddCode!=""){
		for(x=0;x<vo.length;x++){
			for(y=0;y<clashAddCode.length;y++){
			if(vo[x]==clashAddCode[y]){
				warnArr= warnArr+"The selected subject "+vo[x]+" "+vo[x+1]+" start from "+vo[x+2]/100+" to "+vo[x+3]/100+" on "+vo[x+4]+" is clashed with your subject.";
				vo.splice(x,6);
				alert(warnArr);
			}
				
			}
			}
		}
	

console.log(vo);
	var array1 = array.concat(vo);

	
//create a div box and assign style by each loop
	while(array1.length){
						if(remSub.indexOf(array1[0])>-1)
				{

				}
	else{


		var div = document.createElement("button");
		
		div.setAttribute("class", "jscolor {valueElement:null,value:'ffffff'}"); 
		div.style.backgroundColor = "white";
		div.style.position ="absolute";
		div.style.color = "grey";
		div.style.height="19%";
		div.style.border = "1px solid grey";
		div.style.fontSize = "small";
		div.style.textAlign = "center";
		
//1. assign words 

		var remArr0 = array1[0].replace(/(")/g,"");
		var remArr1 = array1[1].replace(/(")/g,"");
		var remArr5 = array1[5].replace(/(")/g,"");
		div.innerHTML = remArr0+"<br>"+remArr1+"<br>"+remArr5;
	
//2. define left space
		//convert element of array from arr->string->remove quote->int
		var conStart = parseInt(array1[2].replace(/(")/g,""))/100;
		//declearation for left loop
		var moveL = 0;
		var t=0830;
        var ts = t.toString().padStart(4,0).charAt(2);
		var bug = 0;
		//loop to find left position
			while(bug<=20){



				
				if (t==conStart){					
					var Lpos = moveL*4.76;
				div.style.left = Lpos+"%";
				break;
				}
				
				else if	(ts == "3")
				{
				  t=t+70;
				  ts="0";
				  moveL++;
				}

				else if (ts=="0")
				{
				  t=t+30;
				  ts="3";
				  moveL++;
				}
				bug++;
				}

//3. define width
		//declearation for width loop
		var conEnd = (parseInt(array1[3].replace(/(")/g,"")))/100;
		var widthSpace = 0;
		//var widthStart=t;
		//ts = widthStart.toString().padStart(4,0).charAt(2);
		bug = 0;
		//loop to find width
			while(bug<=20){

				if (t==conEnd){				
					var wide = 4.76*widthSpace;
					div.style.width= wide+"%";
					break;
				}
				
			else if	(ts == "3")
            {
              t=t+70;
			  ts="0";
              widthSpace++;
            }

			else if (ts=="0")
            {
              t=t+30;
			  ts="3";
              widthSpace++;
            }
			bug++;
			}
		
//4.define height 
		//remove double quote to match the result
		var remArr = array1[4].replace(/(")/g,"");
			if (remArr == "MON")
				var topSpace = 0;
			else if (remArr == "TUE")
				 topSpace = 1;	
			else if (remArr == "WED")
				 topSpace = 2;
			else if (remArr == "THU")
				 topSpace = 3;
			else if (remArr == "FRI")
				 topSpace = 4;
		var totalTop = topSpace * 20.1;
		div.style.top = totalTop+"%";

		compCode=compCode+"<button onclick=\"remSubject(this.id);\" id=\"node"+dex+"\" draggable=\"true\" ondragstart=\"drag(event)\" class=\"jscolor {valueElement:null,value:'ffffff'}\" style=\"height:20%; border-color:grey; position:absolute; width:"+wide+"%; top:"+totalTop+"%; left:"+Lpos+"%; \">"+remArr0+"<br>"+remArr1+"<br>"+remArr5+"</button>"
		dex++;
		
				var compExId = (moveL*10) + topSpace;
				compExId = compExId.toString().padStart(3,'0');

				document.getElementById(compExId).innerHTML= remArr0+"<br>"+remArr1+"<br>"+remArr5;	
				
	}
		array1.shift();array1.shift();array1.shift();array1.shift();array1.shift();array1.shift();
		document.getElementById("time").innerHTML=compCode;	
	}
	}
	

function myfunc1(){	
		 var colorCode="";
		var monTab =0;
		var tueTab = 0;
		var wedTab=0;
		var thuTab=0;
		var friTab=0;
		var code="";
		//create simplified box
			//receive php obj and convert to string
	 data = <?php echo json_encode($arr); ?> ;
			//remove unwanted words in string
	 word = JSON.stringify(data);
	 loop = word.replace(/"Code"|"Name"|"Start"|"End"|"Day"|"Venue"|\[|\]|:|\{|\}|"/g,"");
	 array = loop.split(',');
		 var noClash=[];
	var dayClash=0;
	var subNoClash=[];

	var clashOriCode="";
	var warnArr="";
	
	if(vo.length){
	for(var x=4;x<vo.length;x+=6){
		for(var y=4;y<array.length;y+=6){
				if((array[y-1]<=vo[x-2]&&array[y]==vo[x]) || (array[y-2]>=vo[x-1] &&array[y]==vo[x])||array[y]!=vo[x]){
					noClash++;
				}
				else{
					clashAddCode.push(vo[x-4]);
				}
			
			}
			
		}
	}

			//remove clashed subject
	if(clashAddCode!=""){
		for(x=0;x<vo.length;x++){
			for(y=0;y<clashAddCode.length;y++){
			if(vo[x]==clashAddCode[y]){
				warnArr= warnArr+"The selected subject "+vo[x]+" "+vo[x+1]+" start from "+vo[x+2]/100+" to "+vo[x+3]/100+" on "+vo[x+4]+" is clashed with your subject.";
				vo.splice(x,6);
				alert(warnArr);
			}
				
			}
			}
		}
	

console.log(vo);
	var array1 = array.concat(vo);

		colorCode=colorCode+"<div id='myTable'><table id='imtable'><tr><td><table style= border='0'>";
		code = code+"<div><table><tr><td><table class='hideSimp' border=1>";
		for(var i=0;i<=50;i++)
		{
			if(array1[i]=="MON")
			{	
				if(monTab==0 )
				{
					monTab=1;
					code = code+"<tr><td>MON</td></tr>";
					dex++;
					colorCode=colorCode+"<tr><td><button  onclick=\"simpRemSubject(this.id);\" id=\"node"+dex +"\" draggable=\"true\" ondragstart=\"drag(event)\" class=\"jscolor {valueElement:null,value:'ffffff'}\" style=\"border:2px solid black; width:220px;\">MON</button></tr></td>";
				}

				if(remSub.indexOf(array1[i-4])>-1)
				{

				}
				else{
				code = code+"<tr><td>"+array1[i-2]/100+"-"+array1[i-1]/100+"<br>"+array1[i-4]+"<br>"+array1[i-3]+"<br>"+array1[i+1]+"</td></tr>";
				dex++;
				colorCode=colorCode+"<tr><td><button onclick=\"simpRemSubject(this.id);\"  id=\"node"+dex+"\" draggable=\"true\" ondragstart=\"drag(event)\" class=\"jscolor {valueElement:null,value:'ffffff'}\" style=\"border:2px solid black; padding:15px; height:120px; width:220px;\">"+array1[i-2]/100+"-"+array1[i-1]/100+"<br>"+array1[i-4]+"<br>"+array1[i-3]+"<br>"+array1[i+1]+"</button></tr></td>";
				}
			}
		}
		colorCode=colorCode+"</table><table border='0'>";
		code = code+"</table><table class='hideSimp' border='1'>";
		
		for(var i=0;i<=50;i++)
		{			
			if(array1[i]=="TUE")
			{
				if(tueTab==0 )
				{
					tueTab=1;
					code = code+"<tr><td>TUE</td></tr>";
					colorCode=colorCode+"<tr><td><button  onclick=\"simpRemSubject(this.id);\" id=\"node"+ dex+"\" draggable=\"true\" ondragstart=\"drag(event)\" class=\"jscolor {valueElement:null,value:'ffffff'}\" style=\"border:2px solid black; width:220px;\">TUE</button></tr></td>";
					dex++;
				}
				code = code+"<tr><td>"+array1[i-2]/100+"-"+array1[i-1]/100+"<br>"+array1[i-4]+"<br>"+array1[i-3]+"<br>"+array1[i+1]+"</td></tr>";
				colorCode=colorCode+"<tr><td><button  onclick=\"simpRemSubject(this.id);\"  id=\"node"+dex+"\" draggable=\"true\" ondragstart=\"drag(event)\" class=\"jscolor {valueElement:null,value:'ffffff'}\" style=\"border:2px solid black; padding:15px; height:120px; width:220px;\" >"+array1[i-2]/100+"-"+array1[i-1]/100+"<br>"+array1[i-4]+"<br>"+array1[i-3]+"<br>"+array1[i+1]+"</button></tr></td>";
				dex++;

			}

		}
		colorCode=colorCode+"</table><table border='0'>";
		code = code+"</table><table class='hideSimp' border='1'>";
		
		for(var i=0;i<=50;i++)
		{			
			if(array1[i]=="WED")
			{
				if(wedTab==0 )
				{ 
					wedTab=1;
					code = code+"<tr><td>WED</td></tr>";
					colorCode=colorCode+"<tr><td><button  onclick=\"simpRemSubject(this.id);\" id=\"node"+ dex+"\" draggable=\"true\" ondragstart=\"drag(event)\" class=\"jscolor {valueElement:null,value:'ffffff'}\" style=\"border:2px solid black; width:220px;\">WED</button></tr></td>";
					dex++;
				}
				code = code+"<tr><td>"+array1[i-2]/100+"-"+array1[i-1]/100+"<br>"+array1[i-4]+"<br>"+array1[i-3]+"<br>"+array1[i+1]+"</td></tr>";
				colorCode=colorCode+"<tr><td><button  onclick=\"simpRemSubject(this.id);\" id=\"node"+dex+"\" draggable=\"true\" ondragstart=\"drag(event)\" class=\"jscolor {valueElement:null,value:'ffffff'}\" style=\"border:2px solid black; padding:15px; height:120px; width:220px;\" >"+array1[i-2]/100+"-"+array1[i-1]/100+"<br>"+array1[i-4]+"<br>"+array1[i-3]+"<br>"+array1[i+1]+"</button></tr></td>";
				dex++;

			}

		}
		colorCode=colorCode+"</table><table border='0'>";
		code = code+"</table><table class='hideSimp' border='1'>";
		
		for(var i=0;i<=50;i++)
		{			
			if(array1[i]=="THU")
			{
				if(thuTab==0 )
				{ 
					thuTab=1;
					code = code+"<tr><td>THU</td></tr>";
					colorCode=colorCode+"<tr><td><button  onclick=\"simpRemSubject(this.id);\" id=\"node"+ dex+"\" draggable=\"true\" ondragstart=\"drag(event)\" class=\"jscolor {valueElement:null,value:'ffffff'}\" style=\"border:2px solid black; width:220px;\">THU</button></tr></td>";
					dex++;
				}
				code = code+"<tr><td>"+array1[i-2]/100+"-"+array1[i-1]/100+"<br>"+array1[i-4]+"<br>"+array1[i-3]+"<br>"+array1[i+1]+"</td></tr>";
				colorCode=colorCode+"<tr><td><button  onclick=\"simpRemSubject(this.id);\" id=\"node"+dex+"\" draggable=\"true\" ondragstart=\"drag(event)\" class=\"jscolor {valueElement:null,value:'ffffff'}\" style=\"border:2px solid black; padding:15px; height:120px; width:220px;\" >"+array1[i-2]/100+"-"+array1[i-1]/100+"<br>"+array1[i-4]+"<br>"+array1[i-3]+"<br>"+array1[i+1]+"</button></tr></td>";
				dex++;

			}

		}
		colorCode=colorCode+"</table><table border='0'>";
		code = code+"</table><table class='hideSimp' border='1'>";
		for(var i=0;i<=50;i++)
		{			
			if(array1[i]=="FRI")
			{
				if(friTab==0 )
				{ 
					friTab=1;
					code = code+"<tr><td>FRI</td></tr>";
					colorCode=colorCode+"<tr><td><button  onclick=\"simpRemSubject(this.id);\" id=\"node"+ dex+"\" draggable=\"true\" ondragstart=\"drag(event)\" class=\"jscolor {valueElement:null,value:'ffffff'}\" style=\"border:2px solid black;  width:220px;\">FRI</button></tr></td>";
					dex++;
				}
				code = code+"<tr><td>"+array1[i-2]/100+"-"+array1[i-1]/100+"<br>"+array1[i-4]+"<br>"+array1[i-3]+"<br>"+array1[i+1]+"</td></tr>";
				colorCode=colorCode+"<tr><td><button  onclick=\"simpRemSubject(this.id);\" id=\"node"+dex+"\" draggable=\"true\" ondragstart=\"drag(event)\" class=\"jscolor {valueElement:null,value:'ffffff'}\" style=\"border:2px solid black; padding:15px; height:120px; width:220px;\" >"+array1[i-2]/100+"-"+array1[i-1]/100+"<br>"+array1[i-4]+"<br>"+array1[i-3]+"<br>"+array1[i+1]+"</button></tr></td>";
				dex++;

			}

		}
		code = code+"</table></td></tr></table><table class='hideSimp' border=1></div>";
		colorCode=colorCode+"</table></td></tr></table></div>";
		
					var newCode = code.replace(/(<table class='hideSimp' border=1><\/table>)|(<table class='hideSimp' border=1>)$/gm,"");
					var newColorCode= colorCode.replace(/(<table border='1'><\/table>|<table class='hideSimp' border=1><\/table>)|(<table class='hideSimp' border=1>)$/gm,"");//remove unwanted table
					document.getElementById("block").innerHTML= newCode;

					document.getElementById('simInput').innerHTML= newColorCode;
					jscolor.installByClassName('jscolor');
					
					
					
					
	}

function switchOn() {
  document.getElementById("complete").style.display = "block";
  document.getElementById("simplified").style.display = "none";
  document.getElementById("simpEXHide").style.display = "none";
  
}



function switchOff() {

	document.getElementById("complete").style.display = "none";
  document.getElementById("simplified").style.display = "block";
  document.getElementById("simpEXHide").style.display = "block";
  


}

function allowDrop(ev)
{
ev.preventDefault();
}
function drag(ev)
{
ev.dataTransfer.setData("Text",ev.target.id);
}

var remString=[];
var remCons;
var remSub=[];
function drop(ev)
{
ev.preventDefault();
var data=ev.dataTransfer.getData("Text");
var el = document.getElementById(data);
el.parentNode.removeChild(el);
remString.push(el.outerHTML);

	for(let i=0;i<remString.length;i++)
	{
	}

}

			
$(document).ready(function(){
	

$( "#progOptJS,#semOptJS,#intOptJS" ).on( "change", function() {
	
  $( "#inputSubT,#botInputSubT" ).trigger( "click" );
  //$( "#botInputSubT" ).trigger( "click" );s
 
});

$( "#inputSubF" ).on( "click", function() {

 if($('#progOptJS,#semOptJS,#intOptJS,#mySelect').val() == null){

}
  

});
	




	
var element = $("#html-content-holder"); // global variable
var getCanvas; // global variable
 
    $("#btn-Preview-Image").on('click', function () {
         html2canvas(element, {
         onrendered: function (canvas) {
                $("#previewImage").append(canvas);
                getCanvas = canvas;
             }
         });
    });

	$("#btn-Convert-Html2Image").on('click', function () {
    var imgageData = getCanvas.toDataURL("image/png");
    // Now browser starts downloading it instead of just showing it
    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
    $("#btn-Convert-Html2Image").attr("download", "UNIMYtimeTable.png").attr("href", newData);
	});
	


});


function tableToExcel(table, name, filename) {
		
        let uri = 'data:application/vnd.ms-excel;base64,', 
        template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><title></title><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>',
        base64 = function(s) { return window.btoa(decodeURIComponent(encodeURIComponent(s))) },         format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; })}
        
        if (!table.nodeType) table = document.getElementById(table)
        var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}

        var link = document.createElement('a');
        link.download = filename;
        link.href = uri + base64(format(template, ctx));
        link.click();
}



		 




//make subject above appears a red box to click and delete the element
function remSubject(remElem){
	//red box declearation
	var button = document.createElement('button');
	button.innerHTML="<i style='position:relative; left:0px; top:0px;' class=\"fas fa-trash-alt\"></i>";
	button.style.position="absolute";
	button.style.bottom="50px";
	button.style.left="250px";
	button.style.backgroundColor="red";
	button.style.color="white";
	button.style.borderRadius="30px";
	button.style.width="30px";
	button.style.height="30px";
	button.style.zIndex="1000000";
	button.setAttribute("onclick", "remElement(this);"); 
	button.setAttribute("class", "remBut");
	document.getElementById(remElem).appendChild(button);
}

function simpRemSubject(remElem){
	//red box declearation
	var button = document.createElement('button');
	button.innerHTML="<i style='position:relative; left:0px; top:0px;' class=\"fas fa-trash-alt\"></i>";
	button.style.position="relative";
	button.style.bottom="125px";
	button.style.left="0px";
	button.style.backgroundColor="red";
	button.style.color="white";
	button.style.borderRadius="30px";
	button.style.width="30px";
	button.style.height="30px";
	button.style.zIndex="1000000";
	button.setAttribute("onclick", "remElement(this);"); 
	button.setAttribute("class", "remBut");
	document.getElementById(remElem).appendChild(button);
}
//remove element if the red box clicked
function remElement(element){

  if (confirm("Click OK to remove subject")) {
    element.parentNode.remove();
  } else {
		
  }

}
//make red box remove if not being clicked
$(document).mouseup(function(e) 
{
    var container = $(".remBut");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        container.hide();
    }
});



function convert() {
            html2canvas(document.getElementById('cplmyTable'), {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("Complete Table.pdf");
                }
            });
}
function newconvert() {
			
			html2canvas(document.getElementById('imtable'), {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("Simpified Table.pdf");
                }
            });
        }
	
</script>