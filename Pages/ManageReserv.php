<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root"; // or your database username
$password = ""; // or your database password
$dbname = "thegallerycafe";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data
$sql = "SELECT id, item_name, item_description, item_price, item_cultures, item_type, item_image, created_at FROM menu";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reservation</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../CSS/Admin_Dashboard.css">

</head>
<!-- <style>
    button {
        background-color: #5bc0de;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 10px 20px;
        margin: 10px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .button-container {
        display: flex;
        width: 100%;
        justify-content: space-evenly;
        align-items: center;
    }

    /* Button styling */
    .button-container a button {
        flex: 1;
        padding: 10px 20px;
        border: none;
        background-color: #4caf50;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    /* Hover effect for buttons */
    .button-container a button:hover {
        background-color: #45a049;
    }

    /* Active (clicked) effect for buttons */
    .button-container a button:active,
    .button-container a button.active {
        background-color: #3e8e41;
        border-radius: 0;
    }
</style> -->

<body>
    <h1>Welcome, Admin <?php echo $_SESSION['name']; ?></h1>
    <div id="adminNav"></div>

    <script>
        function showDashboard(dashboardId) {
            var forms = document.getElementsByClassName("Dashbord-Container");
            for (var i = 0; i < forms.length; i++) {
                forms[i].style.display = "none";
            }
            document.getElementById(dashboardId).style.display = "block";

            // Remove 'active' class from all buttons
            const buttons = document.querySelectorAll('.button-container button');
            buttons.forEach(button => button.classList.remove('active'));

            // Add 'active' class to the clicked button
            const clickedButton = event.target;
            clickedButton.classList.add('active');
        }

        function showForm(formId) {
            document.getElementById('form1').classList.remove('active');
            document.getElementById('form2').classList.remove('active');
            document.getElementById('form3').classList.remove('active');
            document.getElementById('form4').classList.remove('active');
            document.getElementById('form5').classList.remove('active');
            document.getElementById('form6').classList.remove('active');
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

        function editItem(id) {
            // Redirect to an edit page with the item ID
            window.location.href = '../Backend/edit_menu_item.php?id=' + id;
        }

        function deleteItem(id) {
            if (confirm('Are you sure you want to delete this item?')) {
                // Send a request to delete the item
                window.location.href = '../Backend/delete_menu_item.php?id=' + id;
            }
        }
    </script>
    <script src="../JS/components.js"></script>
</body>

</html>