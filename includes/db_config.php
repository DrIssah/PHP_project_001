<?php 
$servername = "localhost"; //server name
$username = "library_user"; //username
$password = "123456"; //password


$conn=mysqli_connect($servername, $username, $password) or die(mysql_error()); //connect to db
$DB=mysqli_select_db($conn,'library') or die(mysql_error()); //select the database file
?>