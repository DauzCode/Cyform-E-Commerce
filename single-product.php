
<?php
session_start();
include('database/dbcon.php');
$conn = Connect();

// Check if product ID is set
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid product ID.");
}

// Get product ID from URL
$product_id = intval($_GET['id']);
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if product exists
if ($result->num_rows == 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title><?= htmlspecialchars($product['name']) ?> - Product Details</title>

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
		.custom-btn {
    background-color: #f58426; /* Default Orange Color */
    color: white;
    border: none;
    border-radius: 50px; /* Fully Rounded */
    padding: 12px 30px;
    font-size: 16px;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease-in-out;
    text-transform: uppercase;
}

.custom-btn i {
    margin-right: 8px; /* Space between icon and text */
}

.custom-btn:hover {
    background-color: #07141b; /* Dark Blue/Black Background on Hover */
    color: #f58426; /* Orange Text on Hover */
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

#userText{
	display: none;
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
	
	




	<!-- single product -->
	<div class="single-product mt-150 mb-150">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">	
						<h3><span class="orange-text">Products</span> Description</h3>
					</div>
				</div>
			</div>
		<div class="container">
			<div class="row">
				<div class="col-md-5">
					<div class="single-product-img">
						<img src="products/<?= htmlspecialchars($product['picture']) ?>">
					</div>
				</div>
				<div class="col-md-7">
					<div class="single-product-content">
						<h3><?= htmlspecialchars($product['name']) ?></h3>
						<p class="single-product-pricing">RM <?= number_format($product['price'], 2) ?></p>
						<p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
						<div class="single-product-form">
							<!--<form method="post" action="foodcart.php?action=add&id=<= $product['id'] ?>">
                            <label for="quantity">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" min="1" value="1" class="form-control w-25 mb-3">
                
								<input type="number" placeholder="0">
							</form>-->
							  <!-- Add to Cart Form -->
							  <form method="post" action="cart.php">
                				<input type="hidden" name="id" value="<?= $product['id'] ?>">
                				<input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
                				<input type="hidden" name="price" value="<?= $product['price'] ?>">
                				<input type="number" name="quantity" value="1" min="1" class="form-control w-25 mb-3">
								<button type="submit" name="add_to_cart" class="btn custom-btn"><i class="fas fa-shopping-cart"></i> Add to Cart
   								</button>
								<a href="products-login.php" name="add_to_cart" class="btn custom-btn"><i class="fa fa-arrow-left"></i> Back to Products</a>
                				<!--<button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>-->
            				</form>
								
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end single product -->

     

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


<script src="https://cdn.jsdelivr.net/npm/botman-web-widget@0.0.14/build/js/widget.js"></script>
<script id="botmanWidget" src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/chat.js'></script>
<script>
var botmanWidget = {
    frameEndpoint: 'http://localhost/cyformstudioproject/chat.html',
    chatServer: 'http://localhost/cyformstudioproject/chat-details.php?id=<?php echo $product_id; ?>',
    title: 'Cyform AI Chatbot',
    introMessage: "",
    aboutText: '',
    bubbleAvatarUrl: 'assets/img/chatbot.png',
};

setTimeout(function() {
    botmanChatWidget.say('start');
}, 1000);
</script>

</html>
<?php
$conn->close();
?>