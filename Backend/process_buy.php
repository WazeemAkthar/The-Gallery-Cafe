<?php
session_start();
if (!isset($_SESSION['role_id'])) {
  header("Location: login.html");
  exit();
}

$servername = "localhost";
$username = "root"; // or your database username
$password = ""; // or your database password
$dbname = "thegallerycafe";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $item_id = intval($_GET['id']);
    
    // Fetch the item details from the database
    $sql = "SELECT * FROM menu WHERE id = $item_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
        // Process the purchase here, e.g., save to orders table
        // This example simply removes the item from the cart
        if (isset($_SESSION['cart'][$item_id])) {
            unset($_SESSION['cart'][$item_id]);
        }
        echo "Purchase successful!";
    } else {
        echo "Item not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
