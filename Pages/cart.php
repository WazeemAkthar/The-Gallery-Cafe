<?php
session_start();
if (!isset($_SESSION['role_id'])) {
    header("Location: login.html");
    exit();
}

// Fetch cart items from session
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <style>
        .cart-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .cart-buttons {
            display: flex;
            gap: 10px;
        }

        .order-btn,
        .remove-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }

        .order-btn {
            background-color: #28a745;
        }

        .remove-btn {
            background-color: #dc3545;
        }

        /* Overlay for background blur */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);
            justify-content: center;
            align-items: center;
        }

        /* Modal Content */
        .modal-content {
            background-color: white;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.5);
        }

        /* Buttons in Modal */
        .modal-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .process-btn,
        .cancel-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }

        .process-btn {
            background-color: #28a745;
        }

        .cancel-btn {
            background-color: #dc3545;
        }

        .process-btn:hover {
            background-color: #218838;
        }

        .cancel-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <div class="cart-container">
        <h1>Your Cart</h1>
        <?php if (!empty($cartItems)): ?>
            <?php foreach ($cartItems as $item): ?>
                <div class="cart-item">
                    <div>
                        <img src="<?php echo $item['item_image']; ?>" alt="<?php echo $item['item_name']; ?>">
                        <h2><?php echo $item['item_name']; ?></h2>
                        <p>Price: Rs.<?php echo $item['item_price']; ?></p>
                    </div>
                    <div class="cart-buttons">
                        <button class="order-btn" onclick="buyItem(<?php echo $item['id']; ?>)">Order</button>
                        <button class="remove-btn" onclick="removeFromCart(<?php echo $item['id']; ?>)">Remove</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <!-- Order Modal -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <h2>Order Item</h2>
            <p>How many items would you like to order?</p>
            <form id="orderForm" action="../Backend/process_buy.php" method="GET">
                <input type="hidden" name="id" id="itemIdInput">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="count" value="1" min="1" required>
                <div class="modal-buttons">
                    <button type="submit" class="process-btn">Process to Pay</button>
                    <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function buyItem(id) {
            <?php if (!isset($_SESSION['user_id'])): ?>
                window.location.href = 'login.html';
            <?php else: ?>
                // Display the modal with item ID pre-filled
                document.getElementById('itemIdInput').value = id;
                document.getElementById('orderModal').style.display = 'flex';

                // Handle form submission to process the order
                const orderForm = document.getElementById('orderForm');
                orderForm.onsubmit = function (event) {
                    event.preventDefault();

                    const quantity = document.getElementById('quantity').value;

                    // Send an AJAX request to process the order and remove the item from the cart
                    const xhr = new XMLHttpRequest();
                    xhr.open("POST", "../Backend/process_buy.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            alert("Order placed successfully!");

                            // Remove the item from the cart session on the server side
                            removeFromCart(id);

                            // Close the modal
                            closeModal();

                            // Optionally, refresh the page to update the cart view
                            window.location.reload();
                        }
                    };

                    // Send the order request with the item ID and quantity
                    xhr.send("id=" + id + "&count=" + quantity);
                };
            <?php endif; ?>
        }

        function closeModal() {
            document.getElementById('orderModal').style.display = 'none';
        }

        // Close the modal if the user clicks outside of it
        window.onclick = function (event) {
            const modal = document.getElementById('orderModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };

        // Function to remove the item from the cart session
        function removeFromCart(id) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../Backend/remove_from_cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    window.location.reload(); // Refresh the page to update the cart
                }
            };
            xhr.send("id=" + id);
        }

    </script>
</body>

</html>