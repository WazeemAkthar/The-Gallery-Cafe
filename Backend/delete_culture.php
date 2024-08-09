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

// Delete from food_culture table
$sql = "DELETE FROM food_culture WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ../Pages/ManageMenu.php");
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
