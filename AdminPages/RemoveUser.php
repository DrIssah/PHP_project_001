<?php

//start session
session_start();

//check ifadmin session is set
if(isset($_SESSION['admin_email'])){

  //inlude files
include('includes/db_config.php');
include('includes/CustomFunctions.php');

//check if the submit button has been clicked
if(isset($_POST['delete'])){

  //get the student id
$std_id= $_POST['std_id'];

//sql statement to delete the student id
$query = "DELETE FROM tbl_students WHERE StudentId= '$std_id'";

//check if student exists
$check_stdid = Check_stdid($std_id);

//
if($check_stdid > 0){
//delete student if the supplied id is found
if(mysqli_query($conn,$query)){

  //if student record is deleted
    echo "<script>alert('Student Has Been Deleted');</script>";

}else{

  //when the delete statement fails

   echo "<script>alert('Failed To Delete Student');</script>";
   echo mysqli_error($conn);

}

}else{


  //when the student id is not found in the database
    echo "<script>alert('We Did Not Find That Student ID');</script>";

}



}else{


}	

}else{

  //redirect page to log in page if session is not set

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

<script>

function confirm_first(){

    if(window.confirm("Are You Sure You Want To Completely Remove User ?")){
	
	return  true;
	
	}else{
	
	
	return false;
	
	}


}

</script>

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
   
   <h1>Admin [Remove User]</h1>
   
   </div>
  
</div>


</div>

<div class="row">

 <?php include('navigation-div.php');?>
  
	

  
<div class="column middle">

  
  <div class="form-container" >
 
<div class="panel panel-info">

<div class="inner-heading">
 Remove User From My List
</div>

<div class="form-controls">

<!-- Delete user form -->
<form role="form" method="post" action="RemoveUser.php">

<div class="form-group">

<label>Enter Use Id (Student Id)</label><br>
 <!-- input control for student id -->
<input  type="text" name="std_id" placeholder="Student Id" required autocomplete="off"  />

</div>

<!-- submit button -->
 <input type="submit" name="delete" value="Delete User Completely" onClick="return confirm_first()">
 
</form>
</div>

</div>


</div>
  <!-- end of form -->
  
  </div>

<div class="footer-section" style="float:left;">
<p>&copy; mynamesAtweb.com</p>
</div>

</div>
  
</body>
</html>
