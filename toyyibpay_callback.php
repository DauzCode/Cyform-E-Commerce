<?php
session_start();
include('database/dbcon.php');
$conn = Connect();
$id = $_GET['id'];

$status_id = $_GET[ 'status_id' ] ?? NULL;
$transaction_id = $_GET[ 'transaction_id' ] ?? NULL;
$billcode = $_GET[ 'billcode' ] ?? NULL;

if($status_id == 1){
    
    $update = "UPDATE order_hdr 
    SET order_status = 'Confirmed',payment_status = 'Success',status_id = '$status_id', transaction_id = '$transaction_id', billcode = '$billcode'
    WHERE order_id = '$id'";
    mysqli_query($conn, $update);
    
    $message = 'Payment Success! Thank you for the Payment!';
}
else if($status_id == 2){
  $update = "UPDATE order_hdr 
  SET order_status = 'Failed',payment_status = 'Failed',status_id = '$status_id', transaction_id = '$transaction_id', billcode = '$billcode'
  WHERE order_id = '$id'";
    
    mysqli_query($conn, $update);
    $message = 'Whoops! Payment Failed please try again!';
}
else if($status_id == 3){
  $update = "UPDATE order_hdr 
  SET order_status = 'Failed',payment_status = 'Failed',status_id = '$status_id', transaction_id = '$transaction_id', billcode = '$billcode'
  WHERE order_id = '$id'";
    
    mysqli_query($conn, $update);

    $message = 'Whoops! Payment Failed please try again!';
}

echo "<script>alert('$message'); window.location.href='successorder.php'</script>";





