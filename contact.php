<?php
// session_start();
// $username = $_SESSION['username'];
// $email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
</head>
<body>
    <div class="container">
        <form action="submit" method="post">
            <input type="text" name="username" id="" class="form-control">
            <input type="email" name="email" id="" class="form-control">
            <input type="submit" value="submit" class="btn btn-primary">
        </form>
    </div>
    <div>
        <a href="cars.php" class="btn btn-primary btn-sm">Cars</a>
    </div>
</body>
</html>