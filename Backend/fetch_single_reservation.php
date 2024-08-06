<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM reservations WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $reservation = $result->fetch_assoc();
        echo json_encode($reservation);
    } else {
        echo json_encode(["message" => "Reservation not found."]);
    }

    $stmt->close();
}

$conn->close();
?>