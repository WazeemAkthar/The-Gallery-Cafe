<?php
session_start();
if (!isset($_SESSION['role_id'])) {
    header("Location: login.html");
    exit();
}

// Define role IDs for staff and admin
$staffRoleId = 2; // Example: 2 = Staff
$adminRoleId = 3; // Example: 1 = Admin


// Database connection details
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

// Fetch all user data
$sql = "SELECT users.id, users.name, users.email, roles.role_name 
        FROM users 
        JOIN roles ON users.role_id = roles.id";
$result = $conn->query($sql);

function getRoleColor($role)
{
    switch (strtolower($role)) {
        case 'admin':
            return '#28a745'; // Green for Admin
        case 'staff':
            return '#007bff'; // Blue for Staff
        case 'customer':
            return '#ffc107'; // Yellow for Customer
        default:
            return '#6c757d'; // Gray for other roles
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Menu</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../CSS/Admin_Dashboard.css">
</head>
<style>
    .container {
        width: 80%;
        margin: 20px auto;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 20px;
    }

    h1 {
        text-align: center;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #007bff;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #eaeaea;
    }

    .no-data {
        text-align: center;
        color: #777;
        padding: 20px;
    }

    .legend {
        margin-bottom: 20px;
        padding: 10px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .legend span {
        display: inline-block;
        margin-right: 10px;
        padding: 5px 10px;
        border-radius: 4px;
        color: white;
        font-weight: bold;
    }

    .role-admin {
        background-color: #28a745;
    }

    .role-staff {
        background-color: #007bff;
    }

    .role-customer {
        background-color: #ffc107;
        color: #333;
        /* Darker text color for better contrast */
    }

    .role-other {
        background-color: #6c757d;
    }
</style>

<body>
    <!-- <div id="adminNav"></div> -->
    <?php if ($_SESSION['role_id'] == $staffRoleId): ?>
        <!-- Display staff header if the user is a staff member -->
        <div id="staffheader"></div>
    <?php elseif ($_SESSION['role_id'] == $adminRoleId): ?>
        <!-- Display admin navbar if the user is an admin -->
        <div id="adminNav"></div>
    <?php else: ?>
        <!-- Display a default navbar or message if the user is neither staff nor admin -->
        <div id="defaultNav">You are not authorized to view this content.</div>
    <?php endif; ?>

    <button onclick="navigateToPage()" class="button-64" role="button"><span class="text">
            <i class="fa fa-home"></i> Back to home</span></button>

    <h1>Welcome, Admin <?php echo $_SESSION['name']; ?></h1>

    <div class="container">
        <h1>User Data</h1>

        <!-- Legend Section -->
        <div class="legend">
            <span class="role-admin">Admin</span>
            <span class="role-staff">Staff</span>
            <span class="role-other">user</span>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    $roleColor = getRoleColor($row['role_name']);
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td class='role' style='background-color:{$roleColor}; color: white;'>{$row['role_name']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='no-data'>No users found</td></tr>";
            }
            ?>
        </table>
    </div>

    <script src="../JS/components.js"></script>
    <script>
        function navigateToPage() {
            window.location.href = "Home.php";
        }
    </script>

</body>

</html>