<!DOCTYPE html>

 <!-- This page has a table to display all the authors records stored in the database -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Library System</title>
<link rel="stylesheet" type="text/css" href="Styles/main_one.css">
<link rel="stylesheet" type="text/css" href="Styles/main_two.css">
<link rel="shortcut icon" type="image/x-icon" href="../images/books-stack-of-three (2).png" />
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

</style>

</head>

<body>

<div class="header" style="overflow:hidden">
 <!-- Div to hold the page icon -->
<div id="webicon">

   <img src="../images/books-stack-of-three (2).png" width="50" height="50" style="float:left">
   <div class="imagetext">
   <h1>Get2No.com</h1>
   </div>
</div>

<div id="webtitle">
 <!-- this div holds the title of the page -->
   <div class="Heading">
   
   <h1>Admin Dashbord</h1>
   
   </div>
  
</div>


</div>

<div class="row">

 <!-- add the menu bar here-->
  
 <?php include('navigation-div.php');?>
  
	

  
<div class="column middle">
  <!-- Card display books bo -->
    <div class="card" style="width:18%;float:left;">
	
  <img src="../images/books-stack-of-three (2).png" alt="Avatar" style="width:64px;height:64px">
  <div class="card_container">
    <h4><b>Books Borrowed</b></h4> 
    <label>99 Books</label> 
  </div>
</div>

<div class="card" style="width:18%; height:10%;float:left;">
	
  <img src="../images/books-stack-of-three (2).png" alt="Avatar" style="width:64px;height:64px">
  <div class="card_container">
    <h4><b>Books Cleared</b></h4> 
    <label>99 Books</label> 
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
