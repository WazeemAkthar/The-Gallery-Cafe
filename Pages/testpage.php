<?php
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
    <title>User Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

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

        .role {
            font-weight: bold;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .no-data {
            text-align: center;
            color: #777;
            padding: 20px;
        }
    </style>
</head>

<body>
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
                    echo "<td class='role' style='background-color:{$roleColor};'>{$row['role_name']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='no-data'>No users found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>

<?php
// Close the connection
$conn->close();
?>