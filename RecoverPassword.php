<?php

//checks if the form input named register is clicked
if(isset($_POST['register'])){

   //is lke calling or including the file db_config.php so that we can use its variables
  //in simple language we want to use and access its variables
include('includes/db_config.php');

//get all the form input values and store them in the variables stated
$std_email = $_POST['std_email'];
$std_phone = $_POST['std_phone'];
$std_pass1 = $_POST['std_pass1'];
$std_id = $_POST['std_id'];

//Check if email is  in use

$checkemail = "SELECT * FROM tbl_students WHERE Email = '$std_email' AND MobileNumber = '$std_phone' AND StudentID = '$std_id' ";

//executing the sql statement
$results=mysqli_query($conn,$checkemail) or die(mysqli_error($conn));

//checks the number of rows returned by the query execution above
$num_emails =mysqli_num_rows($results);

//if num_emails is greater than zero then it means the email supplied is correct
//otherwise the email is incorrect and not in use
if($num_emails > 0){

   //encrypt password using md5
$std_pass1 = md5($std_pass1);

//an sql statement that updates user password 
$sql_query = "UPDATE tbl_students SET Password = '$std_pass1' WHERE StudentID = '$std_id'";

//checks if the update query works successfully, if yes the
//an appropriate message is displayed else an error message will be displayed
if(mysqli_query($conn,$sql_query)){

   echo "<script>alert('Password Has Been Changed,You Can Log In Using The New Paasword');</script>";

}else{

 echo "<script>alert('Sorry We Did not Find Your Email, Contact Admin');</script>";
 echo die(mysqli_error($conn));
}


}else{

echo "<script>alert('Sorry Wrong Information,Check Details Before Submission');</script>";

}

}



?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Library System</title>
<link rel="stylesheet" type="text/css" href="Styles/main_one.css">

<link rel="shortcut icon" type="image/x-icon" href="../images/books-stack-of-three (2).png" />
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

<div id="webicon" style="float:left;">

   <img src="images/books-stack-of-three (2).png" width="50" height="50" style="float:left">
   <div class="imagetext">
   <h1>LMS</h1>
   </div>
</div>

<div id="webtitle" style="float:left;">

   <div class="Heading">
   
   <h1>Restore Your LMS account</h1>
   
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
 Recover Account
</div>

<div class="form-controls">

<form role="form" method="post" action="RecoverPassword.php">
<div class="form-group">

<label>Student Id</label><br>
 
<input  type="text" name="std_id" placeholder="Student ID" required autocomplete="off"  />

</div>
<div class="form-group">

<label>Your Registration Email Address</label><br>
 
<input  type="email" name="std_email" placeholder="Email Address" required autocomplete="off"  />

</div>

<div class="form-group">

<label>Your Registered Mobile Number</label><br>
 
<input  type="number" name="std_phone" placeholder="Phone Number" required autocomplete="off"  />

</div>

<div class="form-group">

<label>Enter New Password</label><br>
 
<input  type="password" name="std_pass1" id="std_passone" placeholder="Password" required autocomplete="off"  />

</div>

<div class="form-group">

<label>Re Enter Password</label><br>
 
<input  type="password" name="std_pass2" id="std_passtwo" placeholder="Password" required autocomplete="off"  />

</div>

 <input type="submit" name="register" value="Recover My Account" onClick="return check_passwordmatch()">
 
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
