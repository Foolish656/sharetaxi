<?php
   include('connect.php');
   session_start();
   
   //$user_check = $_SESSION['login_user'];

   $id = $_SESSION['id'];
   
   $ses_sql = mysqli_query($db,"select name, user_id from users where user_id = {$id}");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $loginSession = $row['name'];

   $userId = $row['userId'];
   
   if(!isset($_SESSION['loginUser'])){
      header("location:login.php");
   }
?>
