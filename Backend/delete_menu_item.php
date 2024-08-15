<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
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

$id = $_GET['id'];

// Delete related records from the orders table first
$sql = "DELETE FROM orders WHERE item_id=$id";
if ($conn->query($sql) === TRUE) {
    // Now delete the menu item
    $sql = "DELETE FROM menu WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting menu item: " . $conn->error;
    }
} else {
    echo "Error deleting related orders: " . $conn->error;
}

$conn->close();
header("Location: ../Pages/ManageMenu.php");
exit();
?>
