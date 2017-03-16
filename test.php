<?php

include("sqlconn.php");
$to_user_id = mysqli_fetch_array( mysqli_query( getconn(), "SELECT user_id FROM users WHERE email = 'a@a.com'" ) )[0];

echo $_SESSION['user_id'];
echo $to_user_id;
$message = "Yo!";
echo mysqli_escape_string( getconn(), "a@a.com");

if( mysqli_query( getconn(), "INSERT INTO user_pm(`from_user_id`, `to_user_id`, `message`) VALUES(".$_SESSION['user_id'].", ".$to_user_id.", '".$message."')") ) {
	echo $to_user_id;
}


?>