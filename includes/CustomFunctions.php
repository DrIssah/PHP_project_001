<?php

//this function receive student email and returns the student id associated with that email

function getStudentId($email){

    //get the connection file
include('includes/db_config.php');

//select query
$query = "SELECT StudentId FROM tbl_students WHERE Email = '$email'";

//execute query
$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

$row = mysqli_fetch_assoc($results);

$Student_id = $row['StudentId'];

//return student id
return $Student_id;
}

//check email
//ckecks if student email belongs to the student id supplied
function check_email($email,$sid){

    //include conection file
include('includes/db_config.php');

//select query
$query = "SELECT * FROM tbl_students WHERE Email = '$email' AND StudentId != '$sid'";

//execute query
$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

//get number of rows returned
$num_rows = mysqli_num_rows($results);

return $num_rows;

}
?>

