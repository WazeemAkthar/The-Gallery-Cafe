<?php
session_start();

// Ensure the user is an admin
// if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
//     header("Location: login.html");
//     exit();
// }

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "thegallerycafe";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders
$sql = "SELECT orders.id, users.name, menu.item_name, orders.user_count, orders.order_date, orders.status
        FROM orders
        JOIN users ON orders.user_id = users.id
        JOIN menu ON orders.item_id = menu.id
        ORDER BY orders.order_date DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Order ID</th><th>User</th><th>Item</th><th>Quantity</th><th>Order Date</th><th>Status</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['item_name']}</td>";
        echo "<td>{$row['user_count']}</td>";
        echo "<td>{$row['order_date']}</td>";
        echo "<td>{$row['status']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No orders found";
}

$conn->close();
?>
