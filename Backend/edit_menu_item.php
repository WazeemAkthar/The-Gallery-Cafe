<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $itemName = $_POST['item_name'];
    $itemDescription = $_POST['item_description'];
    $itemPrice = $_POST['item_price'];
    $itemCultures = $_POST['item_cultures'];
    $itemType = $_POST['item_type'];
    $itemImage = $_FILES['item_image']['name'];

    if (!empty($itemImage)) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($itemImage);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["item_image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if (file_exists($targetFile)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        if ($_FILES["item_image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $targetFile)) {
                $sql = "UPDATE menu SET item_name=?, item_description=?, item_price=?, item_cultures=?, item_type=?, item_image=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssdsssi", $itemName, $itemDescription, $itemPrice, $itemCultures, $itemType, $targetFile, $id);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $sql = "UPDATE menu SET item_name=?, item_description=?, item_price=?, item_cultures=?, item_type=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdssi", $itemName, $itemDescription, $itemPrice, $itemCultures, $itemType, $id);
    }

    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
