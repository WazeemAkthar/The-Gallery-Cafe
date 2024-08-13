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

// Fetch menu data with join
$menu_sql = "SELECT menu.id, menu.item_name, menu.item_description, menu.item_price, 
                    food_culture.culture_name AS item_cultures, meal_type.meal_type AS item_type, 
                    menu.item_image, menu.created_at 
             FROM menu 
             JOIN food_culture ON menu.item_cultures = food_culture.id 
             JOIN meal_type ON menu.item_type = meal_type.id";
$menu_result = $conn->query($menu_sql);

// Fetch food culture data
$culture_sql = "SELECT id, culture_name, created_at FROM food_culture";
$culture_result = $conn->query($culture_sql);

// Fetch meal type data
$meal_type_sql = "SELECT id, meal_type, created_at FROM meal_type";
$meal_type_result = $conn->query($meal_type_sql);

$menu_items = [];
$food_cultures = [];
$meal_types = [];

if ($menu_result->num_rows > 0) {
    while ($row = $menu_result->fetch_assoc()) {
        $menu_items[] = $row;
    }
}

if ($culture_result->num_rows > 0) {
    while ($row = $culture_result->fetch_assoc()) {
        $food_cultures[] = $row;
    }
}

if ($meal_type_result->num_rows > 0) {
    while ($row = $meal_type_result->fetch_assoc()) {
        $meal_types[] = $row;
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

    <button onclick="navigateToPage()" class="button-64" role="button"><span class="text">
            <i class="fa fa-home"></i> Back to home</span></button>
    <script src="../JS/components.js"></script>
</body>
<script>
    function navigateToPage() {
        window.location.href = "Home.php";
    }
</script>

</html>