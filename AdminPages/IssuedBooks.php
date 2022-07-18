
<?php
session_start();

include('includes/db_config.php');
include('includes/CustomFunctions.php');

if(isset($_SESSION['admin_email'])){

$std_email = $_SESSION['admin_email'];

$std_id = getStudentId($std_email);

if(isset($_POST['search_button']) && !empty($_POST['search_text'])){

$text = $_POST['search_text'];

$query = "SELECT BookName,ISBNNumber,tbl_students.StudentId,Email,MobileNumber,ReturnDate,IssuesDate,BookId FROM tblissuedbookdetails,tblbooks,tbl_students  WHERE tblissuedbookdetails.StudentId = tbl_students.StudentId AND  tblbooks.bkid = tblissuedbookdetails.BookId AND ReturnStatus = 1 AND (BookName LIKE '%$text%' OR ISBNNumber LIKE '%$text%' OR  tbl_students.StudentId LIKE '%$text%' OR Email LIKE '%$text%' OR MobileNumber LIKE '%$text%')  ORDER BY ReturnDate DESC";

}else{

    $query = "SELECT BookName,ISBNNumber,tbl_students.StudentId,Email,MobileNumber,ReturnDate,IssuesDate,BookId FROM tblissuedbookdetails,tblbooks,tbl_students WHERE tblissuedbookdetails.StudentId = tbl_students.StudentId AND  tblbooks.bkid = tblissuedbookdetails.BookId AND ReturnStatus = 1  ORDER BY ReturnDate DESC";
}	

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
<link rel="stylesheet" type="text/css" href="../Styles/bootstrap-4.0.0-dist/css/bootstrap.min.css">
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
   
   <h1>Admin [View Issued Books]</h1>
   
   </div>
  
</div>


</div>

<div class="row">


  
 <?php include('navigation-div.php');?>
  
	

  
<div class="column middle">

<div class="details-container">
  <!-- Log In form -->
  <div class="sub_form">
  
  <form name="form" id="search_form" method="post" action="IssuedBooks.php">
  <input type="text" placeholder="Search" name="search_text">
  <input type="submit" value="Search" name="search_button">
  </form>
  </div>
  
  <div class="formdiv">
     <table>
  <tr>
    <th>Bk Title</th>
    <th>ISBN</th>
    <th>Std Id</th>
	<th>Email</th>
	<th>Mobile No</th>
	<th>Issues Date</th>
	<th>Return Date</th>
	<th>Return Status</th>
	<th>Actions</th>
	
  </tr>
  <?php
  
	// Associative array
   while($row=mysqli_fetch_assoc($results)){
   $rdate = new DateTime($row['ReturnDate']);
   $now = new DateTime('now');
   $status = "";
   $btn_return = '<a href="ReturnBooks.php?bkisbn='.$row['ISBNNumber'].'&bkid='.$row['BookId'].'&sid='.$row['StudentId'].'">
	  <button type="button" class="btn btn-primary btn-sm">Return</button>';
	  
   if($rdate > $now){
    
	   $status = "<strong>Not Yet</strong>";
   }else{
   
       
       $status = "<label style = 'color:red'>Over Due</label>";
   
   }
   
   echo '<tr>
    <td>'.$row['BookName'].'</td>
    <td>'.$row['ISBNNumber'].'</td>
    <td>'.$row['StudentId'].'</td>
	<td>'.$row['Email'].'</td>
	<td>'.$row['MobileNumber'].'</td>
	<td>'.$row['IssuesDate'].'</td>
	<td>'.$row['ReturnDate'].'</td>
	
	<td>'.$status.'</td>
	<td>'.$btn_return.'</td>
   </tr>';
  
  }
  ?>
</table>

</div>

<div class="alert">
  <span class="closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
  <strong><?php echo $rows." Book(s) Retrived" ?> [Records Are Limited To 15]</strong></br>
  <strong>Hello, For proper running of library Students With overdue Books should be called and be fined approprietly</strong> 
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
