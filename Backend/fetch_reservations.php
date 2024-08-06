<?php
require_once 'db.php';

$result = $conn->query("SELECT * FROM reservations");

$reservations = [];
while ($row = $result->fetch_assoc()) {
    $reservations[] = $row;
}

echo json_encode($reservations);

$conn->close();
?>
