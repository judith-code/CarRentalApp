<?php 
session_start();
require '../config/db-connect.php';

$car_id = $_POST['car_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$rental_date = date('Y-m-d');
$daily_rate = $_POST['daily_rate'];
$return_date = $_POST['return_date'];
$_SESSION['firstname'] = $_POST['first_name'];
$_SESSION['lastname'] = $_POST['last_name'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['phone'] = $_POST['phone'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carId = $_POST['car_id'] ?? null;
    $daily_rate = $_POST['daily_rate'] ?? null;
    $return_date = $_POST['return_date'] ?? '';
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    $_SESSION['form_data'] = $_POST; // Retain form data on error

    if (!$carId || !$returnDate || !$firstName || !$lastName || !$email || !$phone) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'All fields are required.'];
        header("Location: ../car.php?id=$carId");
        exit();
    }

    // You may want additional validation here...

    try {
        $stmt = $pdo->prepare("INSERT INTO hires (car_id, first_name, last_name, email, phone, return_date, daily_rate) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$carId, $firstName, $lastName, $email, $phone, $returnDate, $dailyRate]);

        // Update car status to 'hired'
        $updateStmt = $pdo->prepare("UPDATE cars SET status = 'hired' WHERE id = ?");
        $updateStmt->execute([$carId]);

        unset($_SESSION['form_data']); // Clear form data
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Car hired successfully! We\'ll contact you soon.'];
        header("Location: ../car-details.php?id=$carId");
        exit();
    } catch (PDOException $e) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Something went wrong while processing your request.'];
        header("Location: ../car-details.php?id=$carId");
        exit();
    }
}



//validating against empty input
if(empty($firstname) || empty($lastname) || empty($email) || empty($phone)){
    header("location:../car.php");
    exit();
};

//validating for valid email
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    header("location:../car.php");                                                                               
    exit();
};   

//validating for valid phone number
if(!preg_match('/^\d{13}$/', $phone)){ 
    header("location:../car.php");
    exit(); 
};


$rental_dateObj = new DateTime($rental_date);
$return_dateObj = new DateTime($return_date);
$interval = $rental_dateObj->diff($return_dateObj);
$days = $interval->days;

$total_cost = $daily_rate * $days;

$sql = "SELECT * FROM customers WHERE email = ? ";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if($customer){
    $customer_id = $customer['id'];
    $sql = "INSERT INTO rentals (customer_id, car_id, rental_date, return_date, total_cost ) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$customer_id, $car_id, $rental_date, $return_date, $total_cost]);

    $sql = "UPDATE cars SET `status`='rented' WHERE id=? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$car_id]);

    header('location:../cars.php');
}else{
    $sql = "INSERT INTO customers (first_name, last_name, phone, email ) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$first_name, $last_name, $phone, $email]);

    $sql = "SELECT * FROM customers WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    $customer_id = $customer['id'];
    $sql = "INSERT INTO rentals (customer_id, car_id, rental_date, return_date, total_cost ) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$customer_id, $car_id, $rental_date, $return_date, $total_cost]);
    header('location:../cars.php');

    $sql = "UPDATE cars SET `status`='rented' WHERE id=? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$car_id]);

};
?>