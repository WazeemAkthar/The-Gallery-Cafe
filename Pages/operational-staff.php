<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/operational-staff.css">
    <title>Operational Staff Dashboard - The Gallery Café</title>
</head>

<body>
    <div id="staffheader"></div>
    <h1>Welcome, Staff <?php echo $_SESSION['name']; ?></h1>



    <div id="footer"></div> <!-- Placeholder for footer -->

    <script src="../JS/components.js"></script>
    <script src="../JS/scripts.js"></script>
    <script src="../JS/operational-staff.js"></script>
</body>

</html>