<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemId = $_POST['id'];

    // Assume you have a function `getMenuItemById` to fetch the item details from the database
    $item = getMenuItemById($itemId);

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add the item to the cart
    $_SESSION['cart'][$itemId] = $item;

    echo "Item added to cart.";
}

function getMenuItemById($id) {
    // Your database connection
    $servername = "localhost";
    $username = "root"; // or your database username
    $password = ""; // or your database password
    $dbname = "thegallerycafe";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, item_name, item_price, item_image FROM menu WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $item = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    return $item;
}
?>
