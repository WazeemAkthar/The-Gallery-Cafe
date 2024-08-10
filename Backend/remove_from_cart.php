<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemId = $_POST['id'];

    // Remove the item from the cart
    if (isset($_SESSION['cart'][$itemId])) {
        unset($_SESSION['cart'][$itemId]);
        echo "Item removed from cart.";
    } else {
        echo "Item not found in cart.";
    }
}
?>
