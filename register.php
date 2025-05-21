
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration page</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

</head>
<body>
    <div class="container mt-5 ">
        <h1 class="text-center">Register here!</h1>
        <form action="processes/register-process.php" method="post">
            <label for="text">First Name:</label>
            <input type="text" name="first_name" id="" required class="form-control">
            <label for="text">Last Name:</label>
            <input type="text" name="last_name" id="" required class="form-control">
            <label for="email">Email Address:</label>
            <input type="email" name="email" id="" required class="form-control">
            <label for="tel">Phone Number:</label>
            <input type="tel" name="phone" id="" required class="form-control">
            <button type="submit" class="btn btn-primary mt-2">submit</button>
        </form>
    </div>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js" ></script>
</body>
</html>