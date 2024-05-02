<?php
session_start();
include('database.php');

   if(isset($_POST['login_now_btn'])){
  
    if(!empty(trim( $_POST['email'])) && !empty(trim( $_POST['password']))){
       $email = mysqli_real_escape_string($conn, $_POST['email']);
       $password = mysqli_real_escape_string($conn, $_POST['password']);

       $login_query = "SELECT * FROM users WHERE email ='$email' AND password='$password'";
       $login_query_run = mysqli_query($conn, $login_query);

       if(mysqli_num_rows($login_query_run) > 0){
         $row = mysqli_fetch_array($login_query_run);
         

         if( $row['verify_status'] == '1'){
            $_SESSION['authenticated'] = TRUE;
            $_SESSION['auth_user'] = [
                'email' => $row['email'],
            ];

            $_SESSION['status'] = "You are logged in successfully";
            header("Location: purchase-form.php");
            exit(0);

         } else{
            $_SESSION['status'] = "Please verify your email address to login";
            header("Location: Login.php");
            exit(0);
         }


       } else{
        $_SESSION['status'] = "Invalid email or password";
        header("Location: Login.php");
        exit(0);
       }

    } else{
        $_SESSION['status'] = "All fields are mandatory";
        header("Location: Login.php");
        exit(0);    
    }



   
   }
?>