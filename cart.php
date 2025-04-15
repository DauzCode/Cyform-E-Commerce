<?php
session_start();
include('database/dbcon.php'); // Ensure database connection
$conn = connect();

// Handle "Add to Cart" Action
if (isset($_POST['add_to_cart'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Fetch product image from database
    $stmt = $conn->prepare("SELECT picture FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($picture);
    $stmt->fetch();
    $stmt->close();

    // Initialize cart if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if product is already in cart
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$id] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'picture' => $picture // Store full image path
        ];
    }

    header("Location: cart.php");
    exit();
}

// Handle "Remove from Cart" Action
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit();
}

// Handle "Clear Cart" Action
if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    header("Location: cart.php");
    exit();
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	

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
    .product-image img {
    width: 80px;  /* Adjust the width as needed */
    height: auto; /* Maintain aspect ratio */
    object-fit: contain; /* Ensures the image fits without being cropped */
    border-radius: 8px; /* Optional: Add rounded corners */
}

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

.full-height-section {
        min-height: 100vh; /* Full viewport height */
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        flex-direction: column;
    }
    
    .error-text i {
        font-size: 80px; /* Bigger icon */
        margin-bottom: 20px;
        color: #ff5a5a;
    }

    .full-height-section {
    align-items: flex-start !important;
    }

    .cart-section {
    margin-top: 0 !important;
    padding-top: 0 !important;
}

table thead th {
    background-color: black !important;
    border-color: white !important;
}

.cart-table thead th {
    color:   #ff6600 !important;
}

.add-more-btn {
    background-color: #ff7f00;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    display: block;
    text-align: center;
    font-weight: bold;
}

.add-more-btn:hover {
    background-color: #e76e00;
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
	

<!-- cart 
<div class="cart-section mt-150 mb-150">

    <div class="container">
    
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="cart-table-wrap">
                    <php if (!empty($_SESSION['cart'])): ?>
                    <table class="cart-table">
                        <thead class="cart-table-head">
                            <tr class="table-head-row">
                                <th class="product-remove"></th>
                                <th class="product-image">Product Image</th>
                                <th class="product-name">Name</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-total">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <php 
                            $total = 0;
                            foreach ($_SESSION['cart'] as $id => $item):
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
								$imagePath = !empty($item['picture']) && file_exists("products/" . $item['picture']) 
                                    ? "products/" . htmlspecialchars($item['picture']) 
                                    : "products/default.png";
                            ?>
                            <tr class="table-body-row">
                                <td class="product-remove">
                                    <a href="cart.php?remove=<= $id ?>">
                                        <i class="far fa-window-close"></i>
                                    </a>
                                </td>
                                <td class="product-image"> <img src="<= $imagePath ?>" alt="<= htmlspecialchars($item['name']) ?>"></td>
                                <td class="product-name"><= htmlspecialchars($item['name']) ?></td>
                                <td class="product-price"><= number_format($item['price'], 2) ?></td>
                                <td class="product-quantity"><= $item['quantity'] ?></td>
                                <td class="product-total"><= number_format($subtotal, 2) ?></td>
                            </tr>
                            <php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="total-section">
                    <table class="total-table">
                        <thead class="total-table-head">
                            <tr class="table-total-row">
                                <th>Total</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="total-data">
                                <td><strong>Total: </strong></td>
                                <td>RM <= number_format($total, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="cart-buttons">
                        <a href="products-login.php" class="boxed-btn">Add More</a>
                        <a href="checkout.php" class="boxed-btn black">Check Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <php else: ?>
        
		<div class="d-flex justify-content-center align-items-center min-vh-100">
    	<div class="p-5 bg-light text-center rounded shadow-lg">
        <h1 class="text-danger fw-bold">Oops! Your Cart is Emptyyy.</h1>
        <a href="products.php" class="btn btn-warning btn-lg mt-3 px-4">Continue Shopping</a>
    </div>
</div>--
<div class="full-height-section error-section d-flex align-items-center justify-content-center">
    <div class="container text-center">
        <div class="error-text">
            <i class="far fa-sad-cry fa-5x"></i>
            <h1>Oops! Your Cart is Empty.</h1>
            <a href="products-login.php" class="boxed-btn">Continue Shopping</a>
        </div>
    </div>
</div>
    <php endif; ?>
</div>
end cart -->

<!-- Cart Section -->
<div class="cart-section mt-150 mb-150 d-flex justify-content-center align-items-center min-vh-100">
    <div class="container">
   
        <?php if (!empty($_SESSION['cart'])): ?>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="cart-table-wrap shadow-sm p-4 rounded bg-white">
                        <table class="cart-table table text-center">
                            <thead class="cart-table-head bg-dark text-white">
                                <tr>
                                    <th>Remove</th>
                                    <th>Product Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $total = 0;
                                foreach ($_SESSION['cart'] as $id => $item):
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $total += $subtotal;
                                    $imagePath = !empty($item['picture']) && file_exists("products/" . $item['picture']) 
                                        ? "products/" . htmlspecialchars($item['picture']) 
                                        : "products/default.png";
                                ?>
                                <tr>
                                    <td>
                                        <a href="cart.php?remove=<?= $id ?>" class="text-danger">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                    <td><img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="img-thumbnail" width="80"></td>
                                    <td><?= htmlspecialchars($item['name']) ?></td>
                                    <td>RM <?= number_format($item['price'], 2) ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td>RM <?= number_format($subtotal, 2) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="total-section shadow-sm p-4 rounded bg-white text-center">
                        <h4 class="mb-3">Cart Summary</h4>
                        <table class="table">
                            <tr>
                                <td><strong>Total:</strong></td>
                                <td><strong>RM <?= number_format($total, 2) ?></strong></td>
                            </tr>
                        </table>
                        <div class="cart-buttons mt-3">
                            <a href="products-login.php" class="btn btn-warning btn-lg mb-2">Add More</a>
                            <a href="checkout.php" class="btn btn-dark btn-lg">Check Out</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="d-flex justify-content-center align-items-center min-vh-100 text-center">
                <div class="p-5 bg-white shadow-lg rounded">
                    <i class="far fa-sad-cry fa-5x text-danger mb-3"></i>
                    <h2 class="text-dark">Oops! Your Cart is Empty.</h2>
                    <a href="products-login.php" class="btn btn-warning btn-lg mt-3">Continue Shopping</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- End Cart Section -->



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


