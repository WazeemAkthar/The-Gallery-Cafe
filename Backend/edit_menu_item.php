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
  $item_name = $_POST['item_name'];
  $item_description = $_POST['item_description'];
  $item_price = $_POST['item_price'];
  $item_cultures = $_POST['item_cultures'];
  $item_type = $_POST['item_type'];

  // Update query
  $sql = "UPDATE menu SET item_name='$item_name', item_description='$item_description', item_price='$item_price', item_cultures='$item_cultures', item_type='$item_type' WHERE id=$id";

  if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $conn->error;
  }

  $conn->close();
  header("Location: ../Pages/Admin_Dashbord.PHP"); // Redirect back to the table page
  exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM menu WHERE id=$id";
$result = $conn->query($sql);
$item = $result->fetch_assoc();
?>

<form method="POST" action="edit_menu_item.php">
  <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
  <label for="item_name">Item Name:</label>
  <input type="text" id="item_name" name="item_name" value="<?php echo $item['item_name']; ?>" required>
  <br>
  <label for="item_description">Description:</label>
  <input type="text" id="item_description" name="item_description" value="<?php echo $item['item_description']; ?>" required>
  <br>
  <label for="item_price">Price:</label>
  <input type="number" id="item_price" name="item_price" value="<?php echo $item['item_price']; ?>" step="0.01" required>
  <br>
  <label for="item_cultures">Food Cultures:</label>
  <input type="text" id="item_cultures" name="item_cultures" value="<?php echo $item['item_cultures']; ?>" required>
  <br>
  <label for="item_type">Meal Type:</label>
  <input type="text" id="item_type" name="item_type" value="<?php echo $item['item_type']; ?>" required>
  <br>
  <button type="submit">Update Item</button>
</form>
