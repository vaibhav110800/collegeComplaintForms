<?php

if(isset($_POST['fname']) || isset($_POST['lname']) || isset($_POST['rno']) || isset($_POST['email']) || isset($_POST['tuck']) || isset($_POST['subject1']) || isset($_POST['mess']) || isset($_POST['subject2'])  )
{
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $rno = $_POST['rno'];
  $email = $_POST['email'];
  $tuck = $_POST['tuck'];
  $subject1 = $_POST['subject1'];
  $mess = $_POST['mess'];
  $subject2 = $_POST['subject2'];
  
}




if (!empty($fname) || !empty($lname) || !empty($rno) || !empty($email) || !empty($tuck) || !empty($subject1) || !empty($mess) || !empty($subject2) ) 
{
 $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "survey_mess";
    
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) 
    {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } 
    else 
    {
     $SELECT = "SELECT email From survey_mess_form Where email = ? Limit 1";
     $INSERT = "INSERT Into survey_mess_form (fname, lname, rno, email, tuck, subject1, mess, subject2) values(?,?,?,?,?,?,?,?)";
     
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
      $stmt->bind_param('ssisssss', $fname, $lname, $rno, $email, $tuck, $subject1, $mess, $subject2);
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