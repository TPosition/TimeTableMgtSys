	<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: test12.php");
  exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $user_type = "";
$username_err = $password_err = $user_type_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password, user_type FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $user_type);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            if (strcmp($user_type, 'admin') == 0) {
                                session_start();
                                $_SESSION["loggedin"] = true;
                                $_SESSION["user_type"] = $user_type;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username; 
                                header("location: admin.php");       
                                }else if(strcmp($user_type, 'lecturer') == 0){
                                // Store data in session variables
                                session_start();
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;                            
                                
                                // Redirect user to welcome page
                                header("location: lecturer.php");
                                }else{
									session_start();
									$_SESSION["loggedin"] = true;
									$_SESSION["id"] = $id;
									$_SESSION["username"] = $username;                            
                                
                                // Redirect user to welcome page
									header("location: test17.php");
									
								}

                            }else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="login.css">
    <script src="home.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script> -->
    <style type="text/css">
      
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="logo">
        <img src="logo_unimy.jpg" alt="UNIMY">
    </div>
    <div class="login">
        <div class="name">
        <h4>UNIMY Timetable Management System</h4>
    </div>
        <form class="recaptchaForm" method="post" onsubmit="return submitUserForm();">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                    <div style="position:relative; left:2%"class="g-recaptcha" data-sitekey="6Le6bb4UAAAAANmRDE7nx1urCssitO2ns1eRDwSM" data-callback="verifyCaptcha"></div>   
            </div>            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div> 
   </div>
<script>
function submitUserForm() {
    var response = grecaptcha.getResponse();
    if(response.length == 0) {
        //document.getElementById('g-recaptcha-error').innerHTML = '<span style="color:red;">This field is required.</span>';
        alert("Please Check reCAPTCHA!");
        return false;
    }
    return true;
}
 
function verifyCaptcha() {
    document.getElementById('g-recaptcha-error').innerHTML = '';
}
</script>

</body>
</html> 
<!--
<script>
$(document).ready(function(){
$(".recaptchaForm").submit(function(event) {    

        var recaptcha = $("#g-recaptcha-response").val();
        if(recaptcha === "") {
            event.preventDefault();
            alert("Please Check Recaptcha");
    }
    event.preventDefault();
        $.post("submit.php",{
            "secret":"6Le6bb4UAAAAAKFpVE4pw0k2UsSTxTg8UMH4dBok",
            "response":recaptcha
        },function(ajaxResponse){
            console.log(ajaxResponse);
            });
    });
});
/*if ($_POST["g-recaptcha-response"]) {

// Input data
$secret = '6Le6bb4UAAAAAKFpVE4pw0k2UsSTxTg8UMH4dBok';
$response = $_POST['g-recaptcha-response'];

$url = "https://www.google.com/recaptcha/api/siteverify";

$post_data = http_build_query(
    array(
        'secret' => $secret,
        'response' => $response,
    )
);*/
</script> 