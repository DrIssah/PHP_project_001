 <?php

//start session
session_start();

//check if session is set
if(isset($_SESSION['admin_email'])){

  //include important files
include('includes/db_config.php');
include('includes/CustomFunctions.php');

//check if variable bookid is set or is not empty
if(isset($_GET['bkid'])){

  //the book id is passed from another page using the get method
    $bkid = $_GET['bkid'];
  
    //we set it to a global variable
	$_SESSION['bkid'] = $bkid;
	
	
	 
}else{

   $bkid = $_SESSION['bkid'];
}


//check if user submit the issue books form

if(isset($_POST['issue'])){

  //once form is submitted then get and store all the form values
$bk_isbn = $_POST['bk_isbn'];
$std_id = $_POST['std_id'];
$duration = $_POST['book_duration'];
$book_id = $bkid;

//date format
$rdate = date('Y/m/d H:m:s',strtotime("+".$duration." day"));

//sql query to insert data to table
$query = "INSERT INTO tblissuedbookdetails (BookId,StudentId,ReturnDate,ReturnStatus) 
VALUES('$book_id','$std_id','$rdate','1')";

//check the existance of ISBN number
$check_isbn = check_ISBN($bk_isbn);

//check if book is available
if(check_ifbookinlibrary($bk_isbn) > 0){

  //check validity of the sublied ISBN
if($check_isbn > 0){

  //CHECK STUDENT id
if(Check_stdid($std_id) > 0){

//Check if student has a book
if(check_ifhasbook($std_id) == 0){

if(mysqli_query($conn,$query)){
	//If the student exists in the record, and does not have a book then is allowed to get a book
	
	$query_update = "UPDATE tblbooks SET Status = 1 WHERE ISBNNumber = '$bk_isbn'";
	
	if(mysqli_query($conn,$query_update)){

    //display message after and rediret page to main view books  page
	
	echo "<script>
	window.location.href='ViewRegisteredBooks.php';
	alert('Book Has Been Issued To Student');
	</script>";
	}else{
	
	echo "<script>alert('Failed To Add Data');</script>";
	
	}
	

}else{

  //if the update query fails
   echo "<script>alert('Failed To Add Data');</script>";
   echo mysqli_error($conn);

}
}else{

  //if the student has a library book
  echo "<script>alert('The Student alread Have a Library Book, Should Be Returned First In Order To Get Another Copy');</script>";

}
}else{

  //is student is not registered
  echo "<script>alert('Student ID Is Not Yet Registered');</script>";

}
}else{
 
  //if the isbn number is not valid
    echo "<script>alert('Invalid ISBN Number (Not Found In Database)');</script>";
}
}else{

  //if book is not in library
echo "<script>alert('Book With ISBN ".$bk_isbn." Has Not Been Returned Yet');</script>";

}
}

//get book details for this student
$sql_getbkdtails = "SELECT * FROM tblbooks WHERE bkid = '$bkid'";

//Executing query
$bkdtails = mysqli_query($conn,$sql_getbkdtails);
//fetching rows and store them in a variable
$row_bkdtails=mysqli_fetch_assoc($bkdtails);


}else{

  //incase session is not set, then redirect page to log in page
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
   
   <h1>Admin [Issue Books To Student]</h1>
   
   </div>
  
</div>


</div>

<div class="row">

 <?php include('navigation-div.php');?>
 
<div class="column middle">

  
  <div class="form-container" >
 
<div class="panel panel-info">

<div class="inner-heading">
 Issue A Book To a student
</div>

<div class="form-controls">

<!-- Issue books form -->
<form role="form" method="post" action="IssueBooks.php">

<div class="form-group">

<label>Book Name</label><br>
 <!-- this isbn form display or holds the book isbn number but its hidden from the user -->
<input  type="hidden" name="bk_isbn" value = "<?php echo $row_bkdtails['ISBNNumber']; ?>" 
placeholder="Book ISBN Number"/>


<!-- Input type used to hold the books Name, instead of writting the book name manualy -->
<input  type="text" name="bk_name" value = "<?php echo $row_bkdtails['BookName']; ?>" 
 disabled/>

</div>

<div class="form-group">

<!-- This input allows the user to add student id number -->
<label>Enter Student ID</label><br>
 
<input  type="text" name="std_id" placeholder="Student Id" required autocomplete="off"  />

</div>

<div class="form-group">

<label>Enter Book Duration</label><br>
 <!-- Allow user to enter the book duration -->
<input  type="Number" name="book_duration" placeholder="Book Duration In Days" required autocomplete="off"  />

</div>

<!-- Submit button -->
 <input type="submit" name="issue" value="Issue Book">
 
</form>
</div>

</div>


</div>
  <!-- End Of issue books form -->
  
  </div>

<div class="footer-section" style="float:left;">
<p>&copy; mynamesAtweb.com</p>
</div>

</div>
  
</body>
</html>
