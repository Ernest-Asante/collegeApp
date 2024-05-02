<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "mydb";

// Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn == false) { 
  die("connection error". mysqli_connect_error());
 
  }else{
    echo "connected";
  }

