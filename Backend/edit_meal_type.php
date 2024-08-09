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

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the meal type data from the database
    $sql = "SELECT * FROM meal_type WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $meal = $result->fetch_assoc();
    } else {
        echo "Meal type not found";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $meal_type = $_POST['meal_type'];

    // Update the meal type in the database
    $sql = "UPDATE meal_type SET meal_type = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $meal_type, $id);

    if ($stmt->execute()) {
        header("Location: ../pages/ManageMenu.php");
    } else {
        echo "Error updating meal type: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Meal Type</title>
</head>
<body>
    <h1>Edit Meal Type</h1>
    <form action="edit_meal_type.php" method="post">
        <input type="hidden" name="id" value="<?php echo $meal['id']; ?>">
        <div>
            <label for="meal_type">Meal Type:</label>
            <input type="text" id="meal_type" name="meal_type" value="<?php echo $meal['meal_type']; ?>" required>
        </div>
        <button type="submit">Update Meal Type</button>
    </form>
</body>
</html>
