<?php

//start session
session_start();

//include the connection
include('includes/db_config.php');

//check if student email is set
if(isset($_SESSION['std_email'])){

  //set student email to the variable email
$email = $_SESSION['std_email'];

//get User Details
$query = "SELECT * FROM tbl_students WHERE Email = '$email' ";

//execute the query

$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

//get the array of strings

$row=mysqli_fetch_assoc($results);

}else{

  //redirect toindex page if student email is not set
header('Location:index.php');

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
  /* styling the cards */
  border:1px solid skyblue;
  transition: 0.3s;
  margin:15px;
  border-radius:5px;
  text-align:center;
  padding-top:25px;
}

.card img{
/* styling card image   */
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

/* styling input of type text*/
input[type=text]{

    color:#000000;
	

}
/* styling input of type emai*/
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
     border-top:5px solid #660033;

}

</style>

</head>

<body>

<div class="header" style="overflow:hidden">
<!-- div contains the page logo -->
<div id="webicon">

   <img src="images/books-stack-of-three (2).png" width="50" height="50" style="float:left">
   <div class="imagetext">
   <h1>Online LMS</h1>
   </div>
</div>

<!--Div contain the title of the page -->
<div id="webtitle">

   <div class="Heading">
   
   <h1>Student Account [My Profile]</h1>
   
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

<!-- Creating form name Signupform method post -->
<form role="form" method="post" action="Signupform.php">

<div class="form-group">

<label>Full Name</label><br>
 <!-- creating an input element and adding value from the rsults query -->
<input  type="text" name="std_name" value ="<?php echo htmlspecialchars($row['FullName']); ?>" disabled />

</div>

<div class="form-group">

<label>Your Email Address</label><br>
 
 <!-- The email input and populating value from sql-->
<input  type="email" name="std_email"   value = "<?php echo htmlspecialchars($row['Email']); ?>"  disabled/>

</div>

<div class="form-group">

<label>Phone Number</label><br>
 
<input  type="number" name="std_phone" value ="<?php echo htmlspecialchars($row['MobileNumber']); ?>"  disabled/>

</div>

<div class="form-group">

<label>Student Id</label><br>
 
<input  type="text" value ="<?php echo htmlspecialchars($row['StudentId']); ?>"  disabled />

</div>

</form>
</div>

</div>


</div>

  <!-- end of the form -->
  
  </div>


</div>
  
</body>
</html>
