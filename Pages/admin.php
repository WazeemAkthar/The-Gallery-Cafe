<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
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
    <link rel="stylesheet" href="../CSS/admin.css">
    <title>Admin Dashboard - The Gallery Café</title>
</head>
<body>
    <div id="header"></div> <!-- Placeholder for header -->
    <h1>Welcome, Admin <?php echo $_SESSION['name']; ?></h1>
    <main>
        <h2>Admin Dashboard</h2>
        
        <div class="dashboard-container">
            <div class="dashboard-item">
                <h3>Manage Reservations</h3>
                <table id="reservations-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Reservation rows will be inserted here -->
                    </tbody>
                </table>
                <button id="add-reservation-btn">Add Reservation</button>
            </div>
            <div class="dashboard-item">
                <h3>Manage Menu</h3>
                <table id="menu-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Food Religion</th>
                            <th>Food Type</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Menu items will be inserted here -->
                    </tbody>
                </table>
                <button id="add-menu-item-btn">Add Menu Item</button>
            </div>
            <div class="dashboard-item">
                <h3>View Users</h3>
                <table id="users-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- User rows will be inserted here -->
                    </tbody>
                </table>
            </div>

            <div class="dashboard-item">
            <h2>Create Staff or Admin Account</h2>
    <form action="../Backend/create_account.php" method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <div class="form-group">
            <label for="role">Role:</label>
            <select id="role" name="role">
                <option value="2">Staff</option>
                <option value="3">Admin</option>
            </select>
        </div>
        <button type="submit">Create Account</button>
    </form>
            </div>
        </div>
    </main>
    
    <div id="footer"></div> <!-- Placeholder for footer -->
    
    <script src="../JS/components.js"></script>
    <script src="../JS/scripts.js"></script>
    <script src="../JS/admin.js"></script>
</body>
</html>
