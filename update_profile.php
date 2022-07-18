

<?php
//check if the button update is clicked
if(isset($_POST['submit'])){

  //start session
session_start();


//include the files needed for connection and other has the custom functions
include('includes/db_config.php');
include('includes/CustomFunctions.php');


//check if the global variable is set

if(isset($_SESSION['std_email'])){


  //store global variable value to the email variable
$email = $_SESSION['std_email'];

$stdid = getStudentId($email);

$updates = 'Your';
$updates_num = 0;
// this part updates the student name if student changes it

if(!empty($_POST['std_name'])){

$fullname = $_POST['std_name'];

//update sql statement query
$query = "UPDATE tbl_students SET FullName = '$fullname' WHERE StudentId = '$stdid'";


//check if the update is successifully
if(mysqli_query($conn,$query)){
  
     $updates = $updates." Name";
	 $updates_num = $updates_num + 1;
  
  }
}

//check if email is provided in the form
if(!empty($_POST['std_email'])){

$std_email = $_POST['std_email'];

//check if email is alread used by other student
$value = check_email($std_email,$stdid);

//if email is not used, then the student is allewed to use that email
if($value == 0){

$query = "UPDATE tbl_students SET Email = '$std_email' WHERE StudentId = '$stdid'";

if(mysqli_query($conn,$query)){
  
     $updates = $updates." Email";
	 $updates_num = $updates_num + 1;
	 $_SESSION['std_email'] = $std_email; 
  
  }
  
  }else{
  
  echo "<script>alert('Sorry The Email Is Used By Other Student');</script>";
  
  }
}

//update student phone number if it is provided
//this section will change student phone number if they hava provided a new phone number

if(!empty($_POST['std_phone'])){

$std_phone = $_POST['std_phone'];

$query = "UPDATE tbl_students SET MobileNumber = '$std_phone' WHERE StudentId = '$stdid'";

if(mysqli_query($conn,$query)){
  
     $updates = $updates." Mobile Phone";
	 
	 $updates_num = $updates_num+1;
  
  }
}

if($updates_num > 0){
echo "<script>alert('".$updates." (Updated)');</script>";

}else{

echo "<script>alert('Nothing Was Updated');</script>";
}

}else{

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
     border-top:5px solid #990000;

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
   
   <h1>Student Account [Update Profile]</h1>
   
   </div>
  
</div>


</div>

<div class="row">

<?php include('navigation_menu.php');?>
  
	

  
<div class="column middle">
 
    <div class="form-container" >
 
<div class="panel panel-info">

<div class="inner-heading" style="text-align:center;">
<img src="images/man.png" style="border-radius:50%;">
</div>

<div class="form-controls">
 <!-- creating form-->

<form role="form" method="post" action="update_profile.php">

<div class="form-group">

<label>Full Name</label><br>
 
<input  type="text" name="std_name" placeholder="Full Name"autocomplete="off"  />

</div>

<div class="form-group">

<label>Your Email Address</label><br>
 
<input  type="email" name="std_email" placeholder="Email Address" autocomplete="off"  />

</div>

<div class="form-group">

<label>Phone Number</label><br>
 
<input  type="number" name="std_phone" placeholder="Phone Number" autocomplete="off"  />

</div>


<input type="submit" name="submit" value="Update All Suplied Values">

</form>
</div>

</div>


</div>

  <!-- End Of  Form -->
  
  </div>



</div>
  
</body>
</html>
