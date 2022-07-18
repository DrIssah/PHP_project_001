<?php
//start session

session_start();

 //is lke calling or including the file db_config.php so that we can use its variables
  //in simple language we want to use and access its variables

include('includes/db_config.php');
include('includes/CustomFunctions.php');

//Once a user is logged in, then this variable which is global is stored
//we check it if is set,this prevent opening this page before logging in whichis a security messure
//when one tries to reopen this page without logging in, then he will be redirected to the log in
//page, there for this page can be accesed by one who has logged in only
if(isset($_SESSION['std_email'])){

  //stores the value of the global variable into the new $std_email
$std_email = $_SESSION['std_email'];

//the function getStudentId is in the file CustomFunction, which returns student id
$std_id = getStudentId($std_email);

//
if(isset($_POST['search_button'])){

  //when user clicks the search button, then this block runs
$text = $_POST['search_text'];

//this is an sql statement that pulls records from database tabales
//tables are tblissuedbookdetails,tblbooks
//all records specified which match the criteria from the query will
//be retrived from our database
$query = "SELECT BookName,ISBNNumber,IssuesDate,ReturnDate,ReturnStatus 
FROM tblissuedbookdetails,tblbooks 
WHERE tblbooks.bkid = tblissuedbookdetails.BookId AND  tblissuedbookdetails.StudentId = '$std_id' AND (BookName LIKE '%$text%' OR ISBNNumber LIKE '%$text%' OR IssuesDate LIKE '%$text%' OR ReturnDate LIKE '%$text%' )";
}else{

  //this retrives all the records from the tables since no conditions are stated
$query = "SELECT BookName,ISBNNumber,IssuesDate,ReturnDate,ReturnStatus 
FROM tblissuedbookdetails,tblbooks 
WHERE tblbooks.bkid = tblissuedbookdetails.BookId AND  tblissuedbookdetails.StudentId = '$std_id'";

}
   

//query is executed and rows of data stored in the $results variable
	
	$results=mysqli_query($conn,$query) or die(mysqli_error($conn));
	

}else{

header('Location:index.php');

}


?>


<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Library System</title>
<link rel="stylesheet" type="text/css" href="Styles/main_two.css">
<link rel="stylesheet" type="text/css" href="Styles/main_one.css">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<script src="js/main.js" ></script>

<style>


.card {
  /* Add shadows to create the "card" effect */
  border:1px solid skyblue;
  transition: 0.3s;
  margin:15px;
  border-radius:5px;
  text-align:center;
  padding-top:25px;
}

.card img{

border-radius:5px;

}

/* On mouse-over, add a deeper shadow */
.card:hover {

  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

/* Add some padding inside the card container */
.card_container {

  padding: 1px 1px;
  background-color:skyblue;
}

table {
  border-collapse: collapse;
  width: 100%;
  margin-left:0%;
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

.form_container{

border:1px solid skyblue;
margin-left:5%;
margin-bottom:5%;
padding:5px;
border-radius:5px;

}


input[type=text]{

width:60%;


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

.footer-section {
    padding:25px 50px 25px 50px;
    color:#000;
    font-size:13px;
      background-color: #f7f7f7;
      text-align:right;
     border-top:5px solid #0000CC;

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
   
   <h1>Student Account [Library Books Report]</h1>
   
   </div>
  
</div>


</div>

<div class="row">


 <?php include('navigation_menu.php');?>
  
	

  
<div class="column middle" style="text-align:center">
  <!-- Log In form -->
  <div class="form_container">
  <div class="sub_form" style="width:40%;">
  
  <form name="form" id="search_form" method="post" action="Student_bookreport.php">
  <input type="text" placeholder="Search" name="search_text">
  <input type="submit" value="Search" name="search_button">
  </form>
  </div>
    <table>
  <tr>
    <th>Book Title</th>
    <th>ISBN</th>
    <th>Borrowed Date</th>
	<th>Return Date</th>
	<th>Book Due</th>
	<th>Return Status</th>
  </tr>


  <?php
  
	// Associative array
   $numrows = mysqli_num_rows($results);


   while($row=mysqli_fetch_assoc($results)){

    //convert the retrived return date to DateTime object, remember its retrived as a
    //string
   $rdate = new DateTime($row['ReturnDate']);

   // get the currect date and time
   $now = new DateTime('now');

   $clear = "Not Cleared";
   //find the diffrence between the return date and now
   $duration =date_diff($rdate,$now,true);

   //get hours 
   $hours = $duration->format("%h Hours");

   //get days
   $days = $duration->format("%d Days");
   $time = $days." ".$hours;

   //If return status is zero, hen it means the student returned the book hence cleared
   if($row['ReturnStatus'] == 0){
   
   $clear = "Cleared";
   
   //
   }else if($row['ReturnStatus'] == 1 && $now > $rdate ){
   
    //when return status is 1 then the student is still holdin the book
    //if also the returning date is past, then the book is marked overdue
     $clear = "<label style = 'color:red'>Book Is Overdue</label>";

   }else{
   
    $clear = "<label style = 'color:orange'>Not Cleared</label>";
   }
  echo '<tr>
    <td>'.$row['BookName'].'</td>
    <td>'.$row['ISBNNumber'].'</td>
    <td>'.$row['IssuesDate'].'</td>
	<td>'.$row['ReturnDate'].'</td>
	<td>'.$time.'</td>
	<td>'.$clear.'</td>
  </tr>';
  
  }
  ?>
</table>
<div class="alert" style="text-align:left">
  <span class="closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
  <strong><?php echo $numrows." Book(s) Retrived" ?> [Records Are Limited To 15]</strong><br>
  <label>Be aware That You Will pay a fine (a 50 cents per Day) for overdue books</label> 
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
