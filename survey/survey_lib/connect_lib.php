<?php

if(isset($_POST['fname']) || isset($_POST['lname']) || isset($_POST['rno']) || isset($_POST['email']) || isset($_POST['year']) || isset($_POST['subject']) || isset($_POST['book1']) || isset($_POST['book2']) || isset($_POST['book3']) )
{
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $rno = $_POST['rno'];
  $email = $_POST['email'];
  $year = $_POST['year'];
  $subject = $_POST['subject'];
  $book1 = $_POST['book1'];
  $book2 = $_POST['book2'];
  $book3 = $_POST['book3'];
}




if (!empty($fname) || !empty($lname) || !empty($rno) || !empty($email) || !empty($year) || !empty($subject) || !empty($book1) || !empty($book2) || !empty($book3)) 
{
 $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "survey_lib";
    
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) 
    {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } 
    else 
    {
     $SELECT = "SELECT email From survey_lib_form Where email = ? Limit 1";
     $INSERT = "INSERT Into survey_lib_form (fname, lname, rno, email, year, subject, book1, book2, book3) values(?,?,?,?,?,?,?,?,?)";
     
     //Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;
     
     if ($rnum==0) 
     {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param('ssisissss', $fname, $lname, $rno, $email, $year, $subject, $book1, $book2, $book3);
      $stmt->execute();
      echo "New record inserted sucessfully";
     } 
      else 
     {
      echo "Someone already register using this email";
     }
     $stmt->close();
     $conn->close();
    }
} 
else 
{
 echo "All field are required";
 die();
}
?>