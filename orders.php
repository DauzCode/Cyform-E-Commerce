<?php
session_start();
include('database/dbcon.php');
$conn = Connect();

$user_id = $_SESSION['username'];

//$order_sql = "SELECT * FROM order_hdr WHERE created_by = $user_id ORDER BY created_at DESC";
$order_sql = "SELECT * FROM order_hdr WHERE name = '$user_id' ORDER BY created_at DESC";
$order_result = mysqli_query($conn, $order_sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Cyform Studio E-Commerce - My Orders">

<!-- title -->
<title>My Orders - Cyform Studio</title>

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
    /* Navbar styling */
    .navbar {
        background-color: #07141D;
    }
    
    .navbar-nav .nav-link,
    .navbar-nav .dropdown-toggle,
    .navbar-nav .dropdown-item {
        font-size: 16px !important;
        font-weight: 600 !important;
        font-family: 'Poppins', sans-serif !important;
        color: white !important;
    }
    
    .username {
        text-transform: uppercase;
    }
    
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active,
    .navbar-nav .dropdown-toggle:hover {
        color: #ff6600 !important;
    }
    
    .dropdown-menu {
        background-color: #07141D !important;
        border: none;
    }
    
    .dropdown-item:hover {
        background-color: #ff6600 !important;
    }
    
    /* Order page styling */
    .order-container {
        background-color: #f9f9f9;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    
    .order-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .order-header {
        background-color: #07141D;
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .order-body {
        padding: 20px;
    }
    
    .order-item {
        display: flex;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }
    
    .order-item:last-child {
        border-bottom: none;
    }
    
    .order-item-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 15px;
    }
    
    .order-item-details {
        flex: 1;
    }
    
    .order-status {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }
    
    .status-pending {
        background-color: #FFF3CD;
        color: #856404;
    }
    
    .status-paid {
        background-color: #D4EDDA;
        color: #155724;
    }
    
    .status-shipped {
        background-color: #CCE5FF;
        color: #004085;
    }
    
    .status-delivered {
        background-color: #D1ECF1;
        color: #0C5460;
    }
    
    .status-cancelled {
        background-color: #F8D7DA;
        color: #721C24;
    }
    
    .order-summary {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-top: 15px;
    }
    
    .no-orders {
        text-align: center;
        padding: 50px;
    }
    
    .no-orders i {
        font-size: 50px;
        color: #ddd;
        margin-bottom: 20px;
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
                <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="products-login.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="orders.php">My Orders</a></li>
                    <li class="nav-item">
                        <a class="nav-link cart-icon" href="cart.php">
                            <i class="fas fa-shopping-cart">
                                (<?php
                                    if (isset($_SESSION["cart"])) {
                                        $count = count($_SESSION["cart"]);
                                        echo "$count";
                                    } else
                                        echo strtoupper("0");
                                    ?>)
                            </i>
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

<!-- order section -->
<div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">
                    <h3><span class="orange-text">My</span> Orders</h3>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="order-container">
                    <?php if (mysqli_num_rows($order_result) > 0): ?>
                        <?php while ($order = mysqli_fetch_assoc($order_result)): ?>
                            <?php
                            // Get order items for this order
                            $order_id = $order['order_id'];
                            $items_sql = "SELECT od.*, p.picture,p.name
                                          FROM order_details od 
                                          JOIN products p ON od.item = p.id 
                                          WHERE od.orderid = '$order_id'";
                            $items_result = mysqli_query($conn, $items_sql);
                            ?>
                            
                            <div class="order-card">
                                <div class="order-header">
                                    <div>
                                        <h5>Order #<?php echo $order['order_id']; ?></h5>
                                        <small>Placed on <?php echo date('M d, Y h:i A', strtotime($order['created_at'])); ?></small>
                                    </div>
                                    <div>
                                        <span class="order-status 
                                            <?php 
                                            if ($order['order_status'] == 'Pending') echo 'status-pending';
                                            elseif ($order['order_status'] == 'Confirmed') echo 'status-paid';
                                            elseif ($order['order_status'] == 'Shipped') echo 'status-shipped';
                                            elseif ($order['order_status'] == 'Delivered') echo 'status-delivered';
                                            elseif ($order['order_status'] == 'Failed') echo 'status-cancelled';
                                            ?>">
                                            <?php echo $order['order_status']; ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="order-body">
                                    <?php while ($item = mysqli_fetch_assoc($items_result)): ?>
                                        <div class="order-item">
                                            <img src="products/<?php echo htmlspecialchars($item['picture']); ?>" class="order-item-img" alt="<?php echo htmlspecialchars($item['item']); ?>">
                                            <div class="order-item-details">
                                                <h6>Order ID: <?php echo htmlspecialchars($item['ordercode']); ?></h6>
                                                <p>Quantity: <?php echo $item['quantity']; ?></p>
                                                <p>RM <?php echo number_format($item['price'], 2); ?> each</p>
                                            </div>
                                            <div class="text-right">
                                                <strong>RM <?php echo number_format($item['price'] * $item['quantity'], 2); ?></strong>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                    
                                    <div class="order-summary">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Shipping Address</h6>
                                                <p><?php echo htmlspecialchars($order['name']); ?><br>
                                                <?php echo htmlspecialchars($order['address']); ?><br>
                                                Phone: <?php echo htmlspecialchars($order['phone']); ?></p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <p>Subtotal: RM <?php echo number_format($order['total_amount'] - $order['shipping_amount'], 2); ?></p>
                                                <p>Shipping: RM <?php echo number_format($order['shipping_amount'], 2); ?></p>
                                                <h5>Total: RM <?php echo number_format($order['total_amount'], 2); ?></h5>
                                                <?php if ($order['payment_status'] == 'Success'): ?>
                                                    <span class="badge badge-success">Payment Completed</span>
                                                <?php elseif ($order['payment_status'] == 'Failed'): ?>
                                                    <span class="badge badge-danger">Payment Failed</span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">Payment Pending</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="no-orders">
                            <i class="far fa-folder-open"></i>
                            <h3>No Orders Found</h3>
                            <p>You haven't placed any orders yet. Start shopping now!</p>
                            <a href="products-login.php" class="boxed-btn">Shop Now</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end order section -->

<!-- copyright -->
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

<?php
$conn->close();
?>