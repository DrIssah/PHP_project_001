<?php

//this function receive student email and returns the student id associated with that email
function getStudentId($email){
//get the connection file
include('includes/db_config.php');

//select query
$query = "SELECT StudentId FROM tbl_students WHERE Email = '$email'";

//execute query
$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

$row = mysqli_fetch_assoc($results);
//get student id from the query resukts
$Student_id = $row['StudentId'];

return $Student_id;
}

//check for stuent id, actually it receives student id and checks it in database
//if available then it returns > 0 value else 0
function Check_stdid($stdid){

    //include connection file
include('includes/db_config.php');

//select query
$query = "SELECT * FROM tbl_students WHERE StudentId = '$stdid'";

//execute query
$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

$num_rows = mysqli_num_rows($results);

return $num_rows;
}


//checks student id but receives a student id
//tries to confirm if the student id is registered
function Check_stdid_two($stdid){

    //include connection file
include('includes/db_config.php');

$query = "SELECT * FROM availabestudentid WHERE StudentId = '$stdid'";

$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

$num_rows = mysqli_num_rows($results);

return $num_rows;
}

//check email
//ckecks if student email belongs to the student email supplied

function check_email($email,$sid){

    //include the connection file
include('includes/db_config.php');

//select all recors from student where email and student id much the supplied values
$query = "SELECT * FROM tbl_students WHERE Email = '$email' AND StudentId != '$sid'";

//execute query
$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

//nuber of rows
$num_rows = mysqli_num_rows($results);

//return number of rows
return $num_rows;

}

//Check isbn  number
//this function checks if there is a book with the supplied isbn number
function check_ISBN($Isbn){

include('includes/db_config.php');

//select query
$query = "SELECT * FROM tblbooks WHERE ISBNNumber = '$Isbn'";

$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

//get the number of rows returned
$num_rows = mysqli_num_rows($results);

//return number of rows
return $num_rows;

}

//check student if he/she has a book
//this function tries to check if a student has a book or borrowed a book and has not returned yet
//return val > 0 if he has a book, o otherwise
function check_ifhasbook($stdid){

include('includes/db_config.php');

$query = "SELECT * FROM tblissuedbookdetails WHERE StudentId = '$stdid' AND ReturnStatus = 1";

$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

$num_rows = mysqli_num_rows($results);

return $num_rows;

}

//get book id borrowed
//this function returns book id for a book that a student with the supplied
//student id borrowed

function getBookId_Borrowed($std_id){

include('includes/db_config.php');

$query = "SELECT BookId FROM tblissuedbookdetails WHERE StudentId = '$std_id' AND ReturnStatus = 1";

$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

$row = mysqli_fetch_assoc($results);

$book_id = $row['BookId'];

return $book_id;
}

//This function returns a book isbn number for a given book id number
//
function getBookISBN_Borrowed($Book_id){

include('includes/db_config.php');

$query = "SELECT ISBNNumber FROM tblbooks WHERE id = '$Book_id'";

$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

$row = mysqli_fetch_assoc($results);

$book_id = $row['ISBNNumber'];

return $book_id;
}


//this function returns the number of books with the given book category name
//if value returned is >= 1 then it means book category alread exists and we should not
//add search category name since it will create duplicates
function getBookCategory($Book_category){

include('includes/db_config.php');

$query = "SELECT CategoryName FROM tblcategory WHERE CategoryName = '$Book_category'";

$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

$num_rows = mysqli_num_rows($results);

return $num_rows;
}

//this fnction tries to check if a book author name exists in the database
//if a author exists then it returns a value > 0 else 0
function getBookAuthor($Book_author){

include('includes/db_config.php');

$query = "SELECT AuthorName FROM tblauthors WHERE AuthorName = '$Book_author'";

$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

$num_rows = mysqli_num_rows($results);

return $num_rows;
}

//this function checks if a book is registered and is available in the library
//if book is available then it returns a value > 0, 0 otherwise
function check_ifbookinlibrary($bk_isbn){

include('includes/db_config.php');

$query = "SELECT * FROM tblbooks WHERE ISBNNumber = '$bk_isbn' AND Status = 0";

$results=mysqli_query($conn,$query) or die(mysqli_error($conn));

$num_rows = mysqli_num_rows($results);

return $num_rows;

}

?>

