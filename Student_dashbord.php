<?php

//start session
//Stating session
session_start();

//checking if the global variable is set
if(isset($_SESSION['std_email'])){

  //including the connection files
include('includes/db_config.php');
include('includes/CustomFunctions.php');

//store the global variable to $std_email
$std_email = $_SESSION['std_email'];

//get student id by passing the email to the function
$std_id = getStudentId($std_email);

}else{

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
  /* create a box shaped element */
  border:1px solid skyblue;
  transition: 0.3s;
  margin:15px;
  border-radius:5px;
  text-align:center;
  padding-top:25px;
}

/* target image inside the cards */
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

/* adding padding,font color font size back color and text alignment on the footer section */
.footer-section {
    padding:25px 50px 25px 50px;
    color:#000;
    font-size:13px;
      background-color: #f7f7f7;
      text-align:right;
     border-top:5px solid #CC0066;

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

   <div class="Heading" style="width:90%">
   
   <h1>Student Account [My Dashbord]</h1>
   
   </div>
   
   <div class="logout" style="width:10%;float:left;">
   
  <form name="logout" action="UserLogout.php">
  <input type="submit" value="Log out" style="background-color:red;color:white;height:80%;">
   </form>
   </div>
  
</div>


</div>

<div class="row">

<?php include('navigation_menu.php');?>
	

  
<div class="column middle" style="padding:100px">


  <!-- First card which contains numbe of bookes borrowed by this student -->
    <div class="card" style="width:18%;float:left;">
	
  <img src="images/list.png" alt="Avatar" style="width:64px;height:64px">
  <div class="card_container">
    <h4><b>Books Borrowed</b></h4> 
    <?php
    //a query to return number of books issued to this student 
	$query = "SELECT * FROM tblissuedbookdetails  WHERE StudentId = '$std_id'";
	$results=mysqli_query($conn,$query) or die(mysqli_error($conn));
    $rows = mysqli_num_rows($results);
	?>
    <label><?php echo $rows;?> Books</label> 
  </div>
</div>


<!-- second card which contains numbe of bookes borrowed by this student and not yer returned -->
<div class="card" style="width:18%; height:10%;float:left;">
	
  <img src="images/books-stack-of-three (2).png" alt="Avatar" style="width:64px;height:64px">
  <div class="card_container">
    <h4><b>Books UnCleared</b></h4> 
    <?php 

    //retrive books borrowed and are not yet returned to the library
	$query = "SELECT * FROM tblissuedbookdetails WHERE StudentId = '$std_id' AND ReturnStatus = 1";
	$results=mysqli_query($conn,$query) or die(mysqli_error($conn));
    $rows = mysqli_num_rows($results);
	?>
    <label><?php echo $rows;?> Books</label> 
  </div>
</div>

  <!-- End of crds -->
  
  </div>
<!-- Footer Section -->
<div class="footer-section" style="float:left;">

<!--Paragraph on the footercan change this to what you want -->
<p>&copy; mynamesAtweb.com</p>
</div>

</div>
  
</body>
</html>
