<?php
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$subject = $_POST["subject"];
$message = $_POST["message"];
 
$EmailTo = "sanilal.iconcept@gmail.com";
$Subject = "New Message from Meridian-el.com Received";
 
// prepare email body text
$Body .= "Name: ";
$Body .= $fname+" "+$lname;
$Body .= "\n";
 
$Body .= "Email: ";
$Body .= $email;
$Body .= "\n";

$Body .= "Phone: ";
$Body .= $phone;
$Body .= "\n";

$Body .= "Subject: ";
$Body .= $subject;
$Body .= "\n";

$Body .= "Message: ";
$Body .= $message;
$Body .= "\n";
 
// send email
$success = mail($EmailTo, $Subject, $Body, "From:".$email);
 
// redirect to success page
if ($success){
   header('location:contact.php?id="yes"');
}else{
    header('location:contact.php?id="no"');
}
 
?>