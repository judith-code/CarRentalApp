<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <style>
        .container{
           background-color: yellowgreen ;
           border-radius: 8px;
           box-shadow: 0px 4px 10px blue;  
           height: 350px;
           width: 900px;
           text-align: center;
           font-family: georgia ;
        }
    </style>
</head>
<body> 
    <div class="container mt-5">
        <h1 class="py-3">Users Dashboard</h1>
        <?php 
        echo '<h2>Welcome, ' .$_SESSION['lastname'].' ' .$_SESSION['firstname']. '! </h2>';
        echo '<h4>Email: ' .$_SESSION['email']. '</h4>';
        echo '<h4>Phone Number: ' .$_SESSION['phone']. '</h4>';
        echo "<br>";
        echo "<h4>You have been successfully registered.</h4>"
        ?>
        <div>
            <p>Go 
            <a href="register.php" class='btn btn-info'>Back</a>
            to registration page
            </p>
        </div>
    </div>
<script src="assets/bootstrap/js/bootstrap.bundle.min.js" ></script>
</body>
</html>