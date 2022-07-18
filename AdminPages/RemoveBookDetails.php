<?php
//This page is used to delete books/ or remove books from the library
session_start();

//check if session is set 
if(isset($_SESSION['admin_email'])){

  //include the important files
include('includes/db_config.php'); //database connection file
include('includes/CustomFunctions.php'); //contains functions

//check if book id is set
if(isset($_GET['bkid'])){

   $bkid = $_GET['bkid'];
   //on first load we store this variable to a global variable
   $_SESSION['bkid'] = $bkid; 
   
}else{

    $bkid = $_SESSION['bkid'];

}

//check if user clicks the submit button i.e he wants to remove the book
if(isset($_POST['addbook'])){


  //delete query
$query = "DELETE FROM tblbooks WHERE ISBNNumber = '$bkid'";



if(mysqli_query($conn,$query)){

  //if the book is deleted then this message will be dsplayed
    echo "<script>
	window.location.href='ViewRegisteredBooks.php';
	alert('Book Has Been Deleted');
	</script>";

}else{

  //if the delete query execution fails

   echo "<script>alert('Failed To Delete Book');</script>";

}


}else{


}	

}else{

  //when the session is not set, the page is rediredted to log in page

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

    if(window.confirm("Are You Sure You Want To Completely Remove This Book ?")){
	
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
   
   <h1>Admin [Delete Books]</h1>
   
   </div>
  
</div>


</div>

<div class="row">

 <?php include('navigation-div.php');?>
  
	

  
<div class="column middle">

  
  <div class="form-container" >
 
<div class="panel panel-info">

<div class="inner-heading">
 Remove Book From My Database (Be Carefull)
</div>

<div class="form-controls">

<form role="form" method="post" action="RemoveBookDetails.php">

<div class="form-group">

<label>Book ISBN Number</label><br>
 <!-- input to get the book isbn number -->
<input  type="text" name="bk_isbn" placeholder="ISBN Number" value="<?php echo $bkid;?>" required disabled />

</div>


 <input type="submit" name="addbook" value="Delete Book Infor Completely" onClick="return confirm_first()">
 
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
