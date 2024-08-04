<?php
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

// Fetch data
$sql = "SELECT id, item_name, item_description, item_price, item_cultures, item_type, item_image, created_at FROM menu";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Items</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Menu Items</h2>
    <button onclick="toggleForm()">Add Food Items to the Menu</button>

    <!-- Add Menu Item Form -->
    <div id="add-menu-item-form" style="display: none;">
        <h3>Add Menu Item</h3>
        <form action="../Backend/add_menu_item.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="item-name">Item Name:</label>
                <input type="text" id="item-name" name="item_name" required>
            </div>
            <div class="form-group">
                <label for="item-description">Description:</label>
                <input type="text" id="item-description" name="item_description" required>
            </div>
            <div class="form-group">
                <label for="item-price">Price:</label>
                <input type="number" id="item-price" name="item_price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="item-cultures">Food Cultures:</label>
                <input type="text" id="item-cultures" name="item_cultures" required>
            </div>
            <div class="form-group">
                <label for="item-type">Food Type:</label>
                <input type="text" id="item-type" name="item_type" required>
            </div>
            <div class="form-group">
                <label for="item-image">Image:</label>
                <input type="file" id="item-image" name="item_image" required>
            </div>
            <button type="submit">Add Item</button>
        </form>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Item Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Food Cultures</th>
            <th>Food Type</th>
            <th>Image</th>
            <th>Created At</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["item_name"] . "</td>";
                echo "<td>" . $row["item_description"] . "</td>";
                echo "<td>" . $row["item_price"] . "</td>";
                echo "<td>" . $row["item_cultures"] . "</td>";
                echo "<td>" . $row["item_type"] . "</td>";
                echo "<td><img src='" . $row["item_image"] . "' alt='Item Image' style='width:100px;height:100px;'></td>";
                echo "<td>" . $row["created_at"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No items found</td></tr>";
        }
        $conn->close();
        ?>
    </table>

    <script>
        function toggleForm() {
            var form = document.getElementById("add-menu-item-form");
            if (form.style.display === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }
    </script>
</body>
</html>
