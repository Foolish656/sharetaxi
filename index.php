<?php
   include('session.php');
	
	
	//will be changed in the future for cache login
    if(!isset($userId)){
        header("location: login.php");
    }
?>
