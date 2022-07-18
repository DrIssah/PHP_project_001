<?php

//this page display the admins dashboard
//start session
session_start();

//check if session is set
if(isset($_SESSION['admin_email'])){

  //include important files
include('includes/db_config.php');
include('includes/CustomFunctions.php');

}else{

  //if session is not set then redirect page to the log in page
header('Location:../AdminLogin.php');

}

?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Library System</title>
<link rel="stylesheet" type="text/css" href="Styles/main_one.css">
<link rel="stylesheet" type="text/css" href="Styles/main_two.css">
<link rel="shortcut icon" type="image/x-icon" href="../images/books-stack-of-three (2).png" />
<script src="js/main.js" ></script>

<style>


.card {
  /* Add shadows to create the "card" effect */
  border:1px solid skyblue;
  transition: 0.3s;
  margin:3%;
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

</style>

</head>

<body>

<div class="header" style="overflow:hidden">

<div id="webicon">

   <img src="../images/books-stack-of-three (2).png" width="50" height="50" style="float:left">
   <div class="imagetext">
   <h1>Online LMS</h1>
   </div>
</div>

<div id="webtitle">

   <div class="Heading" style="width:90%;float:left;">
   
   <h1>Admin Dashbord</h1>
   
   </div>
   
   <div class="logout" style="width:10%;float:left;">
   
  <form name="logout" action="Adminlogout.php">
  <input type="submit" value="Log out">
   </form>
   </div>
  
</div>


</div>

<div class="row">


  <!-- Include the navigation bar --> 
 <?php include('navigation-div.php');?>
  
	

  
<div class="column middle">
  <!-- This card display the total number of books -->
    <div class="card" style="width:18%;float:left;">
	
  <img src="../images/books-stack-of-three (2).png" alt="Avatar" style="width:64px;height:64px">
  <div class="card_container">
    <h4><b>Number Of Books</b></h4> 
  <?php
  
  //sql query to get all the books in the database
	$query = "SELECT * FROM tblbooks";
  $results=mysqli_query($conn,$query) or die(mysqli_error($conn));
  
  //get the  number of books
    $rows = mysqli_num_rows($results);
	?>
    <label><?php echo $rows;?> Books</label> 
  </div>
</div>

<div class="card" style="width:18%; height:10%;float:left;">
	 <!-- This card display the number of books that are out of the library -->
  <img src="../images/books-stack-of-three (2).png" alt="Avatar" style="width:64px;height:64px">
  <div class="card_container" style="background-color:#CCFFFF">
    <h4><b>Books Borrowed</b></h4>
	<?php 
	$query = "SELECT * FROM tblbooks WHERE Status = 1";
  $results=mysqli_query($conn,$query) or die(mysqli_error($conn));
  //get the number of books
    $books = mysqli_num_rows($results);
	?> 
    <label><?php echo $books;?> Books</label> 
  </div>
</div>

<div class="card" style="width:18%; height:10%;float:left;">
	 <!-- This card displays the number of books available in the library Total books - borrowed books -->
  <img src="../images/books-stack-of-three (2).png" alt="Avatar" style="width:64px;height:64px">
  <div class="card_container" style="background-color:#9999FF">
    <h4><b>Books Available</b></h4> 
    <?php 

    //query to fetch the books that are in the library currently
	$query = "SELECT * FROM tblbooks WHERE Status = 0";
  $results=mysqli_query($conn,$query) or die(mysqli_error($conn));
  
  //get the number of books
    $books = mysqli_num_rows($results);
	?> 
    <label><?php echo $books;?> Books</label> 
  </div>
</div>

<div class="card" style="width:18%; height:10%;float:left;">
	 <!-- This card display the number of authors added in the database -->
  <img src="../images/document.png" alt="Avatar" style="width:64px;height:64px">
  <div class="card_container" style="background-color:#00CCFF">
    <h4><b>Authors</b></h4> 
    <?php
    
    // query to fecth all the added authors from the tblauthors
	$query = "SELECT * FROM tblauthors";
  $results=mysqli_query($conn,$query) or die(mysqli_error($conn));
  
  //get the number of authors
    $authors = mysqli_num_rows($results);

    //display the number of authors on the page
	?> 
    <label><?php echo $authors;?> Authors</label> 
  </div>
</div>




<div class="card" style="width:18%; height:10%;float:left;">
 <!-- This card displays the number of book cetegories added in the database -->	
  <img src="../images/list.png" alt="Avatar" style="width:64px;height:64px">
  <div class="card_container" style="background-color:#CCCCCC">
    <h4><b>Categories</b></h4> 
    <?php
    
    //query to fetch all categories from the table categories
	$query = "SELECT * FROM tblbooks";
  $results=mysqli_query($conn,$query) or die(mysqli_error($conn));
  
  //get the number of categories
    $books = mysqli_num_rows($results);
    //display the umber of categories using the echo statement
	?> 
    <label><?php echo $books;?> Categories</label> 
  </div>
</div>




<div class="card" style="width:18%; height:10%;float:left;">
	 <!-- This card displays the number os users/ students registered-->
  <img src="../images/group-of-students.png" alt="Avatar" style="width:64px;height:64px">
  <div class="card_container" style="background-color:#FFCC66">
    <h4><b>Members</b></h4> 
    <?php 

    // query to fetch all the students records
  $query = "SELECT * FROM tbl_students";
  
  //execute the query
  $results=mysqli_query($conn,$query) or die(mysqli_error($conn));
  
  //get the number of rows in the results, which correspond to number of students registered
    $users = mysqli_num_rows($results);
	?> 
    <label><?php echo $users;?> Members</label>
  </div>
</div>

  <!-- end of the cards-->
  
  </div>

<div class="footer-section" style="float:left;">
<p>&copy; mynamesAtweb.com</p>
</div>

</div>
  
</body>
</html>
