<?php 
session_start();
// require '../config/db-connect.php';

$firstname = $_POST['first_name'];
$lastname = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$_SESSION['firstname'] = $_POST['first_name'];
$_SESSION['lastname'] = $_POST['last_name'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['phone'] = $_POST['phone'];



//validating against empty input
if(empty($firstname) || empty($lastname) || empty($email) || empty($phone)){
    header("location:register.php");
    exit();
};

//validating for valid email
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    header("location:../register.php");                                                                               
    exit();
};   

//validating for valid phone number
if(!preg_match('/^\d{11}$/', $phone)){ 
    header("location:../register.php");
    exit(); 
};

if(empty($error)){
    $_SESSION['firstname'] = $_POST['first_name'];
    $_SESSION['lastname'] = $_POST['last_name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['phone'] = $_POST['phone'];
    header("location: ../dashboard.php");
    exit(); 
}
?>