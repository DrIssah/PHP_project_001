<?php

// start session
session_start();

// check if session is set
if(isset($_SESSION['admin_email'])){

// include connection file and the custom function files
include('includes/db_config.php');
include('includes/CustomFunctions.php');

// check if user clicks the add button
if(isset($_POST['add'])){

// take the value of the form inputs
$bk_author = $_POST['bk_author'];

//check if author alread exists in the database
if(getBookAuthor($bk_author) == 0){

  //if does not exists, then we add the author
$query = "INSERT INTO tblauthors (AuthorName) 
VALUES('$bk_author')";

//If the author is added successfully then we display the message
if(mysqli_query($conn,$query)){

    echo "<script>alert('Thank you,Book Author Has Been Added..!!');</script>";
	
}else{

  //if the query fails to execute, the we display the fail alert message
    echo "<script>alert('Failed To Add');</script>";
    echo mysqli_error($conn);

}
   
 }else{
 
 echo "<script>alert('Falied To Add,Author Name Exists');</script>";
 
 }  
}

}else{

  //if the session is not set then we redirect to the log in page
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
   
   <h1>Admin [Add Book Author]</h1>
   
   </div>
  
</div>


</div>

<div class="row">

 <?php include('navigation-div.php');?>
	

  
<div class="column middle">

  
  <div class="form-container" >
 
<div class="panel panel-info">

<div class="inner-heading">
 Add New Book Author
</div>

<div class="form-controls">

<!-- add author form-->
<form role="form" method="post" action="AddBookAuthor.php">


<div class="form-group">

<label>Enter Book Author Name</label><br>
 
 <!-- Author text field-->
<input  type="text" name="bk_author" placeholder="Book Author Name" required autocomplete="off"  />

</div>

<!-- submit button-->
 <input type="submit" name="add" value="Add Author To My List">
 
</form>
</div>

</div>


</div>
  <!-- End Of author form Form -->
  
  </div>

<div class="footer-section" style="float:left;">
<p>&copy; mynamesAtweb.com</p>
</div>

</div>
  
</body>
</html>
