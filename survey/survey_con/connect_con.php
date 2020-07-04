<?php

if(isset($_POST['name']) || isset($_POST['email']) || isset($_POST['ph']) || isset($_POST['timer']) || isset($_POST['sub']))
{
  $name = $_POST['name'];
  $email = $_POST['email'];
  $ph = $_POST['ph'];
  $timer = $_POST['timer'];
  $sub = $_POST['sub'];
}



if (!empty($name) || !empty($email) || !empty($ph) || !empty($timer) || !empty($sub) ) 
{
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "survey_con";
    
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) 
    {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } 
    else 
    {
     $SELECT = "SELECT email From survey_con_form Where email = ? Limit 1";
     $INSERT = "INSERT Into survey_con_form(name, email, ph, timer, sub) values(?,?,?,?,?)";
     
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
      $stmt->bind_param('ssiis', $name, $email, $ph, $timer, $sub);
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