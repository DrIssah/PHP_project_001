 <?php 
$servername = "localhost"; //specifies server name
$username = "library_user"; // user name used when logging in to the xammp database
$password = "123456"; //user password


$conn=mysqli_connect($servername, $username, $password) or die(mysql_error());  // connection to the database
$DB=mysqli_select_db($conn,'library') or die(mysql_error()); //select database to use
?>