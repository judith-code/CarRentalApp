<?php 
$firstname = $_POST['first_name'];
$lastname = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

session_start();
$_SESSION['firstname'] = $_POST['first_name'];
$_SESSION['lastname'] = $_POST['last_name'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['phone'] = $_POST['phone'];

echo $_SESSION['firstname'];
echo "<br>";
echo $_SESSION['lastname'];
echo "<br>";
echo $_SESSION['email'];
echo "<br>";
echo $_SESSION['phone'];

//validating against empty input
if(empty($firstname) || empty($lastname) || empty($email) || empty($phone)){
    echo"All fields are required";
    header("location:register.php");
    exit();
};
//validating for valid email
if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo "Valid email address";
}else{
    echo"Invalid email address";
    header("location:../register.php");
    exit();
};
//validating for valid phone number
if(preg_match('/^\d{11}$/', $phone)){
    echo "valid phone number";
}else{
    echo "Invalid phone number"; 
    header("location:../register.php");
    exit();        
};
if(!empty($error)){
    header("location:../register.php");
    exit(); 
}else{
    $_SESSION['firstname'] = $_POST['first_name'];
    $_SESSION['lastname'] = $_POST['last_name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['phone'] = $_POST['phone'];
    header("location: ../dashboard.php");
    exit(); 
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register process</title>
     <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Registeration Processing...</h1>
       
    </div>
<script src="assets/bootstrap/js/bootstrap.bundle.min.js" ></script>

</body>
</html>