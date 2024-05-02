<?php
 
 include('authentication.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My College</title>
<link rel="stylesheet" href="Login.css">
<link rel="script" href="Register.js">
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
<header>
    <div id="hamburger-menu">&#9776;</div>
    <div style="display: flex; flex-direction: row; align-items: center;margin: 5px;"><img src="logo.png" style="height: 50px; width: 50px; border-radius: 50%;margin-right: 15px;"/>
        <h1>TECHNOLOGY COLLEGE</h1>
    </div>
    
    <nav id="navbar">
       
        <a href="#contact">Contact</a>
        <a href="#website">Website</a>
        <a href="#apply">How to Apply</a>
    </nav>
</header>
<main>
    <div class="form-container">
        <h2>FORM PURCHASE</h2><br>
        <?php
           if(isset($_SESSION['status'])){
            echo "<h4>". $_SESSION['status']."</h4>";
            unset($_SESSION['status']);
           }
        ?><br>
        <h4>Email Id: <?=$_SESSION['auth_user']['email']; ?></h4><br>
        <h4>Continue the registration by purchasing your admission form which cost 100gh cedis</h4><br>
       
           
            <a href="pay-details.html"  class='button'>PURCHASE FORMS</a>
       
       
    </div>
</main>

<script>
    document.getElementById('hamburger-menu').addEventListener('click', function() {
        var nav = document.getElementById('navbar');
        if (nav.style.display === "block") {
            nav.style.display = "none";
        } else {
            nav.style.display = "block";
        }
    });
    </script>

</body>
</html>
