<?php
session_start();
if (!isset($_SESSION['role_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
</head>
<style>
    <style>.container {
        max-width: 1200px;
        width: 100%;
        padding: 20px;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    .search-bar {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .search-bar input {
        width: 50%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .filter-buttons {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .filter-buttons h3 {
        margin-bottom: 10px;
    }

    .filter-cultures,
    .filter-meal-types {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .filter-btn {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        margin: 5px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .filter-btn:hover {
        background-color: #0056b3;
    }

    .menu-container {
        display: flex;
        flex-direction: row;
        width: 100%;
    }

    .meal-type-group {
        display: flex;
        margin-bottom: 20px;
    }

    .meal-type-group h2 {
        background-color: #007bff;
        color: white;
        padding: 10px;
        border-radius: 4px;
    }

    .menu-card {
        background: white;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 250px;
        margin: 15px;
        text-align: left;
        transition: transform 0.3s ease;
    }

    .menu-card:hover {
        transform: scale(1.05);
        cursor: pointer;
    }

    .menu-card img {
        width: 100%;
        height: 150px;
        border-radius: 8px 8px 0 0;
        object-fit: cover;
    }

    .menu-card h3 {
        margin: 10px 0;
        font-size: 1.2em;
    }

    .menu-card p {
        margin: 5px 0;
        color: #555;
    }

    .description {
        padding: 15px;
    }

    .menu-card p .price {
        color: red;
    }

    .cart-link {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 20px;
    }

    .cart-link i {
        margin-right: 10px;
    }

    .cart-link .cart-count {
        background-color: red;
        color: white;
        padding: 2px 8px;
        border-radius: 50%;
        font-size: 0.8em;
        margin-left: 5px;
    }

    .buttons {
        display: flex;
        gap: 3px;
    }

    .order-btn {
        background-color: #5dbea3;
        color: white;
        padding: 10px;
        margin: 5px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: -webkit-fill-available;
    }
</style>

<body>
    <div id="header"></div>
    <div class="container">
        <h1>Your Cart</h1>
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
            <div class="menu-container">
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <div class="menu-card">
                        <img src="<?php echo $item['item_image']; ?>" alt="<?php echo $item['item_name']; ?>">
                        <div class="description">
                            <h3><?php echo $item['item_name']; ?></h3>
                            <p><?php echo $item['item_description']; ?></p>
                            <p>Rs.<?php echo $item['item_price']; ?></p>
                            <p><?php echo $item['item_cultures']; ?></p>
                            <div class="buttons">
                                <button class="order-btn" onclick="buyItem(<?php echo $item['id']; ?>)">Order Now</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
    <div id="footer"></div>
    <script>
        function buyItem(id) {
            window.location.href = '../Backend/process_buy.php?id=' + id;
        }

        function removeFromCart(id) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../Backend/remove_from_cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    location.reload();
                }
            };
            xhr.send("id=" + id);
        }
    </script>
    <script src="../JS/components.js"></script>
</body>

</html>