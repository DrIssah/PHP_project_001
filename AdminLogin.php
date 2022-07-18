<?php
//Start or resumes a seession enabling us to use and access $_session global variable
session_start();

//this tries to check if $_post['login'] variable is set or has been initialised
//this happens once user clicks the form input named 'login' which is the submit button
if(isset($_POST['login'])){

  //is lke calling or including the file db_config.php so that we can use its variables
  //in simple language we want to use and access its variables
include('includes/db_config.php');

//getting values of the form imputs from the form
//then we store them in the stated variables
$email=$_POST['email'];
$password=$_POST['password'];



//This is a sql query which tries to select or retrive all records from admin
// table and select only records in which their AdminEmail matches the provided email and 
//the password column record matches the provided password
$sql_query ="SELECT * FROM admin WHERE AdminEmail='$email' and Password='$password'";

//executing query by passing the query and the conn variable from the included file
//into the function mysqli_query the results are stored in the result variable

$results=mysqli_query($conn,$sql_query) or die(mysqli_error($conn));

//lets get the number of rows in the results

$num_rows=mysqli_num_rows($results);

//check if number of rows is greater that zero, if rows are greater
//than zero then it means the user is registered, otherwise admin does not have an account
if($num_rows > 0){

  //this display a js alert message welcome admin incase the password and username are correct
echo "<script>alert('Welcome Admin');</script>";

session_start();
     
//stores a the admin into a global variable which can be accessed in each page
	   $_SESSION['admin_email']=$email;

     //this redirects the log in page to another page thus opening another
     //page the admin dashboard
       header('Location:AdminPages/Admin-Dashbord.php');

}else{

  //when the password and username do not match then a message is displayed
  //wrong password or user name
echo "<script>alert('Sorry The Password Is Email and Password Is Incorrect');</script>";

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
   
   <h1>ADMIN LOGIN</h1>
   
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
 ADMIN LOGIN
</div>
<div class="form-controls">

<form role="form" method="post" action="AdminLogin.php">

<div class="form-group">
<label>Enter Email</label><br>
<input class="form-control" type="email" name="email" required autocomplete="off" />
</div>

<div class="form-group">

<label>Password</label><br>
 
<input class="form-control" type="password" name="password" required autocomplete="off"  />

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
