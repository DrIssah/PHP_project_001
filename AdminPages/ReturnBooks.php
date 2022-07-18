<?php

//start session
session_start();

//check if session is set
if(isset($_SESSION['admin_email'])){

  //iclude important files
include('includes/db_config.php');
include('includes/CustomFunctions.php');


//get the requied details passed to this page
if(isset($_GET['bkisbn'])){

   $bkisbn = $_GET['bkisbn'];
   $bkid = $_GET['bkid'];
   $sid = $_GET['sid'];
   
   $_SESSION['bkisbn'] = $bkisbn;
   $_SESSION['bkid'] = $bkid;
   $_SESSION['sid'] = $sid;
   
   

}else{

     $bkisbn = $_SESSION['bkisbn'];
     $bkid = $_SESSION['bkid'];
	 $sid = $_SESSION['sid'];
	 

}

//check if user submit the form details
if(isset($_POST['clear'])){

$bk_isbn = $bkisbn;
$std_id = $sid;

$book_id = $bkid;

//update the book details 
$query = "UPDATE tblbooks,tblissuedbookdetails SET ReturnStatus = 0,Status = 0 WHERE tblbooks.ISBNNumber = '$bk_isbn' AND  tblissuedbookdetails.StudentId = '$std_id'";


if(mysqli_query($conn,$query)){
	
	//display a message
	echo "<script>
	window.location.href='ViewRegisteredBooks.php';
	alert('Book Has Been Returned To Library');
	</script>";
	

}else{

  //when update statement fails
   echo "<script>alert('Failed To Add Data');</script>";

}




}


}else{

  //when session is not set then redirect page to log in page

header('Location:../AdminLogin.php');

}


?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Library System</title>
<link rel="stylesheet" type="text/css" href="../Styles/bootstrap-4.0.0-dist/css/bootstrap.min.css">
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
   
   <h1>Admin [Return Library Books]</h1>
   
   </div>
  
</div>


</div>

<div class="row">

 <?php include('navigation-div.php');?>
  
	

  
<div class="column middle">

  
  <div class="form-container" >
 
<div class="panel panel-info">

<div class="inner-heading">
 Return Book To Library
</div>

<div class="form-controls">
<!-- Return book form-->
<form role="form" method="post" action="ReturnBooks.php">

<div class="form-group">

<label>Book ISBN</label><br>
 <!-- display the isbn number to user -->
<input  type="text" name="bk_isbn" value ="<?php echo $bkisbn;  ?>" placeholder="Book ISBN Number" required autocomplete="ON" disabled  />

</div>

<div class="form-group">

<label>Enter Student ID</label><br>
<!-- display student id number-->
<input  type="text" name="std_id" placeholder="Student Id" value="<?php echo $sid; ?>" disabled />

</div>

<!-- submit button-->
 <input type="submit" name="clear" value="Clear Student">
 
</form>
</div>

</div>


</div>
  <!-- end of form-->
  
  </div>

<div class="footer-section" style="float:left;">
<p>&copy; mynamesAtweb.com</p>
</div>

</div>
  
</body>
</html>
