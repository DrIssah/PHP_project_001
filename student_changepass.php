<?php

//check if the submit button is clicked
if(isset($_POST['submit'])){

session_start();

//include the db file which has the connection details to the database.
include('includes/db_config.php');

//check if the student email has been set, this is done during log in 
if(isset($_SESSION['std_email'])){


  //stores the global variable value to the $email
$email = $_SESSION['std_email'];

//get User Details from the database
$query = "SELECT * FROM tbl_students WHERE Email = '$email' ";

//execute the query

$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

//get the array of strings

$row=mysqli_fetch_assoc($results);


//get the old password or the existing password from the table using the below statement
$old_pass = $row['Password'];


//get the password from the form and store it in the $pass variable
$pass = $_POST['current_pass'];

$pass = md5($pass);

$new_pass = $_POST['std_passone'];


//use md5 for encryption
$new_pass = md5($new_pass);


if($pass == $old_pass ){


  //then we use the update statement to update the password of the stated user
  $query_update = "UPDATE tbl_students SET Password = '$new_pass' WHERE Email = '$email'";
  
  if(mysqli_query($conn,$query_update)){

    //if the update statemet is executed successfull, then this message will be didsplayed
  
     echo "<script>alert('Password Has Been Changed...');</script>";
  
  }else{

    //alert message
  
  echo "<script>alert('Failed To Update');</script>";
  
  }

}else{

  //if wrong passwrod is used, therefore num of rows is zero

echo "<script>alert('Sorry Wrong Password Supplied');</script>";

}

}else{

  //when the std email is not set then the user is rediredted to the log in page
header('Location:index.php');

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
	
	var passone = document.getElementById("std_passone").value;
	var passtwo = document.getElementById("std_passtwo").value;
	
	if(passone == passtwo){
		
		return true;
		
		}else{
			
			alert("Password Do Not Match");
			return false;
			
			}
	
	
	}

</script>

<style>


.card {
  /* Add shadows to create the "card" effect */
  border:1px solid skyblue;
  transition: 0.3s;
  margin:15px;
  border-radius:5px;
  text-align:center;
  padding-top:25px;
}

.card img{

border-radius:5px;

}

/* On mouse-over, add a deeper shadow */
.card:hover {

  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

/* Add some padding inside the card container */
.card_container {

  padding: 1px 1px;
  background-color:skyblue;
}

input[type=text]{

    color:#000000;
	

}

input[type=email]{

    color:#333333;

}

input[type=number]{

    color:#333333;

}

.footer-section {
    padding:25px 50px 25px 50px;
    color:#000;
    font-size:13px;
      background-color: #f7f7f7;
      text-align:right;
     border-top:5px solid #000000;

}

</style>

</head>

<body>

<div class="header" style="overflow:hidden">

<div id="webicon">

   <img src="images/books-stack-of-three (2).png" width="50" height="50" style="float:left">
   <div class="imagetext">
   <h1>Online LMS</h1>
   </div>
</div>

<div id="webtitle">

   <div class="Heading">
   
   <h1>Student Account [Change Password]</h1>
   
   </div>
  
</div>


</div>

<div class="row">

<?php include('navigation_menu.php');?>
  
	

  
<div class="column middle">
  <!-- Log In form -->
    <div class="form-container" >
 
<div class="panel panel-info">

<div class="inner-heading" style="text-align:center;">
<img src="images/man.png" style="border-radius:50%;">
</div>

<div class="form-controls">

<form role="form" method="post" action="student_changepass.php">

<div class="form-group">

<label>Current Password</label><br>
 
<input  type="password" name="current_pass" placeholder = "Current Password"  />

</div>

<div class="form-group">

<label>New Password</label><br>
 
<input  type="password" name="std_passone" id="std_passone" placeholder = "New Password"  />
</div>

<div class="form-group">

<label>Re Enter Password</label><br>
 
<input  type="password" name="std_passtwo" id="std_passtwo" placeholder = "Re-Enter Password"  />

</div>

<input type="submit" name="submit" value="Change Password" onClick="return check_passwordmatch()">

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
