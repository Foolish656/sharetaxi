<?php
   include("connect.php");
   session_start();

   $error = "";
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $hashed = hash('sha256', $_POST['password']); 
      
      $myUsername = mysqli_real_escape_string($db,$_POST['username']);
      $myPassword = mysqli_real_escape_string($db,$hashed); 
      
      $sql = "SELECT user_id FROM users WHERE name = '$myUsername' AND password = '$myPassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      //$active = $row['active'];
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
       
      if($count == 1) {
      //Set ID and Username for session.php to access
         //session_register("myusername");
         $_SESSION['id'] = $row['userId'];
         $_SESSION['loginUser'] = $myUsername;
         
         header("location: welcome.php");
      }else {
         $error = "Your Login Name or Password is invalid!";
      }
   }
?>
<html>
   
   <head>
      <title>Login Page</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
   
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
            
            <div style = "margin:30px">
               
               <form action = "" method = "post">
                  <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit "/><br />
               </form>
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><a href='register.php'>Create Account</a></div>
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
               
            </div>
            
         </div>
         
      </div>

   </body>
</html>
