
<?php
//start session
session_start();

//include connection files
include('includes/db_config.php');
include('includes/CustomFunctions.php');

//check if session is set
if(isset($_SESSION['std_email'])){

  //store email variable to the std_imail variable
$std_email = $_SESSION['std_email'];

//get student id using the getstudent id function, by passing the student email
$std_id = getStudentId($std_email);

//check if student clicks such button and has typed search criteria
if(isset($_POST['search_button']) && !empty($_POST['search_text'])){

  //get the search criteria
$text = $_POST['search_text'];

//sql query to get the specified books
$query = "SELECT BookName,ISBNNumber,CategoryName,AuthorName,BookPrice,tblbooks.Status,RegDate,tblbooks.bkid
	 As bkid,Reserved,ReservationTime FROM tblauthors,tblbooks,tblcategory WHERE tblcategory.id = tblbooks.CatId AND  tblauthors.id = tblbooks.AuthorId AND (BookName LIKE '%$text%' OR ISBNNumber LIKE '%$text%' OR CategoryName LIKE '%$text%' OR AuthorName LIKE '%$text%' OR BookPrice LIKE '%$text%') ORDER BY RegDate DESC";

}else{

  //if no search criteria then just get allthe book details of the student
    $query = "SELECT BookName,ISBNNumber,CategoryName,AuthorName,BookPrice,tblbooks.Status,RegDate,tblbooks.bkid
	 As bkid,Reserved,ReservationTime FROM tblauthors,tblbooks,tblcategory 
	 WHERE tblcategory.id = tblbooks.CatId AND  tblauthors.id = tblbooks.AuthorId  ORDER BY RegDate DESC LIMIT 15";
}	

//execute the query
$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

$rows = mysqli_num_rows($results);


//reseve book
if(isset($_GET['bkidresv'])){
   
   $duration = '1';

   $rdate = date('Y/m/d H:m:s',strtotime("+".$duration." day"));
  
   $bkid = $_GET['bkidresv'];
   $std_id = getStudentId($std_email);
   
   $sql_unreserve = "UPDATE tblbooks SET Reserved = 'No',ReservationTime = '$rdate',Reserver = 'Null' WHERE
   Reserver = '$std_id'";
   
   mysqli_query($conn,$sql_unreserve);
   
   $sql_reserve = "UPDATE tblbooks SET Reserved = 'Yes',ReservationTime = '$rdate',Reserver = '$std_id' WHERE
   bkid = '$bkid'";
   
   
  //if the query executes successifully, then show allert message 
   if(mysqli_query($conn,$sql_reserve)){
     echo "<script>
	window.location.href='ViewBooks.php';
	alert('Book Has Been Reserved');
	</script>";
     
     }

}
	

}else{

header('Location:../AdminLogin.php');

}


?>


<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Library System</title>
<link rel="stylesheet" type="text/css" href="Styles/bootstrap-4.0.0-dist/css/bootstrap.min.css">
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

   <img src="images/books-stack-of-three (2).png" width="50" height="50" style="float:left">
   <div class="imagetext">
   <h1>Online LMS</h1>
   </div>
</div>

<div id="webtitle">

   <div class="Heading">
   
   <h1>Studen Account [View Library Books]</h1>
   
   </div>
  
</div>


</div>

<div class="row">


  
 <?php include('navigation_menu.php');?>
  
	

  
<div class="column middle">

<div class="details-container">
  <!-- creatin form-->
  <div class="sub_form">
  
  <form name="form" id="search_form" method="post" action="ViewBooks.php">
  <input type="text" placeholder="Search" name="search_text">
<input type="submit" value="Search" name="search_button">
 
  </form>
  </div>
  
  <div class="formdiv">
     <table class="table table-hover table-sm">
  <tr>
   <!-- table headings-->
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
   $rdate = new DateTime($row['ReservationTime']);
   $now = new DateTime('now');
   $duration =date_diff($rdate,$now,true);
   $hours = $duration->format("%h Hours");
   
   //unreseve book if time is zero
   
   if($hours == 0){
   //check hours
   $bkid = $row['bkid'];
   $sql_unreservebk = "UPDATE tblbooks SET Reserved = 'No',ReservationTime = '',Reserver = 'Null' WHERE
   bkid = '$bkid'";
   
   mysqli_query($conn,$sql_unreservebk);
   
   }
   
   //inisialise availability variable
   $availability = "Available";
   
   if($row['Status'] == 0){
      
	  $availability = '<span class="badge badge-success">Available</span>';
	  
	  if($row['Reserved'] == 'No'){
	  
	    $btn_reserve = '<a href="ViewBooks.php?bkidresv='.$row['bkid'].'">
	  <button type="button" class="btn btn-primary btn-sm">Reserve</button>';
	  
	  
	  }else{
	  
	    $btn_reserve = '<span class="badge badge-success">Reserved</br>'.$hours.' Ago</span>';
	  
	  }
	  
   }else{
   
      $availability = '<span class="badge badge-info">Not Available</span>';
	  $btn_reserve = '<span class="badge badge-success">N/A</span>';
	  
   }
  echo '<tr>
    <td>'.$row['BookName'].'</td>
    <td>'.$row['ISBNNumber'].'</td>
    <td>'.$row['CategoryName'].'</td>
	<td>'.$row['AuthorName'].'</td>
	<td>'.$availability.'</td>
	<td> $ '.$row['BookPrice'].'.00</td>
	<td>'.$btn_reserve.'</td>
  </tr>';
  
  }
  ?>
</table>

</div>

<div class="alert">
  <span class="closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
  <strong><?php echo $rows." Book(s) Retrived" ?> [Records Are Limited To 15]</strong> 
</div>

  <!-- End Of Log In Form -->
  
  </div>
  
  </div>


</div>
  
</body>
</html>
