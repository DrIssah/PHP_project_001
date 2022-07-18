<?php

//checks if the form input named register is clicked
if(isset($_POST['register'])){

  //is lke calling or including the file db_config.php so that we can use its variables
  //in simple language we want to use and access its variables
include('includes/db_config.php');

//store all provided form input values to the variables
$username = $_POST['std_name'];
$std_email = $_POST['std_email'];
$std_phone = $_POST['std_phone'];
$std_pass1 = $_POST['std_pass1'];
$std_id = $_POST['std_id'];

$std_pass1 = md5($std_pass1);

//Check if email is in use

$checkemail = "SELECT * FROM tbl_students WHERE Email = '$std_email'";

//execute the query
$results=mysqli_query($conn,$checkemail) or die(mysqli_error($conn));

//get the number of rows returned by the query execution
$num_emails =mysqli_num_rows($results);

//if number of rows is greater than zero
//then it means the email is new and is not used in the dtbase hence allow for registration
//otherwise cant be used since another student is alread using it
if($num_emails == 0){

//check student id
//student id is provided by the admin and for student to register then
//he/she gets an id from the admin
$sql_query = "SELECT * FROM availabestudentid WHERE StudentId = '$std_id'";

//execute query

$results=mysqli_query($conn,$sql_query) or die(mysqli_error($conn));

//check number of rows, > 0 means record exist
//For a user to register, his/her id should be in the database, admin adds these student id in the
//database

$num_rows = mysqli_num_rows($results);

if($num_rows > 0){

//this means user id is in the database// add new account for the student

$password=$std_pass1;

//This is a simple insert statement taht add add student details to the database...//registration
$query = "INSERT INTO tbl_students(StudentId,FullName,Email,MobileNumber,Password) VALUES ('$std_id','$username','$std_email','$std_phone','$password')";

      //if the student account is registered  successifully then
      //a message is displayed that account registered
			if(mysqli_query($conn,$query)){
      
        //Alert message displaying that registration is successfll
			echo "<script>alert('Registration Has Been Successful, You Can Log In');</script>";
			
			}else{
      
        //this display the error once the execution of the query above fails
			die(mysqli_error($conn));
			
			}    
}else{

  //display an error message 
 echo "<script>alert('Sorry We Did not Find Your Email, Contact Admin');</script>";
}


}else{

echo "<script>alert('Sorry The Email Number Is In Use');</script>";

}

}

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Library System</title>
<link rel="stylesheet" type="text/css" href="Styles/main_two.css">
<link rel="stylesheet" type="text/css" href="Styles/main_one.css">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<script src="js/main.js" ></script>

<script>

function check_passwordmatch(){
	
	var email_one = document.getElementById("std_passone").value;
	var email_two = document.getElementById("std_passtwo").value;
	
	if(email_one == email_two){
		
		return true;
		
		}else{
			
			alert("Password Do Not Match");
			return false;
			
			}
	
	
	}

</script>

</head>

<body>

<div class="header" style="overflow:hidden">

<div id="webicon">

   <img src="images/books-stack-of-three (2).png" width="50" height="50" style="float:left">
   <div class="imagetext">
   <h1>LMS</h1>
   </div>
</div>

<div id="webtitle">

   <div class="Heading">
   
   <h1>Create Account</h1>
   
   </div>
  
</div>


</div>

<div class="row">
 
 <div class="asidenav">
  <ul>
  
  <li><a href="index.php">Students</a></li>
  <li><a href="AdminLogin.php">Admin</a></li>
  <li><a href="Signupform.php">Sign Up</a></li>
  
  </ul>
  
  </div>
  
	

  
<div class="column middle">
  <!-- Log In form -->
 <div class="form-container" >
 
<div class="panel panel-info">

<div class="inner-heading">
 CREATE ACCOUNT
</div>

<div class="form-controls">

<form role="form" method="post" action="Signupform.php">
<div class="form-group">

<label>Student Id</label><br>
 
<input  type="text" name="std_id" placeholder="Student ID" required autocomplete="off"  />

</div>


<div class="form-group">

<label>Full Name</label><br>
 
<input  type="text" name="std_name" placeholder="Full Name" required autocomplete="off"  />

</div>

<div class="form-group">

<label>Your Email Address</label><br>
 
<input  type="email" name="std_email" placeholder="Email Address" required autocomplete="off"  />

</div>

<div class="form-group">

<label>Phone Number</label><br>
 
<input  type="number" name="std_phone" placeholder="Phone Number" required autocomplete="off"  />

</div>

<div class="form-group">

<label>Enter Password</label><br>
 
<input  type="password" name="std_pass1" id="std_passone" placeholder="Password" required autocomplete="off"  />

</div>

<div class="form-group">

<label>Re Enter Password</label><br>
 
<input  type="password" name="std_pass2" id="std_passtwo" placeholder="Password" required autocomplete="off"  />

</div>

 <input type="submit" name="register" value="Create Account" onClick="return check_passwordmatch()">
 
</form>
</div>

</div>


</div>
  <!-- End Of Log In Form -->
  
  </div>

<div class="footer-section" style="float:left;">
<p>&copy; mynamesAtweb.com</p>
</div>

</div>
  
</body>
</html>
