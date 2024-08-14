<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "thegallerycafe";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Update order status to confirmed (You may need to add a 'status' column in the 'orders' table)
    $sql = "UPDATE orders SET status = 'confirmed' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        header("Location: ../pages/MangeAOrders.php");
    } else {
        echo "Error confirming order: " . $conn->error;
    }
}

$conn->close();
?>