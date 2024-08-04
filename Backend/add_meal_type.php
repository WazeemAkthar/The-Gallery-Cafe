<?php
require_once 'db.php'; // Adjust the path as needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $meal_type = $_POST['item-name'];

    $stmt = $conn->prepare("INSERT INTO meal_type (meal_type) VALUES (?)");
    $stmt->bind_param("s", $meal_type);

    if ($stmt->execute()) {
        echo "New food culture added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>