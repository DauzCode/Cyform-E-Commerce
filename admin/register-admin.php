<?php
session_start();
include('../database/dbcon.php'); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = connect();

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt password
    $nophone = mysqli_real_escape_string($con, $_POST['phoneno']);
    $address = mysqli_real_escape_string($con, $_POST['address']);

    // Check if email already exists
    $check_email = "SELECT * FROM user WHERE email='$email'";
    $result = $con->query($check_email);

    if ($result->num_rows > 0) {
        echo '<script>alert("Email already registered. Please use another email.");</script>';
    } else {
        // Insert new admin
        $query = "INSERT INTO user (username, email, password, nophone, address, role) VALUES ('$username', '$email', '$password', '$nophone', '$address', 2)";

        if ($con->query($query) === TRUE) {
            echo '<script>alert("Registration new Admin was successfuly!"); window.location.href="register-admin.php";</script>';
        } else {
            echo '<script>alert("Error: ' . $con->error . '");</script>';
        }
    }
}
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
        background: #f8f9fa;
    }
    .login-container {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        background: white;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        border-radius: 10px;
    }
   
    .form-control {
        border-radius: 5px;
    }
</style>

<style>
        body {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #343a40;
            color: white;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
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
            margin-left: 250px; /* Ensure content does not overlap the sidebar */
            padding: 20px;
            flex-grow: 1;
            background: #f8f9fa;
            width: calc(100% - 250px); /* Adjust width dynamically */
        }


        .card {
            margin-bottom: 20px;
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
    <div class="container">
    <div class="login-container">
        <h3 class="text-center">Register New Admin</h3>
        <form method="POST">
        <div class="form-group">
                <label>Username</label>
                <input type="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="phoneno" name="phoneno" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="address" name="address" class="form-control" required>
            </div>
            <div class="form-group" align="center">
				<input type="submit" value="register" name="register" class="btn btn-primary py-3 px-5">
			 </div>
            <!--<button type="submit" name="login" class="btn btn-primary">Register</button>-->
            
        </form>
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



