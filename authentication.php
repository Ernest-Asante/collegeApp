<?php
session_start();

if(!isset($_SESSION['authenticated'])){
    $_SESSION['status'] = "Please login to access our dashboard";
    header('Location: Login.php');
    exit(0);
}
?>