<?php
$cars = [
    ['id'=>1, 'make'=> 'Totota', 'model'=> 'corolla', 'year'=> 2021, 'daily_rate'=> 50, 'status'=>'available'],
    ['id'=>2, 'make'=> 'Totota', 'model'=> 'Camry', 'year'=> 2000, 'daily_rate'=> 20, 'status'=>'rented'],
    ['id'=>3, 'make'=> 'Benz', 'model'=> 'Mercedez', 'year'=> 2012, 'daily_rate'=> 40, 'status'=>'rented'],
    ['id'=>4, 'make'=> 'Toyota', 'model'=> 'Land corolla', 'year'=> 2000, 'daily_rate'=> 25, 'status'=>'available'],
    ['id'=>5, 'make'=> 'Lamborgini', 'model'=> 'Urus', 'year'=> 2013, 'daily_rate'=> 20, 'status'=>'available'],
    ['id'=>6, 'make'=> 'Nissan', 'model'=> 'Sentra', 'year'=> 2012, 'daily_rate'=> 30, 'status'=>'rented']

];
 if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header("location: cars.php");
    exit();
 }
    $selectedCar = array_filter($cars, function($car) {
        return $car['id'] == $_GET['id'];
    });
    $selectedCar = reset($selectedCar);

    if((!$selectedCar)){
        header("location:cars.php");
        exit();
    };
    if(($_GET['id']) > 1000){
        header("location:cars.php");
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car details</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <style>
         .container{
           background-color: yellowgreen ;
           border-radius: 8px;
           box-shadow: 0px 4px 10px blue;  
           height: 530px;
           width: 1000px;
           text-align: center;
           font-family: georgia ;
        }
        .image{
            height: 210px;
            border-radius: 40px;
        }
    </style>
</head>
<body>
    <div class="container py-1 mt-5 mb-5">
        <h1 class="mt-5">Car Details</h1>
        <h3>Brand: <?php echo$selectedCar['make'] ?>;  Model:  <?php echo$selectedCar['model'] ?></h3>
        <h4>Year Created: <?php echo$selectedCar['year'] ?></h4>
        <h5>Daily Rate: <?php echo$selectedCar['daily_rate'] ?></h5>
        <h6>Status: <?php echo$selectedCar['status'] ?></h6>
        <img src="assets/images/games_14-wallpaper-1680x1050.jpg" alt="" class="image">
         <div class="mt-3">
            <a href="cars.php" class="btn btn-primary btn-sm">Back to car</a>
        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js" ></script>
</body>
</html> 