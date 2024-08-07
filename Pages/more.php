<?php
session_start();
if (!isset($_SESSION['role_id'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "thegallerycafe";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update slot status if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slot_id = $_POST['slot_id'];
    $new_status = $_POST['status'];
    $update_sql = "UPDATE parking_slots SET status='$new_status' WHERE id=$slot_id";
    $conn->query($update_sql);
}

// Fetch parking slot data
$sql = "SELECT * FROM parking_slots";
$result = $conn->query($sql);
$parking_slots = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Availability</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        p {
            font-size: 1.1em;
            color: #666;
            line-height: 1.6;
        }

        .parking-info {
            margin-bottom: 20px;
        }

        .parking-info h2 {
            font-size: 1.5em;
            color: #007bff;
            margin-bottom: 10px;
        }

        .contact-info {
            margin-top: 20px;
            text-align: center;
        }

        .contact-info a {
            color: #007bff;
            text-decoration: none;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        .parking-slots {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .slot {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            width: 150px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .slot.free {
            background-color: #d4edda;
        }

        .slot.occupied {
            background-color: #f8d7da;
        }

        .slot form {
            margin-top: 10px;
        }

        .slot button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .slot button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div id="header"></div>
    <div class="container">
        <h1>Parking Availability</h1>
        <div class="parking-info">
            <h2>On-Site Parking</h2>
            <p>We offer a limited number of on-site parking spaces for our customers. These are available on a
                first-come, first-served basis. Please look for the designated parking areas marked with our
                restaurant’s name.</p>
        </div>
        <div class="parking-info">
            <h2>Parking Slots</h2>
            <div class="parking-slots">
                <?php foreach ($parking_slots as $slot): ?>
                    <div class="slot <?php echo $slot['status']; ?>">
                        <h3><?php echo $slot['slot_name']; ?></h3>
                        <p>Status: <?php echo ucfirst($slot['status']); ?></p>
                        <form method="POST">
                            <input type="hidden" name="slot_id" value="<?php echo $slot['id']; ?>">
                            <select name="status">
                                <option value="free" <?php echo $slot['status'] == 'free' ? 'selected' : ''; ?>>Free</option>
                                <option value="occupied" <?php echo $slot['status'] == 'occupied' ? 'selected' : ''; ?>>
                                    Occupied</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="contact-info">
            <p>If you have any questions about parking, feel free to <a href="contact.php">contact us</a> or ask our
                staff when you arrive.</p>
        </div>
    </div>
</body>
<script src="../JS/components.js"></script>

</html>