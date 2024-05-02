<?php
session_start();
include('database.php');

if(isset($_GET['token'])){
   $token = $_GET['token'];
   $verify_query = "SELECT verify_token, verify_status FROM users WHERE verify_token = '$token' LIMIT 1";
   $verify_query_run = mysqli_query($conn, $verify_query);

   if(mysqli_num_rows($verify_query_run) > 0){
      $row = mysqli_fetch_array($verify_query_run);
   
      
     if($row['verify_status'] == "0"){
        $clicked_token = $row['verify_token'];
        $update_query = "UPDATE users SET verify_status='1' WHERE verify_token = '$clicked_token' LIMIT 1";
        $update_query_run = mysqli_query($conn, $update_query);

        if($update_query_run){
            $_SESSION['status'] = "Your account has been verified successfuly";
            header("Location: Login.php");
            exit(0);
        } else{
            $_SESSION['status'] = "Verification failed";
            header("Location: Login.php");
            exit(0);
        }
       } else{
        $_SESSION['status'] = "Email already verified. please login";
        header("Location: Login.php");
       }

   } else{
    $_SESSION['status'] = "This token does not exist";
    header("Location: Login.php");
   }
}else{
    $_SESSION['status'] = "Not allowed";
    header("Location: Login.php");
}
?>