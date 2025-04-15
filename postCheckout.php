<?php
session_start();
date_default_timezone_set("Asia/Kuala_Lumpur");
include('database/dbcon.php');
$conn = Connect();
$toyyibpay_secret_key = 'm6xbdv9o-rn2s-85jc-0k9d-ykqfml4xw561';
$category_code = 'cyqbgb0k';
require_once 'Toyyibpay.php';
$paymentGateway = new ToyyibPay($toyyibpay_secret_key);
$base_url = 'http://localhost/cyformstudioproject/';

$uid = $_SESSION['id'];

$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$note = mysqli_real_escape_string($conn, $_POST['note']);
$shipping_amount = mysqli_real_escape_string($conn, $_POST['shipping_amount']);
$total_amount = mysqli_real_escape_string($conn, $_POST['total_amount']);

 // Generate a unique order ID
 $key = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
 $code = "";
 for ($i = 0; $i < 5; ++$i)
     $code .= $key[rand(0, strlen($key) - 1)];

 // Get the last inserted order ID
 $autoInc_id = mysqli_insert_id($conn);
 $order_id = $code . $autoInc_id;

$insert = "INSERT INTO order_hdr (name, email, address, phone, note, shipping_amount, total_amount, created_by, order_status, payment_status) 
VALUES ('$name', '$email','$address','$phone','$note','$shipping_amount','$total_amount','$uid','Pending','Pending')";    

mysqli_query($conn, $insert);

$last_id = mysqli_insert_id($conn);

$cart_items = $_SESSION['cart'];

foreach ($cart_items as $item){

$itemid = $item['id'];
$price = $item['price'];
$quantity = $item['quantity'];
$username = mysqli_real_escape_string($conn, $_POST['name']);

//$insertdt = "INSERT INTO order_details (orderid, item, price, quantity) 
//VALUES ('$last_id', '$itemid','$price','$quantity')";    



$insertdt = "INSERT INTO order_details (orderid, ordercode, item, price, quantity, custname) 
VALUES ('$last_id', '$order_id', '$itemid','$price','$quantity', '$username')";  

mysqli_query($conn, $insertdt);

}

unset($_SESSION['cart']);

$bill = $paymentGateway->createBill( $category_code, 'CYFORM', 'CYFORM', 'CYFORM')
                        ->payer( $name, $email, $phone)
                        ->amount($total_amount)
                        ->chargeToCustomer(2)
                        ->callbackUrl("{$base_url}toyyibpay_callback.php?id=$last_id")
                        ->emailContent('Thank you for your Payment!');

                        echo $bill->redirectToPaymentUrl();
