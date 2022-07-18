<?php
//check if the button form inpt is set, the input is set once user clicks it
if(isset($_POST['login'])){

  //is lke calling or including the file db_config.php so that we can use its variables
  //in simple language we want to use and access its variables
include('includes/db_config.php');


//getting values imputs from the form and store them in the respective variables

$email=$_POST['email'];
$password=$_POST['password'];

$password = md5($password);

//this sql statement selects all the stated records from tha students table where the Email and Password match the
//the provided email and password
$sql_query ="SELECT Email,Password,StudentId,Status FROM tbl_students WHERE Email='$email' and Password='$password'";

//executing query

$results=mysqli_query($conn,$sql_query) or die(mysqli_error($conn));

//lets get the number of rows in the results

$num_rows=mysqli_num_rows($results);

//check if number of rows is greater that zero, if rows are greater
//than zero then it means the user is registered, otherwise admin does not have an account
if($num_rows > 0){

  //this display a js alert message welcome  incase the password and username are correct
echo "<script>alert('Welcome');</script>";

       session_start();
     
       //stores student email in a global variable
	   $_SESSION['std_email']=$email;

     //redirects or open  new page, the student dashboard.php page
       header('Location:Student_dashbord.php');

}else{

  //incase no record returned by the query then it means the supplied
  //values are not correct hence wrong password or user name
echo "<script>alert('Sorry The Email and Password Is Incorrect');</script>";

}

}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Library System</title>

<link rel="stylesheet" type="text/css" href="Styles/main_one.css">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<script src="js/main.js" ></script>

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
   
   <h1>Welcome To Online LMS</h1>
   
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
 STUDENTS LOGIN
</div>
<div class="form-controls">

<form role="form" method="post" action="index.php">

<div class="form-group">
<label>Enter Email</label><br>
<input class="form-control" type="email" name="email" required autocomplete="off" />
</div>

<div class="form-group">

<label>Password</label><br>
 
<input class="form-control" type="password" name="password" required autocomplete="off"  />

</div>

<div class="form-group">

<a href="RecoverPassword.php" >Forgot Password</a>

</div>


 <input type="submit" name="login" value="Log In">
 
 
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
