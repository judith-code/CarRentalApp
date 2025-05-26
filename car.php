<?php
// $cars = [
//     ['id'=>1, 'make'=> 'Totota', 'model'=> 'corolla', 'year'=> 2021, 'daily_rate'=> 50, 'status'=>'available'],
//     ['id'=>2, 'make'=> 'Totota', 'model'=> 'Camry', 'year'=> 2000, 'daily_rate'=> 20, 'status'=>'rented'],
//     ['id'=>3, 'make'=> 'Benz', 'model'=> 'Mercedez', 'year'=> 2012, 'daily_rate'=> 40, 'status'=>'rented'],
//     ['id'=>4, 'make'=> 'Toyota', 'model'=> 'Land corolla', 'year'=> 2000, 'daily_rate'=> 25, 'status'=>'available'],
//     ['id'=>5, 'make'=> 'Lamborgini', 'model'=> 'Urus', 'year'=> 2013, 'daily_rate'=> 20, 'status'=>'available'],
//     ['id'=>6, 'make'=> 'Nissan', 'model'=> 'Sentra', 'year'=> 2012, 'daily_rate'=> 30, 'status'=>'rented']

// ];
$selectedCarId = $_GET['id'] ;

require_once 'config/db-connect.php';
$sql = "SELECT * FROM cars WHERE id= ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$selectedCarId]);
$selectedCar= $stmt->fetch(PDO::FETCH_ASSOC);


 if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header("location: cars.php");
    exit();
 };
    // $selectedCar = array_filter($cars, function($car) {
    //     return $car['id'] == $_GET['id'];
    // });
    // $selectedCar = reset($selectedCar);

    if((!$selectedCar)){
        header("location:cars.php");
        exit();
    };
    if(($_GET['id']) > 1000){
        header("location:cars.php");
        exit();
    };
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
           background-color: grey ;
           border-radius: 8px;
           box-shadow: 0px 4px 15px blue;
           height: 1000px;
           width: 1100px;
           font-family: georgia ;
        }
         .content{
           text-align: center;
        }
        img{
            height: 130px;
            width: 250px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    
    <div class="container  py-1 mt-5 mb-5">
        <div class='mt-3'>
            <a href="cars.php" class="btn btn-primary btn-sm">Back to cars list</a>
        </div>
        <div class="content">
            <h1 class="mt-5">Car Details</h1>
        <h3>Brand: <?php echo $selectedCar['make']  ?></h3>
        <h3> Model:  <?php echo $selectedCar['model'] ?></h3>
        <h3>Year: <?php echo $selectedCar['year'] ?></h3>
        <h3>Daily Rate: $<?php echo $selectedCar['daily_rate'] ?></h3>
        <h3>Status: <?php echo $selectedCar['status'] ?></h3>
        <div>
            <img src="assets/images/games_14-wallpaper-1680x1050.jpg" alt="">
        </div>
        
        </div>
        <div class="form mt-5">
        <h1 class="text-center">Hire your desired car!</h1>
            <form action="processes/hire-process.php" method="post">
                <input type="hidden" name="car_id" value="<?php echo $selectedCarId ?>">
                <input type="hidden" name="daily_rate" id="" value="<?php echo $selectedCar['daily_rate'] ?>">

                <input type="hidden" name="rental_date"><br>

                <label for="number">Return Date:</label>
                <input type="date" name="return_date" id="" required class="form-control" min= <?= date("Y-m-d"); ?> 
                max=<?= date('Y-m-d', strtotime('+7 days') ) ?>>
                <input type="number" name="car_id" class="form-control" value="<?= $selectedCarId ?>" hidden>

                <label for="text">First Name:</label>
                <input type="text" name="first_name" id="" required class="form-control">

                <label for="text">Last Name:</label>
                <input type="text" name="last_name" id="" required class="form-control">

                <label for="email">Email Address:</label>
                <input type="email" name="email" id="" required class="form-control">

                <label for="tel">Phone Number:</label>
                <input type="tel" name="phone" id="" required class="form-control">
                
                <button type="submit" class="btn btn-primary mt-2">Hire</button>
            </form>
    </div>
    </div>
    
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js" ></script>
</body>
</html> 