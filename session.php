<?php
   include('connect.php');
   session_start();
   
   //$user_check = $_SESSION['login_user'];

   $id = $_SESSION['id'];
   
   $sesSql = mysqli_query($db,"select name, user_id from users where user_id = {$id}");
   
   $row = mysqli_fetch_array($sesSql,MYSQLI_ASSOC);
   
   $loginSession = $row['name'];

   $userId = $row['user_id'];
   
   if(!isset($_SESSION['loginUser'])){
      header("location:login.php");
   }
?>
