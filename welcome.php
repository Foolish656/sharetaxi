<?php
   include('session.php');

    if(!isset($userId)){
        header("location: login.php");
    }
	
	$sql = "SELECT * FROM pool WHERE user_id = '$userId'";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	
?>
<html>
   
   <head>
      <title>Welcome </title>
   </head>
   
   <body>
      <h1>Welcome <?php echo $loginUser; ?></h1> 
	  <?php
		if($count>0){
			$routeId = $row['routeId'];
			$sql = "SELECT * FROM route WHERE routeId = '$routeId'";
			$result2 = mysqli_query($db,$sql);
			$row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
			$_SESSION['poolId'] = $row['poolId'];
			echo '<div>
					<div>Route is : '.$row2['status'].'</div>
					<div><a href = "messaging.php">Message</a></div>
				</div>';
			// may be added later, cuz coordinates wouldn't exactly look appealing to the users 
			//<div>Route Origin is : ".$origin."</div>
			//<div>Route Destination is : ".$dest."</div>
		}
	  
	  ?>
		<h2><a href = "profile.php">Profile</a></h2>
        <h2><a href = "logout.php">Sign Out</a></h2>
        <h2><a href = "settings.php">Settings</a></h2>
   </body>
   
</html>
