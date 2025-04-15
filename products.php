<?php
session_start();
include('database/dbcon.php');
$conn = Connect();
$sql = "SELECT * FROM products WHERE status = 'available'";
$result = mysqli_query($conn, $sql);



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
      /* Ensure all cards have the same height */
.single-product-item {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%; /* Ensures all cards take full height */
    min-height: 400px; /* Set a minimum height */
    padding: 20px;
    border-radius: 10px;
    background: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Fix image height and alignment */
.product-image img {
    width: 100%;
    height: 200px; /* Fixed height */
    object-fit: cover; /* Ensures uniform size */
    border-radius: 10px;
}

/* Ensure uniform height for product titles */
h3 {
    min-height: 50px; /* Forces consistent height */
    font-weight: bold;
}

/* Ensure uniform height for product descriptions */
.product-price {
    min-height: 30px; /* Prevents height mismatches */
    font-size: 20px;
    font-weight: bold;
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
                    
                    <li class="nav-item">
                        <a class="nav-link cart-icon" href="#" onclick="checkCartLogin()">
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
                            <span class="username"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="login.php">Login</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

	<!-- end header -->


	<!-- products 
	<div class="product-section mt-150 mb-150">
		<div class="container">
            <form method="post" action="foodcart.php?action=add&id=php echo $row["id"]; ?>">
			<div class="row product-lists">
            php if (mysqli_num_rows($result) > 0): ?>
                php while ($row = mysqli_fetch_assoc($result)): ?>
				<div class="col-lg-4 col-md-6 text-center strawberry">
					<div class="single-product-item">
						<div class="product-image">
							<a href="single-product.html"><img src="products/=($row['picture']) ?>" alt=""></a>
						</div>
						<h3>php echo $row["name"]; ?></h3>
						<p class="product-price"><span>php echo $row["description"]; ?></span>RM = number_format($row['price'], 2) ?></p>
						<a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
					</div>
				</div>
			</div>
        </form>

        php endwhile; ?>
        php else: ?>
            <div class="container">
                 <div class="jumbotron">
                    <center>
                        <label style="margin-left: 5px;color: red;"> <h1>Oops! No Products is Available.</h1> </label>
                        <p>Feel Sorryyy...! :P</p>
                    </center>
       
                </div>
            </div>
        php endif; ?>

			<div class="row">
				<div class="col-lg-12 text-center">
					<div class="pagination-wrap">
						<ul>
							<li><a href="#">Prev</a></li>
							<li><a href="#">1</a></li>
							<li><a class="active" href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">Next</a></li>
						</ul>
					</div>

                  
				</div>
			</div>




		</div>
	</div>
	 end products -->
     
<div class="container mt-5">
    <div class="row product-lists">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-lg-4 col-md-6 text-center d-flex">
                    <div class="single-product-item d-flex flex-column w-100">
                        <div class="product-image">
                            <a href="single-product.html">
                                <img src="products/<?= htmlspecialchars($row['picture']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                            </a>
                        </div>
                        <h3><?= htmlspecialchars($row['name']) ?></h3>
                        <p class="product-price">RM <?= number_format($row['price'], 2) ?></p>
                         <a href="#" class="cart-btn" onclick="checkLogin(<?= $row['id'] ?>)"><i class="fa fa-info-circle"></i> More Details</a>
                         <!--<a href="single-product.php?id=<= $row['id'] ?>" class="cart-btn"><i class="fa fa-info-circle"></i> More Details</a>-->
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <div class="jumbotron">
                    <h1 class="text-danger">Oops! No Products Available.</h1>
                    <p>Feel Sorryyy...! 😢</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>


	

    <!-- copyright -->
     <!-- Footer -->
     <footer class="text-center py-4 bg-light">
        <p>&copy; 2025 Cyform Studio Sdn Bhd. All Rights Reserved.</p>
    </footer>
	
<script>
    function checkLogin(productId) {
        <?php if (!isset($_SESSION['user_id'])) { ?>
            if (confirm("You must log in first to view this product. Do you want to log in?")) {
                window.location.href = "login.php";
            }
        <?php } else { ?>
            window.location.href = "single-product.php?id=" + productId;
        <?php } ?>
    }

    function checkCartLogin() {
        <?php if (!isset($_SESSION['user_id'])) { ?>
            if (confirm("You must log in first to view your cart. Do you want to log in?")) {
                window.location.href = "login.php?redirect=cart.php";
            }
        <?php } else { ?>
            window.location.href = "cart.php";
        <?php } ?>
    }
</script>

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
<?php
$conn->close();
?>