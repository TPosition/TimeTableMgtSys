<!-- INSERT YOUR PHP CODES BELOW THIS POINT -->
<?php
	require_once "config.php";
	$username = $password = $confirm_password = "";
	$username_err = $password_err = $confirm_password_err = "";
	$userType = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		if (empty(trim($_POST["username"]))){
			$username_err = "Please enter a username.";
		}
		
		else{
			$sql = "SELECT username FROM users WHERE username = ?";
			
			if ($stmt = mysqli_prepare($link,$sql)){
				mysqli_stmt_bind_param($stmt,"s",$param_username);
				
			$param_username = trim($_POST["username"]);
			
			if (mysqli_stmt_execute($stmt)){
				
				mysqli_stmt_store_result($stmt);
				
				if (mysqli_stmt_num_rows($stmt) == 1){
					$username_err = "This username is already taken.";
				}
				
				else{
					$username = trim($_POST["username"]);
				}
			}
			
			else{
				echo "Oops! Something went wrong. Please try agin later.";
				}
			}
		mysqli_stmt_close($stmt);
		}
		
		if (empty(trim($_POST["password"]))){
			$password_err = "Please enter a password.";
		}
		
		elseif (strlen(trim($_POST["password"]))< 6){
			$password_err = "Password must have atleast 6 characters.";
		}
		
		else{
			$password = trim($_POST["password"]);
		}
		
		if (empty(trim($_POST["confirm_password"]))){
			$confirm_password_err = "Please confirm password.";
		}
		
		else{
			$confirm_password = trim($_POST["confirm_password"]);
			if (empty($password_err) && ($password != $confirm_password)){
				$confirm_password_err = "Password did not match.";
			}
		}
		
		if (empty($username_err) && empty ($password_err) && empty($confirm_password_err)){
			echo "error";
			$userType = $_POST["userType"];
			$sql = "INSERT INTO users (username,password,user_type) VALUE (?,?,?)";

			
			if ($stmt = mysqli_prepare ($link,$sql)){
				mysqli_stmt_bind_param($stmt,"sss",$param_username,$param_password,$userType);
				
				$param_username = $username;
				$param_password = password_hash($password, PASSWORD_DEFAULT);
				
				if(mysqli_stmt_execute($stmt)){
					
					if($userType=='lecturer'){


 $tabSql="CREATE TABLE `$username` (
  `Code` varchar(100) PRIMARY KEY,
  `Name` varchar(255) NOT NULL,
  `Start` time NOT NULL,
  `End` time NOT NULL,
  `Day` text NOT NULL,
  `Venue` varchar(20) NOT NULL
)";
mysqli_query($link, $tabSql) or die(mysqli_error());

					}
					
					header("location: admin.php"); //html > php
				}
				else{
				
					echo "Something went wrong. Please try again later.";
				}
			}
			
			mysqli_stmt_close($stmt);
		}
		
		mysqli_close($link);
	}
	?>

 <!-- WARNING: DO NOT EDIT CODES BELOW THIS POINT -->
 
  
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="login.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>User Type</label> <br>
	<select class="select" name="userType">
	<option value="student">Student</option>
	<option value="lecturer">Lecturer</option>
	<option value="admin">Admin</option>
	</optgroup>
	</select>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
			<div class="position" >
			<center><a  style="text-decoration: none;  " class="abutton button" href="admin.php">Back to Dashboard</a>
			</div>
        </form>
    </div>    
</body>
</html>