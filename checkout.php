<?php
session_start(); // Start session
include('database/dbcon.php');
$conn = Connect();

// Check if cart exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $cart_empty = true;
} else {
    $cart_empty = false;
    $cart_items = $_SESSION['cart']; // Get cart items
}

// Calculate subtotal
$subtotal = 0;
if (!$cart_empty) {
    foreach ($cart_items as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
}
$shipping = 50;
$total = $subtotal + $shipping;



//$name = $_SESSION['username'];
$user_id = $_SESSION['id'];

// Prepare SQL to fetch user data by name
$query = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

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
    <style>

/* Push "Add to Cart" button to the bottom */
.cart-btn {
    background-color: #ff7f00;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    display: block;
    text-align: center;
    font-weight: bold;
    margin-top: auto; /* Forces button to align at bottom */
}

/* Hover Effect */
.cart-btn:hover {
    background-color: #e76e00;
}

.btn-warning {
    background-color: #ff7f3f;
    border-color: #ff7f3f;
    font-weight: bold;
}
.btn-warning:hover {
    background-color: #ff5722;
    border-color: #ff5722;
}

/* Navbar background */
.navbar {
    background-color: #07141D; /* Dark navy blue */
}

/* Apply a consistent font style */
.navbar-nav .nav-link, 
.navbar-nav .dropdown-toggle, 
.navbar-nav .dropdown-item {
    font-size: 16px !important;
    font-weight: 600 !important;
    font-family: 'Poppins', sans-serif !important;
    color: white !important;
}

/* Username should be uppercase */
.username {
    text-transform: uppercase;
}

/* Icons and spacing */
.navbar-nav .nav-link i {
    font-size: 16px !important;
    font-weight: 600 !important;
    margin-right: 5px;
}

/* Icon Hover Effect */
.navbar-nav .nav-link:hover i,
.navbar-nav .nav-link.active i {
    color: #ff6600 !important;
}

/* Hover Effects for Text */
.navbar-nav .nav-link:hover, 
.navbar-nav .nav-link.active, 
.navbar-nav .dropdown-toggle:hover {
    color: #ff6600 !important;
}

/* Fix Dropdown Styling */
.dropdown-menu {
    background-color: #07141D !important;
    border: none;
}

.dropdown-item {
    color: white !important;
    font-size: 16px !important;
    font-weight: 600 !important;
}

.dropdown-item:hover {
    background-color: #ff6600 !important;
    color: white !important;
}

.checkout-container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h3 {
            color: #ff6600;
            font-weight: bold;
            text-align: center;
        }
        .form-control {
            border-radius: 5px;
            padding: 10px;
        }
        .order-summary {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
        }
        .btn-custom {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #ff6600;
            border: none;
        }
        .btn-primary:hover {
            background-color: #e65c00;
        }

</style>

</head>
<body>
<!--PreLoader-->
<div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->

<!-- header -->
<header class="top-navbar">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/companylogo.png" alt="Logo" height="40">
            </a>

            <!-- Toggle button for mobile -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarNav">

                <!-- Cart & User Icons on the Right -->
                <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="products-login.php">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="orders.php">My Orders</a></li>
                    <li class="nav-item">
                        <a class="nav-link cart-icon" href="cart.php">
                            <i class="fas fa-shopping-cart">(<?php
							if(isset($_SESSION["cart"])){
								$count = count($_SESSION["cart"]); 
              					echo "$count"; 
								}else
                						echo "0";
              				?>)</i> 
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link user-icon dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> 
                            <span class="username"><?php echo strtoupper($_SESSION['username']); ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="logout.php">Logout</a>
                            
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- end header -->
	

<!-- Checkout Section 
<div class="checkout-section mt-5 mb-5">
    <div class="container">
    <div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">	
						<h3><span class="orange-text">Check</span> Out</h3>
					</div>
				</div>
			</div>
        <php if ($cart_empty): ?>
            <div class="d-flex justify-content-center align-items-center vh-50">
                <div class="text-center bg-light p-5 rounded shadow-lg">
                    <h1 class="text-danger fw-bold">Oops! Your cart is empty.</h1>
                    <p class="fs-5 text-muted">Feel Sorryyy...! 😢</p>
                    <a href="products.php" class="btn btn-warning btn-lg mt-3 px-4">Continue Shopping</a>
                </div>
            </div>
        <php else: ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="accordionExample">
                            <div class="card single-accordion">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne">
                                            Shipping Address
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show">
                                    <div class="card-body">
                                        <div class="billing-address-form">
                                            <form action="place_order.php" method="POST">
                                                <p><input type="text" name="name" placeholder="Name" required></p>
                                                <p><input type="email" name="email" placeholder="Email" required></p>
                                                <p><input type="text" name="address" placeholder="Address" required></p>
                                                <p><input type="tel" name="phone" placeholder="Phone" required></p>
                                                <p><textarea name="note" placeholder="Additional Notes"></textarea></p>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card single-accordion">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree">
                                            Card Details
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse">
                                    <div class="card-body">
                                        <p>Enter your payment details.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="order-details-wrap">
                        <table class="order-details">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class="order-details-body">
                                <php foreach ($cart_items as $item): ?>
                                    <tr>
                                        <td><php echo $item['name']; ?></td>
                                        <td>RM<php echo number_format($item['price'], 2); ?></td>
                                        <td><php echo $item['quantity']; ?></td>
                                        <td>RM<php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                    </tr>
                                <php endforeach; ?>
                            </tbody>
                            <tbody class="checkout-details">
                                <tr>
                                    <td>Subtotal</td>
                                    <td>RM<php echo number_format($subtotal, 2); ?></td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td>RM<php echo number_format($shipping, 2); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td><strong>RM<php echo number_format($total, 2); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="#" class="btn btn-warning btn-lg btn-block">Place Order</a>
                        <a href="#" class="btn btn-warning btn-lg btn-block">Back to Cart</a>
                    </div>
                </div>
            </div>
        <php endif; ?>
    </div>
</div>
 End Checkout Section -->

 <div class="container checkout-container">
        <h3>Check <span class="text-dark">Out</span></h3>
        
        <?php if ($cart_empty): ?>
            <div class="text-center p-5">
                <h2 class="text-danger fw-bold">Oops! Your cart is empty.</h2>
                <p class="fs-5 text-muted">Feel Sorryyy...! 😢</p>
                <a href="products.php" class="btn btn-warning btn-lg mt-3">Continue Shopping</a>
            </div>
        <?php else: ?>
            <div class="row">
                <!-- Shipping Form -->
                <div class="col-lg-6">
                    <h5 class="mb-3">Shipping Address</h5>
                    <form action="postCheckout.php" method="POST">
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Full Name" required
                            value="<?php echo htmlspecialchars($user['username']); ?>">
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email Address" required
                            value="<?php echo htmlspecialchars($user['email']); ?>">
                        </div>
                        <div class="mb-3">
                            <input type="text" name="address" class="form-control" placeholder="Shipping Address" required
                            value="<?php echo htmlspecialchars($user['address']); ?>">
                        </div>
                        <div class="mb-3">
                            <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required 
                            value="<?php echo htmlspecialchars($user['nophone']); ?>" >
                        </div>
                        <div class="mb-3">
                            <textarea name="note" class="form-control" placeholder="Additional Notes"></textarea>
                        </div>

                        <input type="hidden" name="shipping_amount" value="<?php echo $shipping; ?>">
                        <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
                    
                </div>

                <!-- Order Summary -->
                <div class="col-lg-6">
                    <h5 class="mb-3">Order Summary</h5>
                    <div class="order-summary">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart_items as $item): ?>
                                    <tr>
                                        <td><?php echo $item['name']; ?></td>
                                        <td>RM<?php echo number_format($item['price'], 2); ?></td>
                                        <td><?php echo $item['quantity']; ?></td>
                                        <td>RM<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"><strong>Subtotal</strong></td>
                                    <td>RM<?php echo number_format($subtotal, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Shipping</strong></td>
                                    <td>RM<?php echo number_format($shipping, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" name="totalprice"><strong>Total</strong></td>
                                    <td><strong>RM<?php echo number_format($total, 2); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <button class="btn btn-primary btn-custom mt-3" type="submit">Place Order</button>
                    <a href="cart.php" class="btn btn-outline-secondary btn-custom mt-2">Back to Cart</a>
                </div>
                </form>
            </div>
        <?php endif; ?>
    </div>

      <!-- Footer -->
      <footer class="text-center py-4 bg-light">
        <p>&copy; 2025 Cyform Studio Sdn Bhd. All Rights Reserved.</p>
    </footer>
	
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


