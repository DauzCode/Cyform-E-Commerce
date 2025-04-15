<?php
session_start();
include('database/dbcon.php');
$conn = Connect();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Bootstrap4 Shop Template">

    <!-- title -->
    <title>Cyform Studio E-Commerce</title>

   <!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="assets/img/icon2.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>

<!-- Header -->
<header class="top-navbar">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/companylogo.png" alt="Logo" height="40">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link cart-icon" href="cart.php">
                            <i class="fas fa-shopping-cart">(<?php
                                echo isset($_SESSION["cart"]) ? count($_SESSION["cart"]) : "0";
                            ?>)</i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link user-icon dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> 
                            <span class="username"><?php echo strtoupper($_SESSION['username']); ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<!-- End Header -->

<div class="menu-box">
    <div class="container">
       

         
                <div class="d-flex justify-content-center align-items-center min-vh-100 text-center">
                    <div class="jumbotron text-center">
                        <h1 style="color: green;"><i class="fas fa-check-circle"></i> Order Placed Successfully.</h1>
                        <h2>Thank you for ordering at Cyform 3D Studio!</h2>
                        <a href="orders.php" class="btn btn-success btn-lg mt-3">View Order</a>
                    </div>
                </div>
            
            
       

          
        
    </div>
</div>

<!-- Footer -->
<footer class="text-center py-4 bg-light">
    <p>&copy; 2025 Cyform Studio Sdn Bhd. All Rights Reserved.</p>
</footer>

<!-- Scripts -->
<script src="assets/js/jquery-1.11.3.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>

<?php
$conn->close();
?>
