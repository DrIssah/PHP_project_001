<?php
//incase a student reserves a  book then this page is used to Borrow the reserved book
//start session
session_start();

//check if session is set
if(isset($_SESSION['admin_email'])){

  //if is set then this block of code will be executed
  //include connection file and the custom function files
include('includes/db_config.php');
include('includes/CustomFunctions.php');

//check if this book id is set, book id is passed from another page using the get method
if(isset($_GET['bkid'])){

  //store both book id and the student id, student id belongs to the student who has reserved the book
  $bkid = $_GET['bkid'];
	$stdid = $_GET['stdid'];
  
  //store both the variables in a global variables
	$_SESSION['bkid'] = $bkid;
	$_SESSION['stdid'] = $stdid;
	
	
	 
}else{

  //if the bookid is not set, once the page is refreshed, we can not get the values from get method
  //but we can still access them sisnce we stored them in a global variable
   $bkid = $_SESSION['bkid'];
   $stdid = $_SESSION['stdid'];
}


//once the user submits the Borrow form details
if(isset($_POST['Borrow'])){

  //store the form input values to variables
$bk_isbn = $_POST['bk_isbn'];
$std_id = $stdid;
$duration = $_POST['book_duration'];
$book_id = $bkid;

//convert the duration suplied to date
$rdate = date('Y/m/d H:m:s',strtotime("+".$duration." day"));

//insert query
$query = "INSERT INTO tblBorrowedbookdetails (BookId,StudentId,ReturnDate,ReturnStatus) 
VALUES('$book_id','$std_id','$rdate','1')";

//check if ISBN number supplied is correct
$check_isbn = check_ISBN($bk_isbn);

//check if book requested is available
if(check_ifbookinlibrary($bk_isbn) > 0){

  //if isbn supplied is valid
if($check_isbn > 0){

  //check if student id supplied is valid
if(Check_stdid($std_id) > 0){

//check if student has a book
if(check_ifhasbook($std_id) == 0){

if(mysqli_query($conn,$query)){
	//UPDATE BOOKS AFTER Borrow
	
	$query_update = "UPDATE tblbooks SET Status = 1 WHERE ISBNNumber = '$bk_isbn'";
	
	if(mysqli_query($conn,$query_update)){
  
    //display message after book has been successfully delivered
	echo "<script>
	window.location.href='ViewRegisteredBooks.php';
	alert('Book Has Been Borrowed To Student');
	</script>";
	//unreserve the book
	
	$sql_unreserve = "UPDATE tblbooks SET Reserved = 'No',ReservationTime = '',Reserver = 'Null' WHERE
    bkid = '$book_id'";
   
   mysqli_query($conn,$sql_unreserve);
	}else{
  
    //incase the process fails
	echo "<script>alert('Failed To Add Data');</script>";
	
	}
	

}else{

  //incase the process fails
   echo "<script>alert('Failed To Add Data');</script>";
   echo mysqli_error($conn);

}
}else{

  //incase the student alread has a book, then will not allowed to have another book
  echo "<script>alert('The Student alread Have a Library Book, Should Be Returned First In Order To Get Another Copy');</script>";

}
}else{

  //incase an invalid id is supplied
  echo "<script>alert('Student ID Is Not Yet Registered');</script>";

}
}else{
 
  //when an invalid isbn number is supplied
    echo "<script>alert('Invalid ISBN Number (Not Found In Database)');</script>";
}
}else{

  //incase the book is not found in the library
echo "<script>alert('Book With ISBN ".$bk_isbn." Has Not Been Returned Yet');</script>";

}
}

//get book details that have the supplied Book id, usually supplied from another page
$sql_getbkdtails = "SELECT * FROM tblbooks WHERE bkid = '$bkid'";
//query get executed here
$bkdtails = mysqli_query($conn,$sql_getbkdtails);

//rows are fetched and stored in bookdetails table
$row_bkdtails=mysqli_fetch_assoc($bkdtails);


}else{

  //in case session is not set then the page is redirected to login page
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
   
   <h1>Admin [Borrow Books To Student]</h1>
   
   </div>
  
</div>


</div>

<div class="row">

 <?php include('navigation-div.php');?>
 
<div class="column middle">

  <!-- Form container -->
  <div class="form-container" >
 
<div class="panel panel-info">

<div class="inner-heading">
 Borrow A Book To a student
</div>
<!-- Borrow reserved books form -->
<div class="form-controls">

<form role="form" method="post" action="BorrowReservedBooks.php">

<div class="form-group">

<label>Book Name</label><br>
<!-- This input holds the book isbn number -->
<input  type="hidden" name="bk_isbn" value = "<?php echo $row_bkdtails['ISBNNumber']; ?>" 
placeholder="Book ISBN Number"/>


<!-- This form input display the book name -->
<input  type="text" name="bk_name" value = "<?php echo $row_bkdtails['BookName']; ?>" 
 disabled/>

</div>

<div class="form-group">

<label>Student ID</label><br>
 <!-- this form control holds the student id -->
<input  type="text" name="std_id" value="<?php echo $stdid; ?>" placeholder="Student Id" disabled/>

</div>

<div class="form-group">

<label>Enter Book Duration</label><br>
 <!-- Here the admin add duration of the book -->
<input  type="Number" name="book_duration" placeholder="Book Duration In Days" required autocomplete="off"  />

</div>

<!-- submit button, when clicks the form data is submitted -->
 <input type="submit" name="Borrow" value="Borrow Book">
 
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
