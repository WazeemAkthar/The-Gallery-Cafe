<?php
session_start();
if (!isset($_SESSION['role_id'])) {
    header("Location: login.html");
    exit();
}

// Define role IDs for staff and admin
$staffRoleId = 2; // Example: 2 = Staff
$adminRoleId = 3; // Example: 1 = Admin

// Check if the user is logged in and is an admin
// if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
//     header("Location: login.html");
//     exit();
// }

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "thegallerycafe";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all orders and their statuses
$sql = "SELECT orders.id, orders.user_id, orders.item_id, orders.user_count, orders.order_date, orders.status, users.name, menu.item_name
        FROM orders
        JOIN users ON orders.user_id = users.id
        JOIN menu ON orders.item_id = menu.id
        ORDER BY orders.order_date DESC";
$result = $conn->query($sql);

function getStatusColor($status)
{
    $status = strtolower($status); // Convert to lowercase
    switch ($status) {
        case 'pending':
            return 'orange';
        case 'confirmed':
            return 'green';
        case 'cancelled':
            return 'red';
        default:
            return 'gray';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../CSS/Admin_Dashboard.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9e9e9;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .confirm-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .cancel-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>

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

    <div class="container">
        <h1>Order Status</h1>
        <table>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Order Date</th>
                <th>Status</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    $statusColor = getStatusColor($row['status']);
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['item_name']}</td>";
                    echo "<td>{$row['user_count']}</td>";
                    echo "<td>{$row['order_date']}</td>";
                    echo "<td class='status' style='background-color:{$statusColor}; color: white;'>{$row['status']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No orders found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
<script src="../JS/components.js"></script>
<script>
    function navigateToPage() {
        window.location.href = "Home.php";
    }
    function logout() {
        window.location.href = "../Backend/logout.php";
    }
</script>

</html>