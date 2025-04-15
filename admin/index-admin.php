<?php
session_start();
include('../database/dbcon.php');
$conn = connect();

// Fetch data from database
$productCount = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()['total'];
$customerCount = $conn->query("SELECT COUNT(*) AS total FROM user WHERE role = '1' ")->fetch_assoc()['total'];
$orderCount = $conn->query("SELECT COUNT(*) AS total FROM order_details")->fetch_assoc()['total'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="../assets/img/icon2.png">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <!-- owl carousel -->
    <link rel="stylesheet" href="../assets/css/owl.carousel.css">
    <!-- magnific popup -->
    <link rel="stylesheet" href="../assets/css/magnific-popup.css">
    <!-- animate css -->
    <link rel="stylesheet" href="../assets/css/animate.css">
    <!-- mean menu css -->
    <link rel="stylesheet" href="../assets/css/meanmenu.min.css">
    <!-- main style -->
    <link rel="stylesheet" href="../assets/css/main.css">
    <!-- responsive -->
    <link rel="stylesheet" href="../assets/css/responsive.css">

    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #343a40;
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            background: #f8f9fa;
        }
        .card {
            margin-bottom: 20px;
        }

        .css-serial {
            counter-reset: serial-number;  /* Set the serial number counter to 0 */
        }

        .css-serial td:first-child:before {
            counter-increment: serial-number;  /* Increment the serial number counter */
            content: counter(serial-number);  /* Display the counter */
        }
    </style>
</head>
<body>
    <div class="sidebar p-3">
        <h3 class="text-center"><img src="../assets/img/companylogo.png" alt="Logo" height="40"></h3>
        <a href="index-admin.php">Dashboard</a>
        <a href="add-product.php">Add Products</a>
        <a href="register-admin.php">Register Admin</a>
        <a href="manage-orders.php">Manage Orders</a>
        <a href="update-available.php">Update Product Available</a>
        <a href="../logout.php" style= "text-transform: uppercase;"><?php echo $_SESSION['username']?>(Log Out)</a>
    </div>
    <div class="content">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center bg-primary text-white">
                    <div class="card-body">
                        <h4><?php echo $productCount; ?></h4>
                        <p>Products</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-success text-white">
                    <div class="card-body">
                        <h4><?php echo $customerCount ?></h4>
                        <p>Customers</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-danger text-white">
                    <div class="card-body">
                        <h4><?php echo $orderCount ?></h4>
                        <p>Orders</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-primary text-white">View User</div>
            <div class="card-body">
                <table class="table table-bordered css-serial">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Customer Name</th>
                            <th>Customer Email</th>
                            <th>No Phone</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <?php


                    // Retrieve data from database


                    $sql="SELECT * FROM `user` WHERE role = '1'";
                    $result = $conn->query($sql);


                    // Start looping rows in mysql database.
                    $i=0;
                    if ($result->num_rows > 0) {
                    // output data of each row

                    while($row = $result->fetch_assoc())
                    {
                        $i++;


                    ?>
                    <tbody>
                    <tr>
                        <td></td>
                        <td><?php echo $row["username"]; ?></td>
                        <td><?php echo $row["email"] ?></td>
                        <td><?php echo $row["nophone"]; ?></td>
                        <td><?php echo $row["address"]; ?></td>
                        </tr>
                        <?php
                        }
                        }

                        $conn->close();?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
<!-- jquery -->
<script src="../assets/js/jquery-1.11.3.min.js"></script>
<!-- bootstrap -->
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<!-- count down -->
<script src="../assets/js/jquery.countdown.js"></script>
<!-- isotope -->
<script src="../assets/js/jquery.isotope-3.0.6.min.js"></script>
<!-- waypoints -->
<script src="../assets/js/waypoints.js"></script>
<!-- owl carousel -->
<script src="../assets/js/owl.carousel.min.js"></script>
<!-- magnific popup -->
<script src="../assets/js/jquery.magnific-popup.min.js"></script>
<!-- mean menu -->
<script src="../assets/js/jquery.meanmenu.min.js"></script>
<!-- sticker js -->
<script src="../assets/js/sticker.js"></script>
<!-- main js -->
<script src="../assets/js/main.js"></script>
</body>
</html>
