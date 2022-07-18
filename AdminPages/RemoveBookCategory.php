<?php
//start session
session_start();

//check if session is set
if(isset($_SESSION['admin_email'])){


  //include the files
include('includes/db_config.php');
include('includes/CustomFunctions.php');

//check if user has submitted the form
if(isset($_POST['bk_category'])){

  //when user submit the form, then we get the category id
$bk_category = $_POST['categoryid'];

//DELETE QUERY
$query = "DELETE FROM tblcategory WHERE id = '$bk_category'";



if(mysqli_query($conn,$query)){

  //if the query get executed, and record deleted
    echo "<script>alert('Book Category Has Been Deleted');</script>";

}else{

  //if the query get executed but fails to delete the category
   echo "<script>alert('Failed To Delete Book Category');</script>";
   echo mysqli_error($conn);

}



}else{


}	

}else{

  //incase the session is not set then the page is redirected to log in page
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
   
   <h1>Admin [Remove Book Category]</h1>
   
   </div>
  
</div>


</div>

<div class="row">

 <?php include('navigation-div.php');?>
  
	

  
<div class="column middle">

  
  <div class="form-container" >
 
<div class="panel panel-info">

<div class="inner-heading">
 Remove Book Category From My List
</div>

<div class="form-controls">

<!-- Delete category form -->
<form role="form" method="post" action="RemoveBookCategory.php">

<div class="form-group">

<label>Select Book Category</label><br>
 
<select name="categoryid"/>
 <?php 
 
 $sql_query = "SELECT * FROM tblcategory";
 //get all the category records from the table
 $results = mysqli_query($conn,$sql_query) or die(mysqli_error($conn));

 //iterate through the results and display the categories in the form
 while($row=mysqli_fetch_assoc($results)){
 
 ?>
<option value="<?php echo htmlentities($row['id']);?>"><?php echo $row['CategoryName']; ?></option>

 <?php }; ?>  
</select>

</div>

<!-- Submit button -->
 <input type="submit" name="bk_category" value="Delete Book Category Completely" onClick="return confirm_first()">
 
</form>
</div>

</div>


</div>
  <!-- End Of Log In Form -->
  
  </div>

<div class="footer-section" style="float:left;">
<p>&copy; mynamesAtweb.com</p>
</div>

</div>
  
</body>
</html>
