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

if (isset($_GET['id'])) 
    $item_id = intval($_GET['id']);
    
    // Fetch the item details from the database
    $sql = "SELECT * FROM menu WHERE id = $item_id";
    $result = $conn->query($sql);
    
    if (isset($_GET['id']) && isset($_GET['count']) && isset($_SESSION['user_id'])) {
        $item_id = $_GET['id'];
        $user_count = $_GET['count'];
        $user_id = $_SESSION['user_id'];
      
        $stmt = $conn->prepare("INSERT INTO orders (user_id, item_id, user_count, order_date) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iii", $user_id, $item_id, $user_count);
      
        if ($stmt->execute()) {
          header("Location: ../pages/orderSuccess.html");
        } else {
          echo "Failed to place order.";
        }
      
        $stmt->close();
      }      
?>
