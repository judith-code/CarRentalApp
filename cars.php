<?php 
$cars = [
    ['id'=>1, 'make'=> 'Totota', 'model'=> 'corolla', 'year'=> 2021, 'daily_rate'=> 50, 'status'=>'available'],
    ['id'=>2, 'make'=> 'Totota', 'model'=> 'Camry', 'year'=> 2000, 'daily_rate'=> 20, 'status'=>'rented'],
    ['id'=>3, 'make'=> 'Benz', 'model'=> 'Mercedez', 'year'=> 2012, 'daily_rate'=> 40, 'status'=>'rented'],
    ['id'=>4, 'make'=> 'Toyota', 'model'=> 'Land corolla', 'year'=> 2000, 'daily_rate'=> 25, 'status'=>'available'],
    ['id'=>5, 'make'=> 'Lamborgini', 'model'=> 'Urus', 'year'=> 2013, 'daily_rate'=> 20, 'status'=>'available'],
    ['id'=>6, 'make'=> 'Nissan', 'model'=> 'Sentra', 'year'=> 2012, 'daily_rate'=> 30, 'status'=>'rented']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rentals</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <style>
        .table{
            border-radius: 5px;
            box-shadow: 0px 4px 10px black;
            text-align: center;
            height: 300px;
        }
        .container{
           border-radius: 8px;
           box-shadow: 0px 4px 10px blue;  
           height: 500px;
           width: 1000px;
           font-family: georgia ;
        }
    </style>
</head>
<body>
    <div class="container alert-dark mt-5 mb-5 py-5">
        <div>
            <h1 class="text-center text-black ">Details Of Cars For Rent</h1>
        </div>
        <div>
            <table class="table table-hover table-sm  mt-5" >
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Daily Rate</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>
            </thead>
            <?php foreach($cars as $car){ ?>
                <tbody>
                <tr>
                    <td><?= $car['id'] ?></td>
                    <td><?= $car['make'] ?></td>
                    <td><?= $car['model'] ?></td>
                    <td><?= $car['year'] ?></td>
                    <td>$<?= $car['daily_rate'] ?></td>
                    <td><?= $car['status'] ?></td>
                    <td><a href="car.php?id=<?= $car['id']?>" class="btn btn-primary btn-sm">View Car</a></td>
                    <!-- <td><a href="assets/images/games_14-wallpaper-1680x1050.jpg" ><button class="btn btn-primary " >View Car</button></a></td> -->
                </tr>
            </tbody>
            <?php } ?>
        </table>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js" ></script>
</body>
</html>
