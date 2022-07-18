<?php

// this page is used to add ned user to the system
session_start();

//check if the session is set
if(isset($_SESSION['admin_email'])){

  //iclude the connection and custom functions files
include('includes/db_config.php');
include('includes/CustomFunctions.php');

//check if user clicks or submit the form
if(isset($_POST['Add'])){

$std_id= $_POST['std_id'];

// query to add data to the database
$query = "INSERT INTO availabestudentid (StudentId) VALUES('$std_id')";

//check if student id is available/used
$check_stdid = Check_stdid_two($std_id);

//if the function returns zero, then the id is new
if($check_stdid == 0){

  //execute the insert query
if(mysqli_query($conn,$query)){

  //display message when the user id is added successifully
    echo "<script>alert('Student Id Has Been Added');</script>";

}else{

  //display fail message incase the student is not added
   echo "<script>alert('Failed To Add New Id');</script>";
   echo mysqli_error($conn);

}

}else{

  //display this message when the id alread exists in the database
    echo "<script>alert('ID alread Exists');</script>";

}



}else{


}	

}else{
//redirect user when the session is not set
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

 <!-- The scrip below has a function tah is called when the used submit a form. Just to confirm -->
<script>


function confirm_first(){

    if(window.confirm("Are You Sure You Want To Add This ID?")){
	
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
   
   <h1>Admin [Add Valid ID Numbers]</h1>
   
   </div>
  
</div>


</div>

<div class="row">

 <?php include('navigation-div.php');?>
  
	

  
<div class="column middle">

  
  <div class="form-container" >
 
<div class="panel panel-info">

<div class="inner-heading">
 Add New User From My List
</div>

<div class="form-controls">

 <!-- Add new user Form -->
<form role="form" method="post" action="AddNewUser.php">

<div class="form-group">

<label>Enter Use Id (Student Id)</label><br>


 <!-- form input text field-->
 
<input  type="text" name="std_id" placeholder="Student Id" required autocomplete="off"  />

</div>

  <!-- The submit button -->
 <input type="submit" name="Add" value="Add This Student ID" onClick="return confirm_first()">
 
</form>
</div>

</div>


</div>
  <!-- End Of add new user form -->
  
  </div>

<div class="footer-section" style="float:left;">
<p>&copy; mynamesAtweb.com</p>
</div>

</div>
  
</body>
</html>
