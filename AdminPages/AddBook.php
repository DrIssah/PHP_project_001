<?php

//This file present the page  used to add books in the database
session_start();

//check if session is set
if(isset($_SESSION['admin_email'])){

  //add the files, db_config has the connection details to the database
include('includes/db_config.php');

//This file has custom functions that can be used
include('includes/CustomFunctions.php');

//check if user has clicked the add book button
if(isset($_POST['addbook'])){

  //if it is clicked then we take all values from the form input
$bktitle = $_POST['bk_title'];
$bkcategory = $_POST['categoryid'];
$bkauthor = $_POST['author'];
$bkisbn = $_POST['isbn'];
$bkprice = $_POST['bkprice'];

//sql query to insert the book details to the table tblbooks in the database
$query = "INSERT INTO tblbooks (BookName,CatId,AuthorId,ISBNNumber,BookPrice,Status) 
VALUES('$bktitle','$bkcategory','$bkauthor','$bkisbn','$bkprice',0)";

//we check isbn number, whether it exists in our records or not, this allows us not
//to enter duplicate isbn number
$check_isbn = check_ISBN($bkisbn);


//the function returns zere if isbn is new and 1 when the isbn number alread exists
if($check_isbn == 0){

if(mysqli_query($conn,$query)){

  //if book is added successfully, then a message is displayed

    echo "<script>alert('Thank you,Book Has Been Added..!!');</script>";

}else{

  //else this message is displayed
   echo "<script>alert('Failed To Add Data');</script>";
   echo mysqli_error($conn);

}

}else{

  //if isbn number exists then an alert message is displayed
  echo "<script>alert('Failed,ISBN Is Alread In Use');</script>";

}


}else{


}	

}else{

  //if session is not set then the user is redirected to the log in page
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
   
   <h1>Admin [Add New Book]</h1>
   
   </div>
  
</div>


</div>

<div class="row">

 <?php include('navigation-div.php');?>
  
	

  
<div class="column middle">

  
  <div class="form-container" >
 
<div class="panel panel-info">

<div class="inner-heading">
 Add New Book [All Fields Should Be Filled]
</div>

<div class="form-controls">

<!-- Creating the form for addung books -->
<form role="form" method="post" action="AddBook.php">

<div class="form-group">

<label>Book Title</label><br>
 
 <!-- input field for book title-->
<input  type="text" name="bk_title" placeholder="Book Title" required autocomplete="off"  />

</div>


<div class="form-group">

<label>Select Book Category</label><br>
 
 <!-- Selection input for book category, values here are fetched from table, we use loop to create the drop down values -->
<select name="categoryid"/>
 <?php 
 
 //query to get all the book categories
 $sql_query = "SELECT * FROM tblcategory";
 
 $results = mysqli_query($conn,$sql_query) or die(mysqli_error($conn));
 while($row=mysqli_fetch_assoc($results)){
 // we loop through the results to add values to the selection iput, the option values
 ?>
<option value="<?php echo htmlentities($row['id']);?>"><?php echo $row['CategoryName']; ?></option>

 <?php }; ?>  
</select>

</div>

<div class="form-group">

<label>Select Book Author</label><br>

<!-- form input  to select author here the values for optona are fetched fro the database-->
<select name="author" />
 <?php 
 
 // we select all the available authors from the table tblauthors
 $sql_query = "SELECT * FROM tblauthors";
 
 //query executions
 $results = mysqli_query($conn,$sql_query) or die(mysqli_error($conn));
 
 //we then use loops to display the options
 while($row=mysqli_fetch_assoc($results)){
 ?>
<option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['AuthorName']); ?></option>

 <?php }?>  
   
</select>


</div>

<div class="form-group">

<label>ISBN Number (Unique Book Number)</label><br>
 
 <!-- form input for isbn number -->
<input  type="number" name="isbn" placeholder="ISBN Number" required autocomplete="off"  />

</div>

<div class="form-group">

<label>Price Per Book</label><br>
 
 <!-- form input for book price -->
<input  type="Number" name="bkprice"  required autocomplete="off"  />

</div>

<!-- the submit button -->
 <input type="submit" name="addbook" value="Add New Book">
 
</form>
</div>

</div>


</div>
  <!-- End Of add book form -->
  
  </div>

<div class="footer-section" style="float:left;">
<p>&copy; mynamesAtweb.com</p>
</div>

</div>
  
</body>
</html>
