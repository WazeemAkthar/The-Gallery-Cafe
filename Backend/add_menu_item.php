<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name = $_POST['item_name'];
    $item_description = $_POST['item_description'];
    $item_price = $_POST['item_price'];
    $item_cultures = $_POST['item_cultures'];
    $item_type = $_POST['item_type'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["item_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["item_image"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO menu (item_name, item_description, item_price, item_cultures, item_type, item_image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdsss", $item_name, $item_description, $item_price, $item_cultures, $item_type, $target_file);

            if ($stmt->execute()) {
                header("Location: ../Pages/Menu.php");
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
}
?>