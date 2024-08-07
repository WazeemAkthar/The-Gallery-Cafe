<?php
session_start();

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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $item_id = intval($_POST['id']);
    
    // Fetch the item details from the database
    $sql = "SELECT * FROM menu WHERE id = $item_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
        
        // Initialize cart if not set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Add item to cart
        $_SESSION['cart'][$item_id] = $item;
        
        echo "Item added to cart!";
    } else {
        echo "Item not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
