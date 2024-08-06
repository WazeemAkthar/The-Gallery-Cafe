<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    header("Location: login.html");
    exit();
}

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

// Fetch data from menu
$sql_menu = "SELECT menu.id, menu.item_name, menu.item_description, menu.item_price, 
        food_culture.culture_name AS item_cultures, meal_type.meal_type AS item_type, 
        menu.item_image, menu.created_at
        FROM menu 
        JOIN food_culture ON menu.item_cultures = food_culture.id 
        JOIN meal_type ON menu.item_type = meal_type.id";
$result_menu = $conn->query($sql_menu);

// Fetch data from food_culture
$sql_food_culture = "SELECT * FROM food_culture";
$result_food_culture = $conn->query($sql_food_culture);

// Fetch data from meal_type
$sql_meal_type = "SELECT * FROM meal_type";
$result_meal_type = $conn->query($sql_meal_type);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Menu</title>
    <link rel="stylesheet" href="../CSS/table_styles.css">
</head>
<body>
    <!-- Menu Table -->
    <h2>Menu</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Item Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Food Cultures</th>
            <th>Meal Type</th>
            <th>Image</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result_menu->num_rows > 0) {
            while ($row = $result_menu->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["item_name"] . "</td>";
                echo "<td>" . $row["item_description"] . "</td>";
                echo "<td>" . $row["item_price"] . "</td>";
                echo "<td>" . $row["item_cultures"] . "</td>";
                echo "<td>" . $row["item_type"] . "</td>";
                echo "<td><img src='" . $row["item_image"] . "' alt='Item Image' style='width:100px;height:100px;'></td>";
                echo "<td>" . $row["created_at"] . "</td>";
                echo "<td>
                    <button onclick=\"editItem(" . $row['id'] . ")\">Edit</button>
                    <button class='button-delete' onclick=\"deleteItem(" . $row['id'] . ")\">Delete</button>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No items found</td></tr>";
        }
        ?>
    </table>

    <!-- Food Culture Table -->
    <h2>Food Cultures</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Culture Name</th>
            <th>Created At</th>
        </tr>
        <?php
        if ($result_food_culture->num_rows > 0) {
            while ($row = $result_food_culture->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["culture_name"] . "</td>";
                echo "<td>" . $row["created_at"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No food cultures found</td></tr>";
        }
        ?>
    </table>

    <!-- Meal Type Table -->
    <h2>Meal Types</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Meal Type</th>
            <th>Created At</th>
        </tr>
        <?php
        if ($result_meal_type->num_rows > 0) {
            while ($row = $result_meal_type->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["meal_type"] . "</td>";
                echo "<td>" . $row["created_at"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No meal types found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
