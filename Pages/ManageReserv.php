<?php
session_start();
if (!isset($_SESSION['role_id'])) {
    header("Location: login.html");
    exit();
}

// Define role IDs for staff and admin
$staffRoleId = 2; // Example: 2 = Staff
$adminRoleId = 3; // Example: 1 = Admin

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - The Gallery Café</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../CSS/Admin_Dashboard.css">
</head>

<style>
    /* Center the edit form */
    #editForm {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        border-radius: 8px;
    }

    /* Full-screen overlay for background blur */
    #overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(10px);
        /* Apply blur effect */
        z-index: 999;
    }


    #overlay,
    #editForm {
        transition: opacity 0.3s ease;
    }

    textarea {
        width: calc(100% - 20px);
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
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
            <div class="dashboard-item">
                <table id="reservations-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Guests</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Reservation rows will be inserted here by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="overlay"></div>

    <div class="form-container" id="editForm" style="display: none;">
        <h3>Edit Reservation</h3>
        <form id="reservationEditForm">
            <div class="form-style">
                <input type="hidden" id="editId">
                <div class="form-group">
                    <label for="editName">Name:</label>
                    <input type="text" id="editName" name="editName" required>
                </div>
                <div class="form-group">
                    <label for="editEmail">Email:</label>
                    <input type="email" id="editEmail" name="editEmail" required>
                </div>
                <div class="form-group">
                    <label for="editPhone">Phone Number:</label>
                    <input type="tel" id="editPhone" name="editPhone" required>
                </div>
                <div class="form-group">
                    <label for="editDate">Date:</label>
                    <input type="date" id="editDate" name="editDate" required>
                </div>
                <div class="form-group">
                    <label for="editTime">Time:</label>
                    <input type="time" id="editTime" name="editTime" required>
                </div>
                <div class="form-group">
                    <label for="editGuests">Number of Guests:</label>
                    <input type="number" id="editGuests" name="editGuests" min="1" max="8" required>
                </div>
                <div class="form-group">
                    <label for="editMessage">Special Requests:</label>
                    <textarea type="text" id="editMessage" name="editMessage" rows="2"></textarea>
                </div>
            </div>
            <div class="button-contaiiner">
                <button type="submit">Update Reservation</button>
                <button type="cancel" onclick="closeEditForm()">Close</button>
            </div>

        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetchReservations();
        });

        function fetchReservations() {
            fetch('../Backend/fetch_reservations.php')
                .then(response => response.json())
                .then(data => {
                    const reservationsTable = document.querySelector('#reservations-table tbody');
                    reservationsTable.innerHTML = '';
                    data.forEach(reservation => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${reservation.name}</td>
                            <td>${reservation.email}</td>
                            <td>${reservation.phone}</td>
                            <td>${reservation.date}</td>
                            <td>${reservation.time}</td>
                            <td>${reservation.guests}</td>
                            <td>
                                <button class='button-edit' onclick="editReservation(${reservation.id})"><i class='material-icons'>edit</i>Edit</button>
                                <button class='button-delete' onclick="deleteReservation(${reservation.id})"><i class='material-icons'>delete</i>Delete</button>
                            </td>
                        `;
                        reservationsTable.appendChild(row);
                    });
                });
        }

        function deleteReservation(id) {
            if (confirm('Are you sure you want to delete this reservation?')) {
                fetch('../Backend/delete_reservation.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}`
                })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        fetchReservations();
                    });
            }
        }

        // function editReservation(id) {
        //     const reservation = document.querySelector(`#reservation-${id}`);
        //     fetch(`../Backend/fetch_single_reservation.php?id=${id}`)
        //         .then(response => response.json())
        //         .then(data => {
        //             document.querySelector('#editId').value = data.id;
        //             document.querySelector('#editName').value = data.name;
        //             document.querySelector('#editEmail').value = data.email;
        //             document.querySelector('#editPhone').value = data.phone;
        //             document.querySelector('#editDate').value = data.date;
        //             document.querySelector('#editTime').value = data.time;
        //             document.querySelector('#editGuests').value = data.guests;
        //             document.querySelector('#editMessage').value = data.message;
        //             document.querySelector('#editForm').style.display = 'block';
        //         });
        // }

        function editReservation(id) {
            fetch(`../Backend/fetch_single_reservation.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    // Populate the form fields with reservation data
                    document.querySelector('#editId').value = data.id;
                    document.querySelector('#editName').value = data.name;
                    document.querySelector('#editEmail').value = data.email;
                    document.querySelector('#editPhone').value = data.phone;
                    document.querySelector('#editDate').value = data.date;
                    document.querySelector('#editTime').value = data.time;
                    document.querySelector('#editGuests').value = data.guests;
                    document.querySelector('#editMessage').value = data.message;

                    // Show the overlay and form
                    document.querySelector('#overlay').style.display = 'block';
                    document.querySelector('#editForm').style.display = 'block';
                });
        }

        function closeEditForm() {
            // Hide the overlay and form
            document.querySelector('#overlay').style.display = 'none';
            document.querySelector('#editForm').style.display = 'none';
        }

        // Hide the form and overlay when the user clicks outside the form
        document.querySelector('#overlay').addEventListener('click', closeEditForm);


        document.querySelector('#reservationEditForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const id = document.querySelector('#editId').value;
            const name = document.querySelector('#editName').value;
            const email = document.querySelector('#editEmail').value;
            const phone = document.querySelector('#editPhone').value;
            const date = document.querySelector('#editDate').value;
            const time = document.querySelector('#editTime').value;
            const guests = document.querySelector('#editGuests').value;
            const message = document.querySelector('#editMessage').value;

            fetch('../Backend/update_reservation.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}&name=${name}&email=${email}&phone=${phone}&date=${date}&time=${time}&guests=${guests}&message=${message}`
            })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    document.querySelector('#editForm').style.display = 'none';
                    fetchReservations();
                });
        });
    </script>
    <script>
        function navigateToPage() {
            window.location.href = "Home.php";
        }
        function logout() {
            window.location.href = "../Backend/logout.php";
        }
    </script>
    <script src="../JS/components.js"></script>
</body>

</html>