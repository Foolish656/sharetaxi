<?php 
	session_start();
    require "connect.php";

    $success = "location: login.php";
    $failure = "location: register.php";
?>

<?php
//Checks if the regristration occurred
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])){
    
	$pass = $_POST['password'];
    
	//Hash the password using sha256
	$userPass = hash( "sha256", $_POST['password']);
    
    //Retrieves the current date
    $date = date('Y-m-d h:i:s');
    
    //Query to check if the email submitted is already in use
    $emailDraw = 
        "SELECT users.email FROM users WHERE users.email = '{$_POST['email']}'";
    if($drawn = mysqli_query($db, $emailDraw) or die("something went wrong! with email confirmation")){
        $checker = mysqli_num_rows($drawn);
        mysqli_free_result($drawn);
        if($checker){
            echo "<script>alert('Email is already in use!');</script>";
        }
    }
    //Adds the new account if there is no same email
    if(!$checker){
        $query = 
            "INSERT INTO users values(null, '{$_POST['username']}', '{$userPass}', '{$_POST['email']}', '{$date}', '0.0', '0.0')";
        $result = mysqli_query($db, $query) or die("something went wrong! in registration");
        $id = mysqli_insert_id($db);
        if($result){
            echo "alert('Account has been successfully created!');";
            header($success);
        }
    }    
}

?>
<!DOCTYPE html>
<html lang='en'>
<head>
<title>Share Taxi | Register</title>
<link rel='stylesheet' href='css/bootstrap.min.css'>
<style>
	.box{
		border: solid 1px black;
	}
</style>
</head>
<body>
<div class='container-fluid'>
	<div class='row'>
		<div class = 'col-md-4 col-sm-8 col-xs-12 col-md-offset-4 col-sm-offset-2 text-center'>

			<form method = 'POST' onsubmit = 'return checkForm(this)' action = 'register.php' class = 'box'>
                <p id = "demo"></p>
				<p>Username requires to have at least 3 characters restricted to numbers, letters, and underscores.</p>
				<p>Username: <input id = "user" type = 'text' name = 'username' placeholder = 'Username' required pattern="\w+"></p>
				<p>Email: <input id = "pass" type = 'email' name = 'email' placeholder = 'Email' required></p>
				<p>Password requires at least 8 characters and has to contain 1 uppercase, 1 lowercase, and 1 number.</p>
				<p>Password: <input id = "cpass" type = 'password' name = 'password' placeholder = 'Password' required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"></p>
				<p>Confirm Password: <input type = 'password' name = 'cPassword' placeholder = 'Password' required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"></p>
                <p><input type = 'submit' name = 'submit' class = 'btn btn-default'></p>
                <h6>Already have an account? <a href = 'login.php'>Login</a> here.</h6>
			</form>

		</div>
	</div>
</div>
</body>
    
<script type = "text/javascript">
        //More Checks ought to be added here
    
    //Checks the password to have at least 1 lowercase, 
    //1 uppercase, 1 number, and at least 8 characters long
    function checkPassword(str){
        // \d is equivalent to [0-9]
        var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
        return re.test(str);
    }   
    
    //Checker before submission of form
    function checkForm(form){
        
        //Checks for username of length 3 or more
        if(form.username.value.length < 3){
            alert("You cannot have a name that has less than 3 characters!");
            form.username.focus();
            return false;
        }
        
        //Restricts username to numbers, letters, and underscores
        re = /^\w+$/;
        if(!re.test(form.username.value)){
            alert("Username must contain only letters, numbers and underscores!");
            form.username.focus();
            return false;
        }
        
        //The same Username and Password checking
        if(form.password.value == form.username.value){
            alert("Username and Password should not be the same!");
            form.password.focus();
            return false;
        }        
        
        //Password Checking
        if(form.password.value == form.cPassword.value){
            if(!checkPassword(form.password.value)) {
                alert("The password you have entered is not valid!");
                form.password.focus();
                return false;
            }
        }else{
            alert("Error: Please check that you've entered and confirmed your password!");
            form.password.focus();
            return false;
        }
        if(form.password.value != form.cPassword.value){
            alert("Password and Confirm Password are not the same. Please try again!");
            form.password.focus();
            return false;
        }
        
        //Email checker
        if(form.email.value == "<?php echo $checker;?>"){
            alert("Email is already in use!");
            form.email.focus();
            return false;
        }
            
        //Answer when there are no problems met in the conditions
        return true;
            
    }
        
</script>
    
</html>
