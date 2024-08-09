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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $culture_name = $_POST['culture_name'];

    // Update the food_culture table
    $sql = "UPDATE food_culture SET culture_name=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $culture_name, $id);

    if ($stmt->execute()) {
        header("Location: ../Pages/ManageMenu.php");
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM food_culture WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $culture = $result->fetch_assoc();
    } else {
        echo "Culture not found.";
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Culture</title>
</head>

<body>
    <h1>Edit Culture</h1>
    <form action="edit_culture.php" method="post">
        <input type="hidden" name="id" value="<?php echo $culture['id']; ?>">
        <div>
            <label for="culture_name">Culture Name:</label>
            <input type="text" id="culture_name" name="culture_name" value="<?php echo $culture['culture_name']; ?>"
                required>
        </div>
        <button type="submit">Update</button>
    </form>
</body>

</html>