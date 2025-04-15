<?php 
session_start();
$_SESSION['id'] = NULL;
$_SESSION['role'] = NULL;
$_SESSION['username'] = NULL;
unset($_SESSION['id']);
unset($_SESSION['role']);
unset($_SESSION['username']);
session_destroy();
echo '<script>window.location="products.php"</script>';
?>