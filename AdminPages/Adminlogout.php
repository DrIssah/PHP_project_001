<?php
//start session
session_start(); 

// distroy the session
session_destroy(); // destroy session

//redirect the user to log in page
header("location:../index.php"); 
?>
