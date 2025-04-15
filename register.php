<?php
session_start();
include('database/dbcon.php'); // Database connection

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
        // Insert new user
        $query = "INSERT INTO user (username, email, password, nophone, address, role) VALUES ('$username', '$email', '$password', '$nophone', '$address', 1)";

        if ($con->query($query) === TRUE) {
            echo '<script>alert("Registration successful! Please login."); window.location.href="login.php";</script>';
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Cyform Studio E-Commerce</title>
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
</head>


<body>

<div class="container">
    <div class="login-container">
        <h3 class="text-center">Register Your Account</h3>
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
            <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</div>


<!-- jquery -->
<script src="assets/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- count down -->
	<script src="assets/js/jquery.countdown.js"></script>
	<!-- isotope -->
	<script src="assets/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="assets/js/waypoints.js"></script>
	<!-- owl carousel -->
	<script src="assets/js/owl.carousel.min.js"></script>
	<!-- magnific popup -->
	<script src="assets/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="assets/js/sticker.js"></script>
	<!-- main js -->
	<script src="assets/js/main.js"></script>
</body>
</html>
