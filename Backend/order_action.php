<?php
// order_action.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['id'];
    $action = $_POST['action'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete the order from the orders table
    $sql = "DELETE FROM orders WHERE id = $orderId";

    if ($conn->query($sql) === TRUE) {
        echo "Order deleted successfully";
    } else {
        echo "Error deleting order: " . $conn->error;
    }

    $conn->close();
}
?>