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
    <title>Manage Menu</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../CSS/Admin_Dashboard.css">
</head>

<body>
    <h1>Welcome, Admin <?php echo $_SESSION['name']; ?></h1>
    <div id="adminNav"></div>
    <!----------------------------------------------- Manage Menu Foods and Drinks ----------------------------------------------->
    <div id="dashboard2">
        <!-- Add a New Food culture -->
        <div id="form1" class="form-container">
            <h3>Add a New Food culture</h3>
            <form action="../Backend/add_food_culture.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="item-name">Food culture:</label>
                    <input type="text" id="item-name" name="item-name" required />
                </div>
                <div class="button-contaiiner">
                    <button type="submit">Save Item</button>
                    <button type="cancel" onclick="showForm(null)">Cancel</button>
                </div>
            </form>
        </div>

        <!-- Add New Meal Type -->
        <div id="form2" class="form-container">
            <h3>Add New Meal Type</h3>
            <form action="../Backend/add_meal_type.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="item-name">Meal Type:</label>
                    <input type="text" id="item-name" name="item-name" required />
                </div>
                <div class="button-contaiiner">
                    <button type="submit">Save Item</button>
                    <button type="cancel" onclick="showForm(null)">Cancel</button>
                </div>
            </form>
        </div>

        <!-- Add New Food or Drinks Item -->

        <div id="form3" class="form-container">
            <h3>Add Menu Item</h3>
            <form action="../Backend/add_menu_item.php" method="post" enctype="multipart/form-data">
                <div class="form-style">
                    <div class="form-group">
                        <label for="item-name">Item Name:</label>
                        <input type="text" id="item-name" name="item_name" required />
                    </div>
                    <div class="form-group">
                        <label for="item-cultures">Food Cultures:</label>
                        <select id="item-cultures" name="item_cultures" required>
                            <?php
                            foreach ($food_cultures as $culture) {
                                echo "<option value=\"" . $culture['id'] . "\">" . $culture['culture_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="item-price">Price:</label>
                        <input type="number" id="item-price" name="item_price" step="0.01" required />
                    </div>

                    <div class="form-group">
                        <label for="item-description">Description:</label>
                        <input type="text" id="item-description" name="item_description" required />
                    </div>
                    <div class="form-group">
                        <label for="item-type">Meal Type:</label>
                        <select id="item-type" name="item_type" required>
                            <?php
                            foreach ($meal_types as $meal_type) {
                                echo "<option value=\"" . $meal_type['id'] . "\">" . $meal_type['meal_type'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="item-image">Image:</label>
                        <input type="file" id="item-image" name="item_image" required />
                    </div>
                </div>
                <div class="button-contaiiner">
                    <button type="submit">Save Item</button>
                    <button type="cancel" onclick="showForm(null)">Cancel</button>
                </div>

            </form>
        </div>

        <div class="table-card">
            <!-- Food Cultures Table -->
            <div class="table-container Food-Cultures">

                <div class="title1">
                    <h2>Food Cultures</h2>

                    <button class="button-add" onclick="showForm('form1')">
                        <i class="material-icons">add</i>
                        Add a New Food culture
                    </button>

                </div>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Culture Name</th>
                        <th>Created At</th>
                    </tr>
                    <?php
                    if (!empty($food_cultures)) {
                        foreach ($food_cultures as $culture) {
                            echo "<tr>";
                            echo "<td>{$culture['id']}</td>";
                            echo "<td>{$culture['culture_name']}</td>";
                            echo "<td>{$culture['created_at']}</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No cultures found</td></tr>";
                    }
                    ?>
                </table>
            </div>

            <!-- Menu Items Table -->
            <div class="table-container Meal-Types">

                <div class="title1">
                    <h2>Meal Types</h2>
                    <button class="button-add" onclick="showForm('form2')"><i class="material-icons">add</i> Add New
                        Meal Type</button>
                </div>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Meal Type</th>
                        <th>Created At</th>
                    </tr>
                    <?php
                    if (!empty($meal_types)) {
                        foreach ($meal_types as $type) {
                            echo "<tr>";
                            echo "<td>{$type['id']}</td>";
                            echo "<td>{$type['meal_type']}</td>";
                            echo "<td>{$type['created_at']}</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No meal types found</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
        <div class="table-container Foods-And-Drinks">
            <div class="title1">
                <h2>Foods And Drinks</h2>
                <button class="button-add" onclick="showForm('form3')"><i class="material-icons">add</i> Add New Food or
                    Drinks Item</button>
            </div>

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
                if (!empty($menu_items)) {
                    foreach ($menu_items as $item) {
                        echo "<tr>";
                        echo "<td>{$item['id']}</td>";
                        echo "<td>{$item['item_name']}</td>";
                        echo "<td>{$item['item_description']}</td>";
                        echo "<td>{$item['item_price']}</td>";
                        echo "<td>{$item['item_cultures']}</td>";
                        echo "<td>{$item['item_type']}</td>";
                        echo "<td><img src='{$item['item_image']}' alt='Item Image' style='width:100px;height:100px;'></td>";
                        echo "<td>{$item['created_at']}</td>";
                        echo "<td>
                        <button class='button-edit' onclick=\"editItem({$item['id']})\"><i class='material-icons'>edit</i>Edit</button>
                        <button class='button-delete' onclick=\"deleteItem({$item['id']})\"><i class='material-icons'>delete</i>Delete</button>
                    </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No items found</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>



    <div id="formOverlay" class="form-overlay"></div>

    <script>

        function showForm(formId) {
            document.getElementById('form1').classList.remove('active');
            document.getElementById('form2').classList.remove('active');
            document.getElementById('form3').classList.remove('active');
            document.getElementById('formOverlay').classList.remove('active');
            if (formId) {
                document.getElementById(formId).classList.add('active');
                document.getElementById('formOverlay').classList.add('active');
            }
        }

        showForm(null);

        document.getElementById('formOverlay').addEventListener('click', function () {
            showForm(null);
        });

        function editItem(id) {
            // Redirect to an edit page with the item ID
            window.location.href = '../Backend/edit_menu_item.php?id=' + id;
        }

        function deleteItem(id) {
            if (confirm('Are you sure you want to delete this item?')) {
                // Send a request to delete the item
                window.location.href = '../Backend/delete_menu_item.php?id=' + id;
            }
        }
    </script>
    <script src="../JS/components.js"></script>
</body>

</html>