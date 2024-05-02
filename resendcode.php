<?php
session_start();
include('database.php');

use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function resend_email_verify($email, $verify_token){
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
  $mail->Subject = 'Resend - Email verification from technology college';
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

if(isset($_POST['resend_email_btn'])){

    if(!empty(trim($_POST['email']))){
       $email = mysqli_real_escape_string($conn, $_POST['email']);

       $checkmail_query = "SELECT * FROM users WHERE email='$email' LIMIT 1" ;
       $checkmail_query_run = mysqli_query($conn, $checkmail_query);

       if(mysqli_num_rows($checkmail_query_run) > 0){
          $row = mysqli_fetch_array($checkmail_query_run);
          if($row['verify_status'] == '0'){
             $name = $row['email'] ;
             $verify_token = $row['verify_token']; 

            resend_email_verify($email, $verify_token);

            $_SESSION['status'] = "Email link has been sent to your email. ";
            header("Location: verify-page.php");
            exit(0);
 


          } else{
            $_SESSION['status'] = "Email already verified. Please login";
            header("Location: Login.php");
            exit(0);

          }

       } else{
        $_SESSION['status'] = "Email is not registered. Please register";
        header("Location: Register.php");
        exit(0);

       }

    } else{
        $_SESSION['status'] = "Please enter the email field";
        header("Location: resend-email.php");
        exit(0);
    }
}
?>