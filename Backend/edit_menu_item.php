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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $item_name = $conn->real_escape_string($_POST['item_name']);
  $item_description = $conn->real_escape_string($_POST['item_description']);
  $item_price = $conn->real_escape_string($_POST['item_price']);
  $item_cultures = $conn->real_escape_string($_POST['item_cultures']);
  $item_type = $conn->real_escape_string($_POST['item_type']);

  // Update query
  $sql = "UPDATE menu SET item_name='$item_name', item_description='$item_description', item_price='$item_price', item_cultures='$item_cultures', item_type='$item_type' WHERE id=$id";

  if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $conn->error;
  }

  $conn->close();
  header("Location: ../Pages/ManageMenu.php"); // Redirect back to the table page
  exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "SELECT * FROM menu WHERE id=$id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $item = $result->fetch_assoc();

    // Fetch food cultures
    $sql_food_cultures = "SELECT id, culture_name FROM food_culture";
    $result_food_cultures = $conn->query($sql_food_cultures);

    // Fetch meal types
    $sql_meal_types = "SELECT id, meal_type FROM meal_type";
    $result_meal_types = $conn->query($sql_meal_types);
  } else {
    echo "No menu item found with the given ID.";
    exit();
  }
} else {
  echo "No ID parameter found in the URL.";
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Menu Item</title>
  <link rel="stylesheet" href="../CSS/form_styles.css">
</head>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
  }

  form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
  }

  form input[type="text"],
  form input[type="number"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  form button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
  }

  form button:hover {
    background-color: #45a049;
  }
</style>

<body>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
    <label for="item_name">Item Name:</label>
    <input type="text" id="item_name" name="item_name" value="<?php echo $item['item_name']; ?>" required>
    <br>
    <label for="item_description">Description:</label>
    <input type="text" id="item_description" name="item_description" value="<?php echo $item['item_description']; ?>"
      required>
    <br>
    <label for="item_price">Price:</label>
    <input type="number" id="item_price" name="item_price" value="<?php echo $item['item_price']; ?>" step="0.01"
      required>
    <br>
    <label for="item_cultures">Food Cultures:</label>
    <select id="item_cultures" name="item_cultures" required>
      <?php while ($row = $result_food_cultures->fetch_assoc()): ?>
        <option value="<?php echo $row['id']; ?>" <?php echo ($item['item_cultures'] == $row['id']) ? 'selected' : ''; ?>>
          <?php echo $row['culture_name']; ?>
        </option>
      <?php endwhile; ?>
    </select>
    <br>
    <label for="item_type">Meal Type:</label>
    <select id="item_type" name="item_type" required>
      <?php while ($row = $result_meal_types->fetch_assoc()): ?>
        <option value="<?php echo $row['id']; ?>" <?php echo ($item['item_type'] == $row['id']) ? 'selected' : ''; ?>>
          <?php echo $row['meal_type']; ?>
        </option>
      <?php endwhile; ?>
    </select>
    <br>
    <button type="submit">Update Item</button>
  </form>
</body>

</html>