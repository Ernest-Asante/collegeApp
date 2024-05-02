<?php
 session_start();

 if(!isset($_SESSION['authenticated'])){
    $_SESSION['status'] = "You are already logged in";
    header('Location: purchase-form.php');
    exit(0);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My College</title>
<link rel="stylesheet" href="Login.css">
<link rel="script" href="Register.js">
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
        <h3>RESEND EMAIL VERIFICATION</h3>
       
        <form action="resendcode.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit" name="resend_email_btn">SUBMIT</button>
        </form>
       
       
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
