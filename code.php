<?php

session_start();

include('database.php');

use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
function sendmail_verify($email, $verify_token){
  $mail = new PHPMailer(true);

  //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
  $mail->isSMTP();                                            //Send using SMTP
  $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
  $mail->Username   = 'waecbay@gmail.com';
 
  $mail->Password   = 'puae vhmw tugh ltrb';                               //SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
  $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

  //Recipients
  $mail->setFrom('waecbay@gmail.com', 'TECH-CO');
  $mail->addAddress($email);     //Add a recipient


  //Attachments
  

  //Content
  $mail->isHTML(true);                                  //Set email format to HTML
  $mail->Subject = 'Email verification from technology college';
  $email_template = "
  <html>
<head>
    <style>
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            background-color: black;
            color: white;
            text-decoration: none;
            border: 2px solid white;
            border-radius: 5px;
            text-align: center;
        }
        .button:hover {
            background-color: white;
            color: black;
        }
    </style>
</head>
<body>
    <h2>You have registered with Technology College</h2>
    <h4>Verify your email address to continue. Click on the button below:</h4>
    <a href='http://localhost:3000/verify-email.php?token=$verify_token' class='button'>VERIFY EMAIL</a>
</body>
</html>";

  $mail->Body    = $email_template;
  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

  $mail->send();
  echo 'Message has been sent';

}

if(isset($_POST['register-btn'])){
    $email = $_POST['email'];
    $password = $_POST['password'];  
    $verify_token = md5(rand()); 



$check_email_query = "SELECT email from users WHERE email = '$email' LIMIT 1 ";
$check_email_query_run = mysqli_query($conn, $check_email_query);

if(mysqli_num_rows($check_email_query_run) > 0){
 $_SESSION['status'] = "Email Id already exists";
 header("Location: Register.php");
} else{
 $query = "INSERT INTO users(email, password, verify_token) VALUES ('$email', '$password', '$verify_token')";
 $query_run = mysqli_query($conn, $query);

 if($query_run){
    sendmail_verify("$email", "$verify_token");
    $_SESSION['status'] = "Registration successfull. Please verify your email address";
    header('Location: verify-page.php');
 } else{
    $_SESSION['status'] = "Registration failed.";
    header('Location: Register.php');
 }
}
}

?>