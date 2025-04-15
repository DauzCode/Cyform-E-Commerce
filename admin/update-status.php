<?php
// Database connection
include('../database/dbcon.php');
$conn = connect();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['new_status'])) {
    $id = intval($_POST['id']);
    $new_status = $_POST['new_status'];

    // Update the status in the database
    $stmt = $conn->prepare("UPDATE products SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $id);
    if ($stmt->execute()) {
        // Optional: Success message
        // echo "<script>alert('Status updated successfully!');</script>";
        
        // Refresh page to show new status
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Failed to update status.";
    }
}

// Now fetch the products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>
