
<?php
//start session
session_start();

//iclude files
include('includes/db_config.php');
include('includes/CustomFunctions.php');

//check if session is set
if(isset($_SESSION['admin_email'])){

  //get the admin email
$std_email = $_SESSION['admin_email'];

$std_id = getStudentId($std_email);

//check if search form is submitted
if(isset($_POST['search_button']) && !empty($_POST['search_text'])){

  //get search hint
$text = $_POST['search_text'];

//select  query
$query = "SELECT * FROM tbl_students WHERE StudentId LIKE '%$text%' OR FullName LIKE '%$text%' OR Email LIKE
 '%$text%' OR MobileNumber LIKE '%$text%' OR RegistrationDate LIKE '%$text%' ORDER BY RegistrationDate DESC";

}else{

  //query without search hint
    $query = "SELECT * FROM tbl_students ORDER BY RegistrationDate DESC";
}	

//execute query
$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

$rows = mysqli_num_rows($results);
	

}else{

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
   
   <h1>Admin [View Registered Users]</h1>
   
   </div>
  
</div>


</div>

<div class="row">


  
 <?php include('navigation-div.php');?>
  
	

  
<div class="column middle">

<div class="details-container">
  
  <div class="sub_form">
  
  <form name="form" id="search_form" method="post" action="ViewRegisteredUsers.php">
  <input type="text" placeholder="Search" name="search_text">
  <input type="submit" value="Search" name="search_button">
  </form>
  </div>
  
  <div class="formdiv">
     <table>

     <!-- This table display all the students details -->
  <tr>
    <th>Student Id</th>
    <th>Full Name</th>
    <th>Email Address</th>
	<th>Mobile Number</th>
	<th>Registration Date</th>
	
	
  </tr>
  <?php
  
	// Associative array
   while($row=mysqli_fetch_assoc($results)){
   
  echo '<tr>
    <td>'.$row['StudentId'].'</td>
    <td>'.$row['FullName'].'</td>
    <td>'.$row['Email'].'</td>
	<td>'.$row['MobileNumber'].'</td>
	<td>'.$row['RegistrationDate'].'</td>
  </tr>';
  
  }
  ?>
</table>

</div>

<div class="alert">
  <span class="closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
  <strong><?php echo $rows." User(s) Retrived" ?> [Records Are Limited To 15]</strong> 
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
