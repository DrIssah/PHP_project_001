
<?php

// start session
session_start();

//include the files
include('includes/db_config.php');
include('includes/CustomFunctions.php');

//check if session is set
if(isset($_SESSION['admin_email'])){

$std_email = $_SESSION['admin_email'];

$std_id = getStudentId($std_email);

//check and get values one user clicks the search button
if(isset($_POST['search_button']) && !empty($_POST['search_text'])){

  //get book categories according to search text
$text = $_POST['search_text'];

$query = "SELECT * FROM tblcategory WHERE CategoryName LIKE '%$text%' ORDER BY CreationDate DESC";

}else{
//get all books
    $query = "SELECT * FROM tblcategory";
}	

$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

$rows = mysqli_num_rows($results);
	

}else{
//redirect page to log in
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

input[type=text]{

width:20%;


}

input[type=submit]{

width:20%;
padding: 10px 10px;


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
   
   <h1>Admin [View Books Categories]</h1>
   
   </div>
  
</div>


</div>

<div class="row">


  
 <?php include('navigation-div.php');?>
  
	

  
<div class="column middle">

<div class="details-container">
  <!-- search sub form -->
  <div class="sub_form">
  
  <form name="form" id="search_form" method="post" action="ViewBookCategory.php">
  <input type="text" placeholder="Search" name="search_text">
  <input type="submit" value="Search" name="search_button">
  </form>
  </div>
  
  <div class="formdiv">
     <table>
     <!-- table to display the book categories -->
  <tr>
    <th>Category Id</th>
    <th>Category Name</th>
    <th>Creation Date</th>
	<th>Date Of Update</th>
	
	
  </tr>
  <?php
  
	// Associative array
   while($row=mysqli_fetch_assoc($results)){
   
  echo '<tr>
    <td>'.$row['id'].'</td>
    <td>'.$row['CategoryName'].'</td>
    <td>'.$row['CreationDate'].'</td>
	<td>'.$row['UpdationDate'].'</td>
	
  </tr>';
  
  }
  ?>
</table>

</div>

<div class="alert">
  <span class="closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
  <strong><?php echo $rows." Book(s) Category Retrived" ?> </strong> 
</div>

  <!-- End Of Log In Form -->
  
  </div>
  
  </div>

<div class="footer-section" style="float:left;">
<p>&copy; mynamesAtweb.com</p>
</div>

</div>
  
</body>
</html>
