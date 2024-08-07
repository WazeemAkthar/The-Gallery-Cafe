<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $item_id = intval($_POST['id']);
    
    if (isset($_SESSION['cart'][$item_id])) {
        unset($_SESSION['cart'][$item_id]);
        echo "Item removed from cart!";
    } else {
        echo "Item not found in cart.";
    }
} else {
    echo "Invalid request.";
}
?>
