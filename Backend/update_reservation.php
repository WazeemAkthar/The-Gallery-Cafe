<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("UPDATE reservations SET name = ?, email = ?, phone = ?, date = ?, time = ?, guests = ?, message = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", $name, $email, $phone, $date, $time, $guests, $message, $id);

    if ($stmt->execute()) {
        echo "Reservation updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
