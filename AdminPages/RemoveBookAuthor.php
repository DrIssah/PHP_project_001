<?php

//page used to remove Author from database
//start session
session_start();

//check if admin email is set, usually during log in
if(isset($_SESSION['admin_email'])){

  //include connection files and the custo function files
include('includes/db_config.php');
include('includes/CustomFunctions.php');

//check if user has submitted the required data 
if(isset($_POST['authorid'])){

  //get author id from the form
$bk_author = $_POST['authorid'];

//delete query to delete author from the database
$query = "DELETE FROM tblauthors WHERE id = '$bk_author'";



if(mysqli_query($conn,$query)){
//if delete query is executed successfully then a message is displayed
    echo "<script>alert('Book Author Has Been Deleted');</script>";

}else{

  //when the quey fails then this message will be displayed
   echo "<script>alert('Failed To Delete Book Author');</script>";
   echo mysqli_error($conn);

}



}else{


}	

}else{

  //incase session is not set, then redirect user to the log in page
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

<!-- This script has a function that is called when ever a user clicks to delete an author -->
<!-- it displays aconfirm message -->

<script>

function confirm_first(){

    if(window.confirm("Are You Sure You Want To Completely Remove This Book Category ?")){
	
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
   
   <h1>Admin [Remove Book Authors]</h1>
   
   </div>
  
</div>


</div>

<div class="row">

 <?php include('navigation-div.php');?>
  
	

  
<div class="column middle">

 
  <div class="form-container" >
 
<div class="panel panel-info">

<div class="inner-heading">
 Remove Book Author From My List
</div>

<div class="form-controls">

<!-- Delete author form -->
<form role="form" method="post" action="RemoveBookAuthor.php">

<div class="form-group">

<label>Select Book Author To Remove</label><br>
 
<select name="authorid"/>
 <?php 
 
 // get all the authors records
 $sql_query = "SELECT * FROM tblauthors";
 
 //execute the query
 $results = mysqli_query($conn,$sql_query) or die(mysqli_error($conn));
 //iterate over the results to display the authors name as an option on the select control
 while($row=mysqli_fetch_assoc($results)){
 
 ?>
<option value="<?php echo htmlentities($row['id']);?>"><?php echo $row['AuthorName']; ?></option>

 <?php }; ?>  
</select>

</div>

<!-- submit button -->
 <input type="submit" name="bk_category" value="Delete Book Author Completely" onClick="return confirm_first()">
 
</form>
</div>

</div>


</div>
  <!-- End Of  Form -->
  
  </div>

<div class="footer-section" style="float:left;">
<p>&copy; mynamesAtweb.com</p>
</div>

</div>
  
</body>
</html>
