<?php
require_once 'db.php'; // Adjust the path as needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $culture_name = $_POST['item-name'];

    $stmt = $conn->prepare("INSERT INTO food_culture (culture_name) VALUES (?)");
    $stmt->bind_param("s", $culture_name);

    if ($stmt->execute()) {
        header("Location: ../Pages/ManageMenu.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>