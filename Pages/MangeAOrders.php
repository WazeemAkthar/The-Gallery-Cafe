<?php
session_start();
if (!isset($_SESSION['role_id'])) {
    header("Location: login.html");
    exit();
}

// Define role IDs for staff and admin
$staffRoleId = 2; // Example: 2 = Staff
$adminRoleId = 3; // Example: 1 = Admin


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

// Fetch all orders with user and item data
$sql = "SELECT orders.id as order_id, orders.user_count, orders.order_date, users.id as user_id, users.name as user_name, users.email as user_email, menu.item_name 
        FROM orders 
        JOIN users ON orders.user_id = users.id 
        JOIN menu ON orders.item_id = menu.id 
        ORDER BY orders.order_date DESC";

$result = $conn->query($sql);

$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../CSS/Admin_Dashboard.css">
</head>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #f4f4f4;
    }

    .action-buttons a {
        margin-right: 10px;
        padding: 5px 10px;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }

    .confirm-button {
        background-color: #28a745;
    }

    .cancel-button {
        background-color: #dc3545;
    }
</style>

<body>
    <!-- <div id="adminNav"></div> -->
    <?php if ($_SESSION['role_id'] == $staffRoleId): ?>
        <!-- Display staff header if the user is a staff member -->
        <div id="staffheader"></div>
    <?php elseif ($_SESSION['role_id'] == $adminRoleId): ?>
        <!-- Display admin navbar if the user is an admin -->
        <div id="adminNav"></div>
    <?php else: ?>
        <!-- Display a default navbar or message if the user is neither staff nor admin -->
        <div id="defaultNav">You are not authorized to view this content.</div>
    <?php endif; ?>

    <div class="adminCheckbtn">
        <button onclick="navigateToPage()" class="button-64" role="button"><span class="text">
                <i class="fa fa-home"></i> Back to home</span></button>
        <button onclick="logout()" class="button-64" role="button"><span class="text">
                Logout <i class="fa fa-sign-out"></i></span></button>
    </div>

    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>
    (<?php echo htmlspecialchars($_SESSION['role_name']); ?>)</h1>

    <h1>Orders Management</h1>
    <table>
        <tr>
            <th>Order ID</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Order Date</th>
            <th>Actions</th>
        </tr>
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo $order['user_name']; ?></td>
                    <td><?php echo $order['user_email']; ?></td>
                    <td><?php echo $order['item_name']; ?></td>
                    <td><?php echo $order['user_count']; ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                    <td class="action-buttons">
                        <a href="../Backend/confirm_order.php?id=<?php echo $order['order_id']; ?>"
                            class="confirm-button">Confirm</a>
                        <a href="../Backend/cancel_order.php?id=<?php echo $order['order_id']; ?>"
                            class="cancel-button">Cancel</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No orders found</td>
            </tr>
        <?php endif; ?>
    </table>


    <script src="../JS/components.js"></script>
    <script>
        function navigateToPage() {
            window.location.href = "Home.php";
        }
        function logout() {
            window.location.href = "../Backend/logout.php";
        }
    </script>
</body>


</html>