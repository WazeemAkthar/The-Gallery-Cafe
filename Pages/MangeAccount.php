<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    header("Location: login.html");
    exit();
}

require_once '../Backend/db.php';

// Fetch users where role is Staff (2) or Admin (3)
$sql_users = "SELECT id, name, email, role_id FROM users WHERE role_id IN (2, 3)";
$result_users = $conn->query($sql_users);
$users = [];
while ($row = $result_users->fetch_assoc()) {
    $users[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../CSS/Admin_Dashboard.css">
    <title>Admin Dashboard - The Gallery Café</title>
</head>

<body>
    <div id="adminNav"></div>
    <div class="adminCheckbtn">
        <button onclick="navigateToPage()" class="button-64" role="button"><span class="text">
                <i class="fa fa-home"></i> Back to home</span></button>
        <button onclick="logout()" class="button-64" role="button"><span class="text">
                Logout <i class="fa fa-sign-out"></i></span></button>
    </div>

    <div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>
    (<?php echo htmlspecialchars($_SESSION['role_name']); ?>)</h1>
        <div class="dashboard-container">
            <div id="form1" class="form-container">
                <h2>Create a New Account</h2>
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
                    <div class="button-contaiiner">
                        <button type="submit">Create Account</button>
                        <button type="cancel" onclick="showForm(null)">Cancel</button>
                    </div>
                </form>
            </div>
            <div class="table-card">
                <div class="table-container Foods-And-Drinks">

                    <div class="title1">
                        <h2>Staffs and Admins Accounts</h2>
                        <button class="button-add" onclick="showForm('form1')">
                            <i class="material-icons">add</i>
                            Create Staff and Admin Accounts
                        </button>

                    </div>
                    <table class="w3-table w3-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo $user['role_id'] == 2 ? 'Staff' : 'Admin'; ?></td>
                                    <td>
                                        <button class="button-edit" onclick="editUser(<?php echo $user['id']; ?>)"><i
                                                class='material-icons'>edit</i>Edit</button>
                                        <button class="button-delete" onclick="deleteUser(<?php echo $user['id']; ?>)"><i
                                                class='material-icons'>delete</i>Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="formOverlay" class="form-overlay"></div>

    <script src="../JS/components.js"></script>
    <script src="../JS/scripts.js"></script>
    <script>
        function showForm(formId) {
            document.getElementById('form1').classList.remove('active');
            document.getElementById('formOverlay').classList.remove('active');
            if (formId) {
                document.getElementById(formId).classList.add('active');
                document.getElementById('formOverlay').classList.add('active');
            }
        }

        showForm(null);

        document.getElementById('formOverlay').addEventListener('click', function () {
            showForm(null);
        });

        function editUser(id) {
            // Redirect to an edit page with the user ID
            window.location.href = '../Backend/edit_user.php?id=' + id;
        }

        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                // Send a request to delete the user
                window.location.href = '../Backend/delete_user.php?id=' + id;
            }
        }
    </script>
    <script>
        function navigateToPage() {
            window.location.href = "Home.php";
        }
        function logout() {
            window.location.href = "../Backend/logout.php";
        }
    </script>
</body>

</html>