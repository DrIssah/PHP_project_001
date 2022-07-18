
<?php

//start session
session_start();

//include required files
include('includes/db_config.php');
include('includes/CustomFunctions.php');

//check if session is set
if(isset($_SESSION['admin_email'])){

  //get admin email
$std_email = $_SESSION['admin_email'];

$std_id = getStudentId($std_email);

//check if user submint the search form details
if(isset($_POST['search_button']) && !empty($_POST['search_text'])){

$text = $_POST['search_text'];

//select query with search hint
$query = "SELECT BookName,ISBNNumber,CategoryName,AuthorName,BookPrice,tblbooks.Status,RegDate,Reserved,bkid,ReservationTime,Reserver FROM tblauthors,tblbooks,tblcategory 
WHERE tblcategory.id = tblbooks.CatId AND  tblauthors.id = tblbooks.AuthorId AND (BookName LIKE '%$text%' OR ISBNNumber LIKE '%$text%' OR CategoryName LIKE '%$text%' OR AuthorName LIKE '%$text%' OR BookPrice LIKE '%$text%') ORDER BY RegDate DESC";

}else{

  //select query without search hint
    $query = "SELECT BookName,ISBNNumber,CategoryName,AuthorName,BookPrice,tblbooks.Status,RegDate,Reserved,bkid,ReservationTime,Reserver 
	FROM tblauthors,tblbooks,tblcategory WHERE tblcategory.id = tblbooks.CatId AND  tblauthors.id = tblbooks.AuthorId  ORDER BY RegDate DESC LIMIT 20";
}	

//execute query
$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

//get number of rows
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
   
   <h1>Admin [View Books]</h1>
   
   </div>
  
</div>


</div>

<div class="row">


  
 <?php include('navigation-div.php');?>
  
	

  
<div class="column middle">

<div class="details-container">
  <!-- search sub form -->
  <div class="sub_form">
  
  <form name="form" id="search_form" method="post" action="ViewRegisteredBooks.php">
  <input type="text" placeholder="Search" name="search_text">
  <input type="submit" value="Search" name="search_button">
  </form>
  </div>
  
  <div class="formdiv">
     <table>

     <!-- table to display the book details -->
  <tr>
    <th>Book Title</th>
    <th>ISBN</th>
    <th>Category</th>
	<th>Author</th>
	<th>Status</th>
	<th>BookPrice</th>
	<th>Actions</th>
	
  </tr>
  <?php
  
	// Associative array
   while($row=mysqli_fetch_assoc($results)){
   
    //get boook details
   $rdate = new DateTime($row['ReservationTime']);
   $now = new DateTime('now');
   $duration =date_diff($rdate,$now,true);
   $hours = $duration->format("%h Hours");
   
   //unreseve book if time is zoro
   
   if($hours == 0){
   
   $bkid = $row['bkid'];
   $sql_unreservebk = "UPDATE tblbooks SET Reserved = 'No',ReservationTime = '',Reserver = 'Null' WHERE
   bkid = '$bkid'";
   
   mysqli_query($conn,$sql_unreservebk);
   
   }
   
   $availability = "Available";
   
    $btn_edit = '<a href="RemoveBookDetails.php?bkid='.$row['ISBNNumber'].'">
	  <button type="button" class="btn btn-primary btn-sm">Delete</button>';
  
    //check if book is available or not
    //if book s available then Status = 0 
   
   if($row['Status'] == 0){
      
	  $availability = '<span class="badge badge-success">Available</span>';
	  $btn_borrow = '<a href="IssueBooks.php?bkid='.$row['bkid'].'">
	  <button type="button" class="btn btn-primary btn-sm">Borrow</button>';
    
    //if book is reserved then  button borrow $btn_borrow changes accordngly
	  if($row['Reserved'] == 'Yes'){
	  
	  $btn_borrow = '<a href="IssueReservedBooks.php?bkid='.$row['bkid'].'&stdid='.$row['Reserver'].'">
	  <button type="button" class="btn btn-primary btn-sm">Borrow</button>';
	  
	  $availability = '<span class="badge badge-success">Reserved</br>'.$hours.' Ago</span>';
	  $btn_edit = '';
	  }
	  
   }else{
   //if book is not available
      $availability = '<span class="badge badge-info">N/A</span>';
	  $btn_borrow = '<span class="badge badge-success">N/A</span>';
   }

   //display book records
  echo '<tr>
    <td>'.$row['BookName'].'</td>
    <td>'.$row['ISBNNumber'].'</td>
    <td>'.$row['CategoryName'].'</td>
	<td>'.$row['AuthorName'].'</td>
	<td>'.$availability.'</td>
	<td> $ '.$row['BookPrice'].'.00</td>
	<td>'.$btn_borrow.$btn_edit.'</td>
  </tr>';
  
  }
  ?>
</table>

</div>

<div class="alert">
  <span class="closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
  <strong><?php echo $rows." Book(s) Retrived" ?> [Records Are Limited To 20]</strong> 
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
