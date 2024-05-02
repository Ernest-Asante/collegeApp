<?php
session_start();
include('database.php');

use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function send_password_reset($get_email,$token){
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
    $mail->addAddress($get_email);     //Add a recipient
  
  
    //Attachments
    
  
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Reset password notification from technology college';
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
      <h2>Password reset link from Technology College</h2>
      <h4>Reset your password. Click on the button below:</h4>
      <a href='http://localhost:3000/password-change.php?token=$token&email=$get_email' class='button'>RESET PASSWORD</a>
  </body>
  </html>";
  
    $mail->Body    = $email_template;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
  
    $mail->send();
    echo 'Message has been sent';
  
}

if(isset($_POST['password_reset_btn'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $token = md5(rand());

    $check_email = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_run = mysqli_query($conn, $check_email);

    if(mysqli_num_rows($check_email_run) > 0){
       $row = mysqli_fetch_array($check_email_run);
       $get_email = $row['email'];

       $update_token = "UPDATE users SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
       $update_token_run = mysqli_query($conn, $update_token);

       if($update_token_run){
         send_password_reset($get_email, $token);
         $_SESSION['status'] = "We have emailed you a password resset link";
         exit(0);
       } else{
        $_SESSION['status'] = "Something went wrong. Try again ";
        header("Location: password-reset.php");
        exit(0);

       }
    } else{
        $_SESSION['status'] = "No email found. ";
        header("Location: password-reset.php");
        exit(0);


    }
}

 if(isset($_POST['password-update'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $token = mysqli_real_escape_string($conn, $_POST['password_token']);

    if(!empty($token)){
        if(!empty($email) && !empty($new_password)){
           $check_token = "SELECT verify_token FROM users WHERE verify_token='$token' LIMIT 1";
           $check_token_run = mysqli_query($conn, $check_token);

           if(mysqli_num_rows($check_token_run) > 0){
            $update_password = "UPDATE users SET password='$new_password' WHERE verify_token='$token' LIMIT 1";
            $update_password_run = mysqli_query($conn, $update_password);


            if($update_password_run){
                $_SESSION['status'] = "Your password is successfully updated. ";
                header("Location: password-change.php?token=$token&email=$email");
                exit(0);

            } else{
                $_SESSION['status'] = "Did not update something went wrong. ";
                header("Location: password-change.php?token=$token&email=$email");
                exit(0);

            }
           } else{
            $_SESSION['status'] = "Invalid token. ";
            header("Location: password-change.php?token=$token&email=$email");
            exit(0);

           }
        } else{
            $_SESSION['status'] = "All fields are mandatory. ";
            header("Location: password-change.php?token$token&email=$email");
            exit(0);

        }

    } else{
        $_SESSION['status'] = "No token available. ";
        header("Location: password-change.php");
        exit(0);
    }

 }

?>