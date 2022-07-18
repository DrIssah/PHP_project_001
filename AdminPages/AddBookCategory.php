<?php

//page used to add book categories
session_start();

//check if session is set
if(isset($_SESSION['admin_email'])){

  //include connection file and the custom function file
include('includes/db_config.php');
//this file has custom functions
include('includes/CustomFunctions.php');

//check if user has submitted the form
if(isset($_POST['add'])){

$bk_category = $_POST['bk_category'];

//Check if category name is alread in the database
if(getBookCategory($bk_category) == 0){

  //if not the we add the category
$query = "INSERT INTO tblcategory (CategoryName) 
VALUES('$bk_category')";

if(mysqli_query($conn,$query)){

  // display message once the category has been added successfully
    echo "<script>alert('Thank you,Book Category Has Been Added..!!');</script>";
	
}else{

  //display fail message once the book has failed to be added
    echo "<script>alert('Faied To Add');</script>";
    echo mysqli_error($conn);

}
   
 }else{
 
  //if the category exist then we do not allow duplicates, we dislay this message and category is not added
 echo "<script>alert('Failed To Add,Category Name Exists');</script>";
 
 }  
}

}else{

  //incase session is not set then we redirect user to log in
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
table {
  border-collapse: collapse;
  width: 100%;
  
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
  background-color: #4CAF50;
  color: white;
}

.formdiv{

   border:1px solid skyblue;
   width:100%;
   border-radius:5px;


}

.details-container{

  padding:5px;
  border:1px solid skyblue;

}

.alert {
  padding: 10px;
  background-color: skyblue;
  color: white;
  margin-top:5px;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}

select {
  
  padding: 10px 10px;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  font-size:16px;
  width: 80%;
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

   <div class="Heading">
   
   <h1>Admin [Add Book Category]</h1>
   
   </div>
  
</div>


</div>




<div class="row">

 <!-- Add Navigation Bar Here -->
 <?php include('navigation-div.php');?>
	

  
<div class="column middle">

  <!-- Add Book Category Form -->
  <div class="form-container" >
 
<div class="panel panel-info">

<div class="inner-heading">
 Add New Book Category
</div>

<div class="form-controls">

 <!-- Book Category Form -->

<form role="form" method="post" action="AddBookCategory.php">


<div class="form-group">

<label>Enter Book Category</label><br>
  <!-- Book Category Form Input -->
<input  type="text" name="bk_category" placeholder="Category Name" required autocomplete="off"  />

</div>


 <input type="submit" name="add" value="Add Name Category To My List">
 
</form>
</div>

</div>


</div>
  <!-- End Of book category form -->
  
  </div>

<div class="footer-section" style="float:left;">
<p>&copy; mynamesAtweb.com</p>
</div>

</div>
  
</body>
</html>
